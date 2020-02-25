<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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

    //数据处理
    public function dataList($req_data)
    {
        //过滤page和page_limit筛选条件
        $filter_condition = Arr::except($req_data, ['page', 'page_limit']);
        return $this->where($filter_condition)->orderBy('create_date', 'DESC')->paginate($req_data['page_limit']);
    }

    //dashboard 总量
    public function total()
    {
        return $this->count();
    }
}
