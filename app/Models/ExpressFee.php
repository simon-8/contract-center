<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/8/13
 */
namespace App\Models;

use App\Traits\ModelTrait;

class ExpressFee extends Base
{
    use ModelTrait;

    protected $table = 'express_fee';

    protected $fillable = [
        'id',
        'name',
        'amount',
    ];

    public $timestamps = false;
}
