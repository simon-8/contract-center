<?php
/**
 * Note: 单页
 * User: Liu
 * Date: 2018/11/21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SinglePage
 *
 * @property int $id
 * @property int $catid 分类ID
 * @property string $title 标题
 * @property string $thumb 标题图片
 * @property string $content 内容
 * @property int $adminid 发布人
 * @property int $comment 评论数量
 * @property int $zan 赞数量
 * @property int $hits 点击量
 * @property int $is_md 是否是markdown
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage ofStatus($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage ofTitle($title)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereCatid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereIsMd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SinglePage whereZan($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCatid($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofCreatedAt($data = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base ofUserid($data = 0)
 */
class SinglePage extends Base
{
    public $table = 'single_page';

    public $fillable = [
        'catid',
        'title',
        'thumb',
        'username',
        'content',
        'comment',
        'zan',
        'hits',
        'is_md',
        'status'
    ];

    public function getThumbAttribute($value)
    {
        return imgurl($value);
    }

    /**
     * @param $query
     * @param $title
     * @return mixed
     */
    public function scopeOfTitle($query, $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    /**
     * 获取各个状态的文章数量
     * @return array
     */
    public function get_status_num()
    {
        $data = [];
        $data['0'] = $this->where('status', 0)->count();
        $data['1'] = $this->where('status', 1)->count();
        $data['2'] = $this->where('status', 2)->count();
        return $data;
    }
}