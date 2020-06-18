<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/24
 * Time: 10:45
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use ModelTrait;

    public const IS_READ_YES = 1;
    public const IS_READ_NO = 0;

    protected $table = 'messages';

    protected $fillable = [
        'from_userid',
        'to_userid',
        'title',
        'content',
        'is_read',
    ];

    /**
     * 发送用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo('App\Models\User', 'from_userid', 'id')->withDefault([
            'truename' => '系统',
        ]);
    }

    /**
     * 接收用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo('App\Models\User', 'to_userid', 'id')->withDefault();
    }
}
