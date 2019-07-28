<?php
/**
 * Note: 签名记录
 * User: Liu
 * Date: 2019/7/4
 */
namespace App\Models;

use App\Traits\ModelTrait;

class EsignSignLog extends Base
{
    use ModelTrait;

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
