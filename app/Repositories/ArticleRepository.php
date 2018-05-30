<?php
/**
 * Note: 文章资源库
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
        return $preload ? $this->model->with(['content', 'tags'])->findOrFail($id) : $this->model->findOrFail($id);
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
            $item->content()->create(['content' => $data['content']]);
            if (!empty($data['tags'])) $item->tags()->attach($data['tags']);
            return true;
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
        $item->update($data);
        $item->content()->update(['content' => $data['content']]);
        $item->tags()->sync($data['tags']??[]);
        return true;
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
        $query = $this->model->with('category')->where($where)->orderBy('id', 'DESC');
        if (isset($keyword)) $query = $query->title($keyword);
        return $query->paginate(self::$pageSize);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * @return mixed
     */
    public function dailyInsertCount()
    {
        return $this->model->where('created_at', '>', date('Y-m-d 00:00:00'))->count();
    }

    /**
     * 上一篇
     * @param $id
     * @param array $fields
     * @return mixed
     */
    public function previous($id, $fields = ['id', 'title'])
    {
        $primaryKey = $this->model->getKeyName();
        return $this->model->where($primaryKey, '<', $id)->select($fields)->orderBy($primaryKey, 'DESC')->first();
    }

    /**
     * 下一篇
     * @param $id
     * @param array $fields
     * @return mixed
     */
    public function next($id, $fields = ['id', 'title'])
    {
        $primaryKey = $this->model->getKeyName();
        return $this->model->where($primaryKey, '>', $id)->select($fields)->orderBy($primaryKey, 'ASC')->first();
    }
}