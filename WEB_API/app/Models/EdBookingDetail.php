<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

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

    // 编辑detail
    public function queryEdit($query)
    {
        $filterData = Arr::except($query,['inboundid']);
        $decodeData = json_decode($filterData['booking_detail'][0],true);
        try {
            EdBookingDetail::where('inboundid',$query['inboundid'])->update($decodeData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;

    }
    // 删除detail
    public function queryDelete($query)
    {
        try {
            $this->where([
                'inboundid'=>$query['inboundid']
            ])->delete();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
}
