<?php
/**
 * Note:
 * User: Liu
 * Date: 2020/04/26
 * Time: 22:11
 */
namespace App\Models;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContractChangeLog extends Model
{
    use ModelTrait;

    public $table = 'contract_changelog';

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    //public $timestamps = false;

    protected $fillable = [
        'contract_id',
        'user_id',
        'content',
    ];

    /**
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }
}
