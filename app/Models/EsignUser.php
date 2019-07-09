<?php
/**
 * Note: E签名用户关联表
 * User: Liu
 * Date: 2019/7/2
 */
namespace App\Models;

/**
 * App\Models\EsignUser
 *
 * @property int $id
 * @property string $accountid E签宝用户ID
 * @property int $userid 用户ID
 * @property int $type 用户类型 0个人 1公司
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser ofType($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser whereAccountid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EsignUser whereUserid($value)
 * @mixin \Eloquent
 */
class EsignUser extends Base
{
    protected $table = 'esign_user';

    protected $fillable = [
        'accountid',
        'userid',
        'type',// 用户类型 0个人 1公司
    ];

    public $timestamps = false;

    const TYPE_PERSON = 0;
    const TYPE_COMPANY = 1;

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'userid', 'id');
    }

    /**
     * 类型查询
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfType($query, $data = '')
    {
        if ($data === '') return $query;
        return $query->where('type', $data);
    }
}