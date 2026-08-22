<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAttachments extends Model
{
    protected $table = 'invoice_attachments';

    protected $fillable = [
        'file_name',
        'invoice_number',
        'Created_by',
        'invoice_id',
    ];
}
