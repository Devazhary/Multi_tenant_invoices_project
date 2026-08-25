<?php

namespace App\Services;

use App\Repositories\InvoiceReportRepository;

class InvoiceReportService
{
    protected InvoiceReportRepository $invoiceReportRepository;

    public function __construct(InvoiceReportRepository $invoiceReportRepository)
    {
        $this->invoiceReportRepository = $invoiceReportRepository;
    }

    /**
     * Get all data needed for the invoice report page.
     */
    public function getInvoiceReportData(array $filters): array
    {
        $dateFrom  = $filters['date_from']  ?? null;
        $dateTo    = $filters['date_to']    ?? null;
        $status    = $filters['status']     ?? null;
        $sectionId = !empty($filters['section_id']) ? (int) $filters['section_id'] : null;

        $invoices   = $this->invoiceReportRepository->getFilteredInvoices($dateFrom, $dateTo, $status, $sectionId);
        $stats      = $this->invoiceReportRepository->getSummaryStatistics($dateFrom, $dateTo, $status, $sectionId);
        $monthly    = $this->invoiceReportRepository->getMonthlyBreakdown($dateFrom, $dateTo, $status, $sectionId);
        $sections   = $this->invoiceReportRepository->getAllSections();

        $chartLabels = [];
        $chartCounts = [];
        $chartTotals = [];

        $arabicMonths = [
            1  => 'يناير', 2  => 'فبراير', 3  => 'مارس',
            4  => 'أبريل', 5  => 'مايو',   6  => 'يونيو',
            7  => 'يوليو', 8  => 'أغسطس',  9  => 'سبتمبر',
            10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
        ];

        foreach ($monthly as $row) {
            $chartLabels[] = ($arabicMonths[$row['month']] ?? $row['month']) . ' ' . $row['year'];
            $chartCounts[] = $row['count'];
            $chartTotals[] = round($row['total_sum'], 2);
        }

        return [
            'invoices'     => $invoices,
            'stats'        => $stats,
            'sections'     => $sections,
            'chartLabels'  => $chartLabels,
            'chartCounts'  => $chartCounts,
            'chartTotals'  => $chartTotals,
            'filters'      => $filters,
        ];
    }
}
