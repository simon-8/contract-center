<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/28
 * Time: 18:18
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;

class UserCompanyOrder extends Base
{
    use ModelTrait;

    protected $table = 'user_company_order';

    protected $fillable = [
        'pid',
        'amount',
        'orderid',
        'userid',
        'remark',
    ];

    /**
     * 订单ID
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfOrderid(Builder $query, $data = '')
    {
        if (empty($data)) return $query;
        return $query->where('orderid', $data);
    }
}
