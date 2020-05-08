<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/7
 */
namespace App\Models;

class EsignEviLink extends Base
{
    const STATUS_INIT = 0; // 初始化
    const STATUS_POINT_CREATED = 1; // 证据点已创建
    const STATUS_FILE_UPLOAD = 2; // 文件已上传
    const STATUS_POINT_LINKED = 3; // 证据点已关联
    const STATUS_USER_LINKED = 4; // 用户已关联

    protected $table = 'esign_evi_link';

    //public $timestamps = false;

    //public $incrementing = false;

    protected $fillable = [
        'contract_id',
        'scene_name',
        'scene_id',
        'scene_evid',
        'seg_id',
        'point_url',
        'point_evid',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_INIT,
    ];
}
