<?php
/**
 * Note: 签名记录
 * User: Liu
 * Date: 2019/7/4
 */
namespace App\Models;

/**
 * App\Models\EsignSignLog
 *
 * @property int $id
 * @property int $contract_id 合同ID
 * @property string $name 文档名称
 * @property int $userid 用户ID
 * @property int $serviceid 签署记录ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract $contract
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereServiceid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignSignLog whereUserid($value)
 * @mixin \Eloquent
 */
class EsignSignLog extends Base
{
    protected $table = 'esign_sign_logs';

    protected $fillable = [
        'contract_id',
        'name',
        'userid',
        'serviceid',
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
     * 关联合同
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo('App\Models\Contract', 'contract_id', 'id');
    }
}