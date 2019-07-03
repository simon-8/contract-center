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
 * @property int $id
 * @property int $userid
 * @property string $truename 姓名
 * @property string $nationality 民族
 * @property string $idcard 身份证号
 * @property string $sex 性别
 * @property string $birth 出生日期
 * @property string $address 地址信息
 * @property string $start_date 有效期起始时间
 * @property string $end_date 有效期结束时间
 * @property string $issue 签发机关
 * @property string $face_img 身份证正面图片
 * @property string $back_img 身份证反面图片
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereBackImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereFaceImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereIdcard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereTruename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRealName whereUserid($value)
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