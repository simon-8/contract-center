<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

use App\Traits\ModelTrait;

class UserRealName extends Base
{
    use ModelTrait;

    protected $table = 'user_real_name';

    protected $fillable = [
        'userid',
        'truename',
        'nationality',
        'idcard',
        'sex',
        'birth',
        'address',
        'start_date',
        'end_date',
        'issue',
        'face_img',
        'back_img',
        'sign_data',
    ];
}
