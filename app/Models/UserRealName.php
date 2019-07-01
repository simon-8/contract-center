<?php
/**
 * Note: *
 * User: Liu
 * Date: 2019/7/1
 */
namespace App\Models;

/**
 * App\Models\UserRealName
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName query()
 * @mixin \Eloquent
 */
class UserRealName extends Base
{
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
    ];
}