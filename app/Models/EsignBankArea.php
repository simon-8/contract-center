<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;

class EsignBankArea extends Base
{
    use ModelTrait;

    protected $table = 'esign_bank_area';

    protected $fillable = [
        'province',
        'city',
    ];

    public $timestamps = false;
}
