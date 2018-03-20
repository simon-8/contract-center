<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/20
 * Time: 23:09
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public $table = 'lottery';

    protected $fillable = [
        'userid',
        'aid',
        'gid',
        'gname',
        'admin_userid'
    ];

    /**
     * 对应用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }
}