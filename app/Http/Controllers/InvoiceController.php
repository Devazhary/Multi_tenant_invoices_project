<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Http\Requests\InvoiceRequest;
use App\Models\invoice;
use App\Models\InvoiceAttachments;
use App\Models\InvoicesDetails;
use App\Models\Section;
use App\Models\User;
use App\Notifications\CreateInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoice::with('section')->orderBy('created_at', 'desc')->get();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add-invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $validatedData = $request->validated();

        $sectionName = Section::where('id', $request->section_id)->value('section_name');

        try {

            DB::beginTransaction();

            $validatedData['user'] = auth('web')->user()->name;
            $validatedData['status'] = 'غير مدفوعة';
            $validatedData['value_status'] = 2;

            $invoice = invoice::create($validatedData);

            $invoiceDetails = InvoicesDetails::create([
                'invoice_number' => $invoice->invoice_number,
                'invoice_id' => $invoice->id,
                'product' => $request->product,
                'section' => $sectionName,
                'status' => 'غير مدفوعة',
                'value_status' => 2,
                'payment_date' => 'not implemented',
                'note' => $request->note,
                'user' => auth('web')->user()->name,
            ]);

            if ($request->hasFile('pic')) {
                $file = $request->file('pic');
                $extension = $file->getClientOriginalExtension();
                $newFilename = Str::uuid() . '.' . $extension;
                $path = $file->storeAs('uploads/' . $invoice->invoice_number, $newFilename, 'public');

                InvoiceAttachments::create([
                    'file_name' => $newFilename,
                    'invoice_number' => $invoice->invoice_number,
                    'Created_by' => auth('web')->user()->name,
                    'invoice_id' => $invoice->id,
                ]);
            }

            $admins = User::role('مدير النظام')->where('id', '!=' ,auth('web')->user()->id)->get();
            foreach($admins as $admin)
            {
                $admin->notify(new CreateInvoice($invoice));
            }

            DB::commit();
            return redirect()->back()->with('success', 'تم حفظ الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            // return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit-invoice', compact('sections', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            $invoice->update($validatedData);

            // Update invoice details if product or section changed
            $sectionName = Section::where('id', $request->section_id)->value('section_name');
            InvoicesDetails::where('invoice_id', $invoice->id)->update([
                'product' => $request->product,
                'section' => $sectionName,
                'note' => $request->note,
            ]);

            DB::commit();
            return redirect()->back()->with('edit', 'تم تعديل الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice $invoice)
    {
        try {
            DB::beginTransaction();
            $path = 'uploads/' . $invoice->invoice_number;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->deleteDirectory($path);
            }
            $invoiceId = $invoice->id;
            InvoiceAttachments::where('invoice_id', $invoiceId)->delete();
            $deleted = $invoice->forceDelete();

            if ($deleted) {
                DB::commit();
                return redirect()->back()->with('success', 'تم حذف الفاتورة بنجاح');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الفاتورة: ' . $e->getMessage());
        }

        //force delete

    }

    public function getproducts(string $id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function paidInvoices()
    {
        $invoices = invoice::where('value_status', 1)->get();
        return view('invoices.paid-invoices', compact('invoices'));
    }

    public function unpaidInvoices()
    {
        $invoices = invoice::where('value_status', 2)->get();
        return view('invoices.unpaid-invoices', compact('invoices'));
    }

    public function partialPaidInvoices()
    {
        $invoices = invoice::where('value_status', 3)->get();
        return view('invoices.partial-paid-invoices', compact('invoices'));
    }

    public function archivedInvoices()
    {
        $invoices = invoice::onlyTrashed()->get();
        return view('invoices.archived-invoices', compact('invoices'));
    }

    public function archiveInvoice(string $id)
    {
        $invoice = invoice::findOrFail($id);
        $checked = $invoice->delete();
        if ($checked) {
            return redirect()->back()->with('success', 'تم أرشفة الفاتورة بنجاح');
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء أرشفة الفاتورة');
        }
    }

    public function unArchiveInvoice(string $id)
    {
        $invoice = invoice::withTrashed()->findOrFail($id);
        $checked = $invoice->restore();
        if ($checked) {
            return redirect()->back()->with('success', 'تم استعادة الفاتورة بنجاح');
        } else {
            return redirect()->back()->with('error', 'حدث خطأ أثناء استعادة الفاتورة');
        }
    }

    public function deleteArchivedInvoice(string $id)
    {
        try {
            DB::beginTransaction();
            $invoice = invoice::withTrashed()->findOrFail($id);
            $path = 'uploads/' . $invoice->invoice_number;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->deleteDirectory($path);
            }
            InvoiceAttachments::where('invoice_id', $invoice->id)->delete();
            $deleted = $invoice->forceDelete();

            if ($deleted) {
                DB::commit();
                return redirect()->back()->with('success', 'تم حذف الفاتورة المؤرشفة بنجاح');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الفاتورة: ' . $e->getMessage());
        }
    }
    public function status_show($id)
    {
        $invoice = invoice::where('id', $id)->first();
        return view('invoices.status_update', compact('invoice'));
    }

    public function status_update($id, Request $request)
    {
        $invoice = invoice::findOrFail($id);

        try {
            DB::beginTransaction();

            $status = $request->Status;
            $payment_date = $request->Payment_Date;

            if ($status === 'مدفوعة') {
                $value_status = 1;
            } else {
                $value_status = 3;
            }

            $invoice->update([
                'status' => $status,
                'value_status' => $value_status,
                'payment_date' => $payment_date,
            ]);

            InvoicesDetails::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'product' => $invoice->product,
                'section' => $invoice->section->section_name,
                'status' => $status,
                'value_status' => $value_status,
                'note' => $invoice->note,
                'payment_date' => $payment_date,
                'user' => (auth('web')->user()->name ?? 'System'),
            ]);

            DB::commit();
            return redirect('/invoices')->with('success', 'تم تحديث حالة الدفع بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function printInvoice($id)
    {
        $invoice = invoice::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoice'));
    }

    public function export()
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }
}
