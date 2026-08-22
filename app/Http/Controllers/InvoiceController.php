<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\invoice;
use App\Models\InvoiceAttachments;
use App\Models\InvoicesDetails;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('invoices.invoices');
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
                $path = $file->storeAs('uploads', $newFilename, 'public');

                InvoiceAttachments::create([
                    'file_name' => $newFilename,
                    'invoice_number' => $invoice->invoice_number,
                    'Created_by' => auth('web')->user()->name,
                    'invoice_id' => $invoice->id,
                ]);
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
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice $invoice)
    {
        //
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
}
