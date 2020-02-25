<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EdBooking extends Model
{
    /**
     * 预约入库
     */
    protected $table = 'ed_booking';
    protected $primaryKey = 'booking_id';
    public $incrementing = false;

    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany('App\Models\EdBookingDetail', 'booking_id');
    }

    public function queryList($data)
    {
        //强烈提示：以后数据库主外键设计需要严格遵照国际化标准，如表A主键为'id'，AB表相互关联则表B外键为'a_id'的形式
        //若AB表相关联出现相同字段，会出现join查询报bug等错误

        //指定返回数据--不指定会报错，这是因为主从表有相同字段导致会报错(数据库设计问题)
        $result_condition = [
            'ed_booking_detail.*',
            'ed_booking.customer_id','ed_booking.booking_no','ed_booking.warehouse_code','ed_booking.order_qty',
            'ed_booking.booking_date','ed_booking.booking_status'
        ] ;

        $filter_condition = Arr::except($data,['page','page_limit']);
        return $this->where($filter_condition)
            ->join('ed_booking_detail', 'ed_booking.booking_id', '=', 'ed_booking_detail.booking_id')
            ->select($result_condition)
            ->orderBy('ed_booking_detail.create_date','DESC')
            ->paginate($data['page_limit']);
    }

    /**
     * @param $req_data 请求参数
     * @return mixed 返回关联数据
     */
    public function dataList($req_data)
    {
        //需要过滤page和page_limit查询条件
        //如果有传递筛选参数

        //指定返回数据
        $result_condition = [
            'ed_booking.*'
        ];
        if (Arr::has($req_data, ['start_time', 'end_time'])) {
            //作为查询条件时，需要删除下示数组数据，否则会作为查询条件一起传入
            $filter_condition = Arr::except($req_data, ['page', 'page_limit', 'start_time', 'end_time']);
            // 相对复杂的查询，包含了条件筛选、join联接、排序、分页
            return $this->where($filter_condition)
                    ->whereBetween('ed_booking.create_date', [$req_data['start_time'], $req_data['end_time']])
                    ->join('ed_booking_detail', 'ed_booking.booking_id', '=', 'ed_booking_detail.booking_id')
                    ->select($result_condition)
                    ->orderBy('ed_booking.create_date', 'DESC')
                    ->paginate($req_data['page_limit']);
        }
        //如果没有传递筛选参数
        $filter_condition = Arr::except($req_data, ['page', 'page_limit']);
        return $this->where($filter_condition)
            ->join('ed_booking_detail', 'ed_booking.booking_id', '=', 'ed_booking_detail.booking_id')
            ->select($result_condition)
            ->orderBy('ed_booking.create_date', 'DESC')
            ->paginate($req_data['page_limit']);
    }
}
