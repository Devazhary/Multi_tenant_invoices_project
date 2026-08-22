<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|mimes:pdf,jpeg,png,jpg|max:10000',
            'invoice_id' => 'required|integer|exists:invoices,id',
            'invoice_number' => 'required|string',
        ], [
            'file_name.required' => 'يرجى إرفاق الملف.',
            'file_name.mimes' => 'صيغة المرفق يجب أن تكون pdf, jpeg, png, jpg.',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file_name');
            $extension = $file->getClientOriginalExtension();
            $newFilename = \Illuminate\Support\Str::uuid() . '.' . $extension;
            
            $file->storeAs('uploads/' . $request->invoice_number, $newFilename, 'public');

            InvoiceAttachments::create([
                'file_name' => $newFilename,
                'invoice_number' => $request->invoice_number,
                'Created_by' => auth('web')->user()->name,
                'invoice_id' => $request->invoice_id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'تم إضافة المرفق بنجاح');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المرفق: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceAttachments $invoiceAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoiceAttachments = InvoiceAttachments::findOrFail($id);
        try {
            DB::beginTransaction();
            $path = 'uploads/' . $invoiceAttachments->invoice_number . '/' . $invoiceAttachments->file_name;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $invoiceAttachments->delete();
            DB::commit();
            return redirect()->back()->with('success', 'تم حذف المرفق بنجاح.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف المرفق: ' . $e->getMessage());
        }
    }
}
