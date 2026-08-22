<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicesDetails extends Model
{
    protected $table = 'invoices_details';

    protected $fillable = [
        'invoice_number',
        'invoice_id',
        'product',
        'section',
        'status',
        'value_status',
        'payment_date',
        'note',
        'user',
    ];
}
