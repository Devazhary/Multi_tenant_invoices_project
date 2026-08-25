<?php

namespace App\Repositories;

use App\Models\invoice;
use App\Models\Section;

class CustomerReportRepository
{
    /**
     * Get invoices filtered by date range, section, and product.
     */
    public function getFilteredInvoices(
        ?string $dateFrom,
        ?string $dateTo,
        ?int $sectionId,
        ?string $product
    ) {
        $query = invoice::with('section');

        // Customer reports usually require Section and Product at minimum
        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        if ($product && $product !== '') {
            $query->where('product', $product);
        }

        if ($dateFrom) {
            $query->whereDate('invoice_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('invoice_date', '<=', $dateTo);
        }

        // If no section and product are provided, we might return empty to force the user to search,
        // or return all if that's preferred. We'll return the query directly.
        // It's usually better to only fetch if searched, but to match InvoiceReport, we'll return all initially or based on query.
        
        return $query->orderBy('invoice_date', 'desc')->get();
    }

    /**
     * Get summary statistics for the filtered invoices.
     */
    public function getSummaryStatistics(
        ?string $dateFrom,
        ?string $dateTo,
        ?int $sectionId,
        ?string $product
    ): array {
        $query = invoice::query();

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        if ($product && $product !== '') {
            $query->where('product', $product);
        }

        if ($dateFrom) {
            $query->whereDate('invoice_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('invoice_date', '<=', $dateTo);
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
     * Get all sections for the filter dropdown.
     */
    public function getAllSections()
    {
        return Section::orderBy('section_name')->get();
    }
}
