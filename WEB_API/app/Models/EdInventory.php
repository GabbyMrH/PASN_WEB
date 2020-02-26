<?php

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class EdInventory extends Model
{
    /**
     * 指定表名
     */
    protected $table = 'ed_inventory';

    /**
     * 定义主键名称
     */
    protected $primaryKey = 'PKID';

    /**
     * 指示模型主键是否递增
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * 主键ID的“类型”。
     *
     * @var string
     */
    protected $keyType = 'string';

    public static $customer_id;


    public function __construct()
    {
        self::$customer_id = Auth::user()->ed_customer_customer_id;
        if(!self::$customer_id){
            false;
        }
    }

    //数据处理
    public function dataList($req_data)
    {
        //过滤page和page_limit筛选条件
        $filter_condition = Arr::except($req_data, ['page', 'page_limit']);
            // 返回最高级别所有数据
            if(self::$customer_id == CustomerType::admin){
                return self::where($filter_condition)->orderBy('create_date', 'DESC')->paginate($req_data['page_limit']);
            }
                //默认值则判断传递参数返回对应数据
                return self::where($filter_condition)
                    ->where('customer_id',self::$customer_id)
                    ->orderBy('create_date', 'DESC')
                    ->paginate($req_data['page_limit']);
    }

    //dashboard 总量
    public function total()
    {
        return $this->count();
    }
}
