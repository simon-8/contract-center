<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;

class EsignBank extends Base
{
    use ModelTrait;

    protected $table = 'esign_bank';

    protected $fillable = [
        'bank_code',
        'bank_name',
        'sub_name',
        'province',
        'city',
    ];

    public $timestamps = false;
}
