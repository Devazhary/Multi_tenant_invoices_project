<?php

namespace App\Repositories;

use App\Models\invoice;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class InvoiceReportRepository
{
    /**
     * Get invoices filtered by date range, status, and section.
     */
    public function getFilteredInvoices(
        ?string $dateFrom,
        ?string $dateTo,
        ?string $status,
        ?int $sectionId
    ) {
        $query = invoice::with('section');

        if ($dateFrom) {
            $query->whereDate('invoice_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('invoice_date', '<=', $dateTo);
        }

        if ($status !== null && $status !== '') {
            $query->where('value_status', $status);
        }

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        return $query->orderBy('invoice_date', 'desc')->get();
    }

    /**
     * Get summary statistics for the filtered invoices.
     */
    public function getSummaryStatistics(
        ?string $dateFrom,
        ?string $dateTo,
        ?string $status,
        ?int $sectionId
    ): array {
        $query = invoice::query();

        if ($dateFrom) {
            $query->whereDate('invoice_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('invoice_date', '<=', $dateTo);
        }

        if ($status !== null && $status !== '') {
            $query->where('value_status', $status);
        }

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        return [
            'total_count'    => (clone $query)->count(),
            'total_sum'      => (clone $query)->sum('total') ?? 0.0,
            'paid_count'     => (clone $query)->where('value_status', 1)->count(),
            'paid_sum'       => (clone $query)->where('value_status', 1)->sum('total') ?? 0.0,
            'unpaid_count'   => (clone $query)->where('value_status', 2)->count(),
            'unpaid_sum'     => (clone $query)->where('value_status', 2)->sum('total') ?? 0.0,
            'partial_count'  => (clone $query)->where('value_status', 3)->count(),
            'partial_sum'    => (clone $query)->where('value_status', 3)->sum('total') ?? 0.0,
            'total_discount' => (clone $query)->sum('discount') ?? 0.0,
            'total_vat'      => (clone $query)->sum('value_vat') ?? 0.0,
        ];
    }

    /**
     * Get monthly breakdown of invoices for chart data (respects all active filters).
     */
    public function getMonthlyBreakdown(
        ?string $dateFrom,
        ?string $dateTo,
        ?string $status = null,
        ?int    $sectionId = null
    ): array {
        $query = invoice::select(
                DB::raw('YEAR(invoice_date) as year'),
                DB::raw('MONTH(invoice_date) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as total_sum')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');

        if ($dateFrom) {
            $query->whereDate('invoice_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('invoice_date', '<=', $dateTo);
        }

        if ($status !== null && $status !== '') {
            $query->where('value_status', $status);
        }

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        return $query->get()->toArray();
    }

    /**
     * Get all sections for the filter dropdown.
     */
    public function getAllSections()
    {
        return Section::orderBy('section_name')->get();
    }
}
