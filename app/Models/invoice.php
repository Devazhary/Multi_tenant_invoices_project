<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'section_id',
        'invoice_date',
        'due_date',
        'product',
        'discount',
        'amount_collection',
        'amount_commission',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'payment_date',
        'note',
        'user',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
