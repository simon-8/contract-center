<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/7
 */
namespace App\Models;

class EsignEviSeg extends Base
{
    protected $table = 'esign_evi_seg';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'id',
        'scene_id',
    ];
}
