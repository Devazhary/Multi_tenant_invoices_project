<?php

namespace App\Exports;

use App\Models\invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoiceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoice::select('invoice_number', 'invoice_date', 'due_date', 'product', 'discount', 'amount_collection', 'amount_commission', 'rate_vat', 'value_vat', 'total', 'status', 'payment_date', 'note', 'user')->get();
    }
}
