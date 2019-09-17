<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/9/16
 * Time: 22:58
 */
namespace App\Models;

use App\Traits\ModelTrait;

class ContractSignCode extends Base
{
    use ModelTrait;

    protected $table = 'contract_sign_code';

    protected $fillable = [
        'contract_id',
        'userid_first',
        'userid_second',
        'userid_three',
        'mobile_first',
        'mobile_second',
        'mobile_three',
        'code_first',
        'code_second',
        'code_three',
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
