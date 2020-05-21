<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdInvoiceCharge extends Model
{
    protected $table = 'ed_invoice_charge';
    protected $primaryKey = 'charge_id';
    public $incrementing = false;
    protected $guarded = [''];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $keyType = 'string';

}
