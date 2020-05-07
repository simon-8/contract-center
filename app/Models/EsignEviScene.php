<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/7
 */
namespace App\Models;

class EsignEviScene extends Base
{
    protected $table = 'esign_evi_scene';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'id',
        'business_id',
        'catid',// 关联分类ID
        'seg_id', // 证据点名称ID
        'seg_has_attr', // 证据点字段属性是否已建立
    ];

    /**
     * 关联 分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\ContractCategory', 'catid', 'id');
    }

    /**
     * 关联 数据存证 行业
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eviBusiness()
    {
        return $this->belongsTo('App\Models\EsignEviBusiness', 'business_id', 'id');
    }

    /**
     * 关联 数字存证 证据点
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    //public function eviSeg()
    //{
    //    return $this->hasOne('App\Models\EsignEviSeg', 'scene_id', 'id');
    //}
}
