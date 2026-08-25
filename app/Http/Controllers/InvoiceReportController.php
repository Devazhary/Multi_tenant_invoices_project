<?php

namespace App\Http\Controllers;

use App\Services\InvoiceReportService;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    protected InvoiceReportService $invoiceReportService;

    public function __construct(InvoiceReportService $invoiceReportService)
    {
        $this->invoiceReportService = $invoiceReportService;
    }

    /**
     * Display the invoice report page with optional filters.
     */
    public function index(Request $request)
    {
        $request->validate([
            'date_from'  => ['nullable', 'date'],
            'date_to'    => ['nullable', 'date', 'after_or_equal:date_from'],
            'status'     => ['nullable', 'in:1,2,3'],
            'section_id' => ['nullable', 'integer', 'exists:sections,id'],
        ]);

        $filters = [
            'date_from'  => $request->input('date_from'),
            'date_to'    => $request->input('date_to'),
            'status'     => $request->input('status'),
            'section_id' => $request->input('section_id'),
        ];

        $data = $this->invoiceReportService->getInvoiceReportData($filters);

        return view('reports.invoices-report', $data);
    }
}
