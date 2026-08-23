<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\InvoiceAttachments;
use App\Models\InvoicesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = invoice::withTrashed()->findOrFail($id);
        $invoiceDetails = InvoicesDetails::where('invoice_id', $id)->get();
        $invoiceAttachments = InvoiceAttachments::where('invoice_id', $id)->get();

        return view('invoices.invoice-details', compact('invoice', 'invoiceDetails', 'invoiceAttachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoicesDetails $invoicesDetails)
    {
        //
    }

    public function showInvoiceAttachment(string $id)
    {
        $attachment = InvoiceAttachments::findOrFail($id);
        $filePath = storage_path('app/public/uploads/' . $attachment->invoice_number . '/' . $attachment->file_name);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadInvoiceAttachment(string $id)
    {
        $attachment = InvoiceAttachments::findOrFail($id);
        $filePath = storage_path('app/public/uploads/' . $attachment->invoice_number . '/' . $attachment->file_name);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
