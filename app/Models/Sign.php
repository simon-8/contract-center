<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/6/30
 * Time: 13:35
 */
namespace App\Models;

use App\Traits\ModelTrait;

class Sign extends Base
{
    use ModelTrait;

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
