<?php

namespace App\Services;

use App\Repositories\CustomerReportRepository;

class CustomerReportService
{
    protected CustomerReportRepository $customerReportRepository;

    public function __construct(CustomerReportRepository $customerReportRepository)
    {
        $this->customerReportRepository = $customerReportRepository;
    }

    /**
     * Get all data needed for the customer report page.
     */
    public function getCustomerReportData(array $filters): array
    {
        $dateFrom  = $filters['date_from']  ?? null;
        $dateTo    = $filters['date_to']    ?? null;
        $sectionId = !empty($filters['section_id']) ? (int) $filters['section_id'] : null;
        $product   = $filters['product']    ?? null;

        $invoices = [];
        $stats = [
            'total_count'    => 0,
            'total_sum'      => 0.0,
            'paid_count'     => 0,
            'paid_sum'       => 0.0,
            'unpaid_count'   => 0,
            'unpaid_sum'     => 0.0,
            'partial_count'  => 0,
            'partial_sum'    => 0.0,
            'total_discount' => 0.0,
            'total_vat'      => 0.0,
        ];

        // Usually, customer reports require selecting at least the section to show data.
        // If not selected, we return empty collections to prompt the user to search.
        if ($sectionId) {
            $invoices = $this->customerReportRepository->getFilteredInvoices($dateFrom, $dateTo, $sectionId, $product);
            $stats    = $this->customerReportRepository->getSummaryStatistics($dateFrom, $dateTo, $sectionId, $product);
        } else {
            $invoices = collect([]);
        }

        $sections = $this->customerReportRepository->getAllSections();

        return [
            'invoices' => $invoices,
            'stats'    => $stats,
            'sections' => $sections,
            'filters'  => $filters,
        ];
    }
}
