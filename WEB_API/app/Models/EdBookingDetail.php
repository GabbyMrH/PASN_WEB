<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdBookingDetail extends Model
{
        /**
     * 预约入库
     */
    protected $table = 'ed_booking_detail';
    protected $primaryKey = 'inboundid';
    public $incrementing = false;
    //定义时间戳字段
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';

    protected $fillable = [
        'booking_id','po_no','qty_case','case_length','case_width','case_lenght','case_weight'
    ];

    // 对应关联booking
    public function booking()
    {
        return $this->belongsTo('App\Models\EdBooking','booking_id');
    }
}
