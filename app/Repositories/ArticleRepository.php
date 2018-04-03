<?php
/**
 * Note: 文章
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticleContent;

class ArticleRepository
{
    protected $model, $content_model;
    protected static $pageSize = 15;

    public function __construct()
    {
        $this->model = new Article();
        $this->content_model = new ArticleContent();
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->model->paginate(self::$pageSize);
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
     * @param $data
     * @return mixed
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
     * @param $data
     * @return mixed
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
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
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
}