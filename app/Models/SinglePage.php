<?php
/**
 * Note: 单页
 * User: Liu
 * Date: 2018/11/21
 */
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class SinglePage extends Base
{
    use ModelTrait;

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
