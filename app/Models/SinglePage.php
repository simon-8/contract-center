<?php
/**
 * Note: 单页
 * User: Liu
 * Date: 2018/11/21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinglePage extends Model
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
     * @param $query
     * @param string $data
     * @return mixed
     */
    public function scopeOfStatus($query, $data = '')
    {
        if ($data === '') return $query;
        return $query->where('status', $data);
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