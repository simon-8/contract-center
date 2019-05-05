<?php
/**
 * Note: tag模型
 * User: Liu
 * Date: 2018/5/30
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function article()
    {
        return $this->belongsToMany('App\Models\Article');
    }
}