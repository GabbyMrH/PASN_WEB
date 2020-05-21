<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdOutboundDetail extends Model
{
    protected $table = 'ed_outbound_detail';
    public $incrementing = false;
    protected $guarded = [''];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
