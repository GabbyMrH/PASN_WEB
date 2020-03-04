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
     * @var string
     */
    protected $table = 'ed_inventory';

    /**
     * 定义主键名称
     * @var string
     */
    protected $primaryKey = 'PKID';

    /**
     * 指示模型主键是否递增
     * @var bool
     */
    public $incrementing = false;

    /**
     * 主键ID的“类型”。
     * @var string
     */
    protected $keyType = 'string';

    /**
     * customerID对应用户类型
     * @var string
     */
    public static $customerID;

    public function __construct()
    {
        self::$customerID = Auth::user()->ed_customer_customer_id;
        if (!self::$customerID) {
            false;
        }
    }

    /**
     * @param $requestData 控制器传递参数
     * @return 调用对应方法返回数据
     */
    public function queryList($requestData)
    {
        //过滤page和page_limit筛选条件
        $filterCondition = Arr::except($requestData,['page', 'page_limit']);
        if($filterCondition){
            return $this->queryListWithinParams($requestData,$filterCondition);
        }
        return $this->queryListWithoutParams($requestData);
    }

    // 当queryList()有其他(除page、page_limit)参数传入时
    private function queryListWithinParams($requestData,$filterData)
    {
        // 判断登录用户角色
        if (self::$customerID == CustomerType::admin) {
            return $this->where($filterData)->orderBy('create_date', 'DESC')->paginate($requestData['page_limit']);
        }
        //默认值则判断传递参数返回对应数据
        return $this->where($filterData)
            ->where('customer_id', self::$customerID)
            ->orderBy('create_date', 'DESC')
            ->paginate($requestData['page_limit']);
    }

    // 当queryList()无其他参数(除page、page_limit)传入时
    private function queryListWithoutParams($requestData)
    {
        // 判断登录用户角色
        if (self::$customerID == CustomerType::admin) {
            return $this->orderBy('create_date', 'DESC')->paginate($requestData['page_limit']);
        }
        return $this->where('customer_id', self::$customerID)
            ->orderBy('create_date', 'DESC')
            ->paginate($requestData['page_limit']);
    }

}
