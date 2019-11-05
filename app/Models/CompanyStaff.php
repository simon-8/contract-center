<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;

class CompanyStaff extends Base
{
    use ModelTrait;

    const STATUS_APPLY = 0;// 申请加入
    const STATUS_REFUSE = 1;// 拒绝
    const STATUS_SUCCESS = 2;// 同意
    const STATUS_CANCEL = 3;// 撤销

    protected $table = 'company_staff';

    protected $fillable = [
        'userid',
        'company_id',
        'status',
    ];

    protected $appends = [
        'status_text',
    ];

    /**
     * @param $value
     * @return mixed|string
     */
    public function getStatusTextAttribute($value)
    {
        return $this->getStatusText($value);
    }

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 关联公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    /**
     * @param Builder $query
     * @param string $data
     * @return Builder
     */
    public function scopeOfName(Builder $query, $data = '')
    {
        if (!$data) return $query;
        return $query->where('name', 'like', '%'. $data .'%');
    }

    /**
     * 获取状态数组
     * @param null $status
     * @return array
     */
    public function getStatus()
    {
        $statusArr = [
             self::STATUS_APPLY => '申请授权',
             self::STATUS_REFUSE => '拒绝申请',
             self::STATUS_SUCCESS => '正常使用',
             self::STATUS_CANCEL => '取消授权',
        ];
        return $statusArr;
    }

    /**
     * 获取文本
     * @param null $status
     * @return mixed|string
     */
    public function getStatusText($status = null)
    {
        if ($status === null) $status = $this->status;
        return $this->getStatus()[$status] ?? 'not found';
    }
}
