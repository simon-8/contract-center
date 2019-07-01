<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/30
 * Time: 13:35
 */
namespace App\Models;

/**
 * App\Models\UserSign
 *
 * @property int $id
 * @property int $contract_id 合同ID
 * @property int $userid 用户ID
 * @property string $thumb 图片地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSign whereUserid($value)
 * @mixin \Eloquent
 */
class UserSign extends Base
{
    protected $table = 'user_sign';

    protected $fillable = [
        'contrct_id',
        'userid',
        'thumb',
    ];

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }


}