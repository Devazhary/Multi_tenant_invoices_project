<?php

namespace App\Repositories;

use App\Models\invoice;

class InvoiceRepository
{
    public function getTotalCount(): int
    {
        return invoice::count();
    }

    public function getTotalSum(): float
    {
        return invoice::sum('total') ?? 0.0;
    }

    public function getCountByStatusValue(int $statusValue): int
    {
        return invoice::where('value_status', $statusValue)->count();
    }

    public function getSumByStatusValue(int $statusValue): float
    {
        return invoice::where('value_status', $statusValue)->sum('total') ?? 0.0;
    }

    public function getRecentInvoices(int $limit = 5)
    {
        return invoice::latest()->take($limit)->get();
    }
}
