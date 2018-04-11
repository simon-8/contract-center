<?php
/**
 * Note: 文章
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleContent;

class ArticleRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Article());
    }

    /**
     * @param $id
     * @param bool $preload
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function find($id, $preload = false)
    {
        return $preload ? $this->model->with('content')->find($id) : $this->model->find($id);
    }

    /**
     * 新增
     * @param array $data
     * @return bool|mixed
     */
    public function create($data)
    {
        $item = $this->model->create($data);
        if ($item) {
            return $item->content()->create([
                'content' => $data['content']
            ]);
        }
        return false;
    }

    /**
     * 更新
     * @param array $data
     * @return bool|mixed
     */
    public function update($data)
    {

        $item = $this->model->find($data['id']);
        $result = $item->update($data);
        if ($result) {
            return $item->content()->save(new ArticleContent([
                'content' => $data['content']
            ]));
        }
        return false;
    }

    /**
     * 获取各个状态的文章数量
     * @return array
     */
    public function get_status_num()
    {
        $data = [];
        $data['0'] = $this->model->where('status',0)->count();
        $data['1'] = $this->model->where('status',1)->count();
        $data['2'] = $this->model->where('status',2)->count();
        return $data;
    }

    /**
     * @param $where
     * @param bool $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listBy($where, $page = true)
    {
        if (!empty($where['keyword'])) {
            $keyword = $where['keyword'];
            unset($where['keyword']);
        }
        $query = $this->model->with('category')->where($where);
        if (isset($keyword)) $query = $query->title($keyword);
        return $query->paginate(self::$pageSize);
    }
}