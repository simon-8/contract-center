<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

/**
 * App\Models\UserCompany
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $userid 用户ID
 * @property string $name 组织名称
 * @property string $organ_code 机构代码
 * @property int $reg_type 机构类型
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereOrganCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereRegType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereUserid($value)
 * @property string|null $sign_data 签名图片地址
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCompany whereSignData($value)
 */
class UserCompany extends Base
{
    protected $table = 'user_company';

    protected $fillable = [
        'userid',
        'name',
        'organ_code',
        'reg_type',
        'sign_data',
    ];

    const REG_TYPE_NORMAL = 0;
    const REG_TYPE_MERGE = 1;
    const REG_TYPE_REGCODE = 2;
    const REG_TYPE_OTHER = 23;

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