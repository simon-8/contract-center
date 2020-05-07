<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/7
 */
namespace App\Models;

class EsignEviPoint extends Base
{
    protected $table = 'esign_evi_point';

    public $timestamps = false;

    //public $incrementing = false;

    protected $fillable = [
        'contract_id',
        'evid',
        'url',
    ];
}
