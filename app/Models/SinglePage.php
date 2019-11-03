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

    const CAT_DEFAULT = 0;// 默认
    const CAT_GUIDE_IMAGE = 1;// 图片指导
    const CAT_GUIDE_VIDEO = 2;// 视频指导

    const STATUS_CLOSE = 0;
    const STATUS_NORMAL = 1;

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
        'listorder',
        'status'
    ];

    protected $appends = [
        'cat_text',
    ];

    /**
     * 状态文字
     * @param $value
     * @return mixed
     */
    public function getStatusTextAttribute($value)
    {
        return $this->getStatusText();
    }

    /**
     * 分类文字
     * @param $value
     * @return mixed
     */
    public function getCatTextAttribute($value)
    {
        return $this->getCatText();
    }

    /**
     * @param $value
     * @return string
     */
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
        return $data;
    }

    /**
     * 所有分类
     * @return array
     */
    public function getCats() {
        $catArr = [
            self::CAT_DEFAULT => '默认分类',
            self::CAT_GUIDE_IMAGE => '图片指导',
            self::CAT_GUIDE_VIDEO => '视频指导',
        ];
        return $catArr;
    }

    /**
     * 获取分类文字
     * @param null $catid
     * @return mixed
     */
    public function getCatText($catid = null)
    {
        if (!isset($catid)) $catid = $this->catid;
        return $this->getCats()[$catid];
    }

    /**
     * @return array
     */
    public function getStatusArr() {
        $statusArr = [
            self::STATUS_CLOSE => '关闭',
            self::STATUS_NORMAL => '正常',
        ];
        return $statusArr;
    }

    /**
     * 获取状态文字
     * @param null $status
     * @return mixed
     */
    public function getStatusText($status = null)
    {
        if (!isset($status)) $status = $this->status;
        return $this->getStatusArr()[$status];
    }
}
