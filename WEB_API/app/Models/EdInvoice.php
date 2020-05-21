<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdInvoice extends Model
{
    protected $table = 'ed_invoice';
    protected $primaryKey = 'invoice_id';
    public $incrementing = false;
    protected $guarded = [''];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $keyType = 'string';
    protected $appends = ['amount_summary'];

    // 关联ed_invoce_charge
    public function charges()
    {
        return $this->hasMany('App\Models\EdInvoiceCharge','invoice_id','invoice_id');
    }

    // 虚拟附加字段
    public function getAmountSummaryAttribute()
    {
        return $this->charges()->sum('base_amount');
    }
}
