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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sign whereUserid($value)
 * @mixin \Eloquent
 */
class Sign extends Base
{
    protected $table = 'signs';

    protected $fillable = [
        'contract_id',
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