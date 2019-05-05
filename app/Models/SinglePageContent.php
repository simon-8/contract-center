<?php
/**
 * Note: 单页详情
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinglePageContent extends Model
{
    public $table = 'single_page_content';

    public $timestamps = false;

    public $fillable = [
        'id',
        'content'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function singlePage()
    {
        return $this->belongsTo('App\Models\SinglePage', 'id', 'id');
    }
}