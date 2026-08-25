<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerReportService;

class CustomerReportController extends Controller
{
    protected CustomerReportService $customerReportService;

    public function __construct(CustomerReportService $customerReportService)
    {
        $this->customerReportService = $customerReportService;
    }

    /**
     * Display the customer report page with filters.
     */
    public function index(Request $request)
    {
        $filters = [
            'date_from'  => $request->input('date_from'),
            'date_to'    => $request->input('date_to'),
            'section_id' => $request->input('section_id'),
            'product'    => $request->input('product'),
        ];

        $data = $this->customerReportService->getCustomerReportData($filters);

        return view('reports.customers-report', $data);
    }
}
