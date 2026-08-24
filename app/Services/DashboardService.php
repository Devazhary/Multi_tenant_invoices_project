<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;

class DashboardService
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function getDashboardStatistics(): array
    {
        $totalCount = $this->invoiceRepository->getTotalCount();
        
        $paidCount = $this->invoiceRepository->getCountByStatusValue(1);
        $unpaidCount = $this->invoiceRepository->getCountByStatusValue(2);
        $partialCount = $this->invoiceRepository->getCountByStatusValue(3);

        $totalSum = $this->invoiceRepository->getTotalSum();
        $paidSum = $this->invoiceRepository->getSumByStatusValue(1);
        $unpaidSum = $this->invoiceRepository->getSumByStatusValue(2);
        $partialSum = $this->invoiceRepository->getSumByStatusValue(3);

        $recentInvoices = $this->invoiceRepository->getRecentInvoices();

        return [
            'total_count' => $totalCount,
            'total_sum' => $totalSum,
            'paid_count' => $paidCount,
            'paid_sum' => $paidSum,
            'unpaid_count' => $unpaidCount,
            'unpaid_sum' => $unpaidSum,
            'partial_count' => $partialCount,
            'partial_sum' => $partialSum,
            'paid_percent' => $totalCount > 0 ? round(($paidCount / $totalCount) * 100, 2) : 0,
            'unpaid_percent' => $totalCount > 0 ? round(($unpaidCount / $totalCount) * 100, 2) : 0,
            'partial_percent' => $totalCount > 0 ? round(($partialCount / $totalCount) * 100, 2) : 0,
            'recent_invoices' => $recentInvoices,
        ];
    }
}
