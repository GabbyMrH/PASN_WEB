<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdOutboundOrder extends Model
{
    protected $table = 'ed_outbound_order';
    protected $primaryKey = 'issue_id';
    public $incrementing = false;
    protected $guarded = [''];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $keyType = 'string';

    /**
     * @return 一对多关联detail表
     */
    public function details()
    {
        return $this->hasMany('App\Models\EdOutboundDetail', 'issue_id', 'issue_id');
    }
}
