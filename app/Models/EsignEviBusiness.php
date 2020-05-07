<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/7
 */
namespace App\Models;

class EsignEviBusiness extends Base
{
    protected $table = 'esign_evi_business';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'id',
    ];
}
