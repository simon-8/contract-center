<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;

class Company extends Base
{
    use ModelTrait;

    const REG_TYPE_NORMAL = 0;
    const REG_TYPE_MERGE = 1;
    const REG_TYPE_REGCODE = 2;
    const REG_TYPE_OTHER = 23;

    const STATUS_VERIFYD_INFO = 0;// 通过身份校验
    const STATUS_APPLY_PAY = 1;// 申请支付
    const STATUS_PAYED = 2;// 已支付
    const STATUS_SUCCESS = 3;// 认证成功

    protected $table = 'company';

    protected $fillable = [
        'userid',
        'name',
        'organ_code',
        'reg_type',
        'legal_name',
        'legal_idno',
        'mobile',
        'address',
        'seal_img',
        'sign_data',
        'service_id',
        'status',
    ];

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
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
     * 企业注册类型
     * @return array
     */
    public function getRegTypes() {
        $regTypes = [
            self::REG_TYPE_NORMAL => '组织机构代码号',
            self::REG_TYPE_MERGE => '多证合一',
            self::REG_TYPE_REGCODE => '企业工商注册码',
            self::REG_TYPE_OTHER => '其它',
        ];
        return $regTypes;
    }

    /**
     * 获取状态文字
     * @param null $regType
     * @return mixed
     */
    public function getRegTypeText($regType = null)
    {
        if (!isset($regType)) $regType = $this->reg_type;
        return $this->getRegTypes()[$regType];
    }
}
