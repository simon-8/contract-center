<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/7/26
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogs extends Model
{
    public $table = 'admin_logs';

    protected $fillable = [
        'userid',
        'event',
        'data'
    ];

    /**
     * 关联管理员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo('App\Models\Manager', 'userid', 'id');
    }
}