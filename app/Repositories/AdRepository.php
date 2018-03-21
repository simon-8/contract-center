<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/3/14
 * Time: 22:59
 */
namespace App\Repositories;
use App\Models\Ad;
use App\Models\AdPlace;

class AdRepository
{
    protected $adModel;
    protected $placeModel;

    public function __construct()
    {
        $this->adModel = new Ad();
        $this->placeModel = new AdPlace();
    }

    /**
     * 广告位数量少 直接返回全部集合
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        return $this->placeModel->get();
    }

    public function find($id)
    {
        return $this->placeModel->find($id);
    }

    /**
     * 新增
     * @param $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        return $this->placeModel->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return bool
     */
    public function update($data)
    {
        $adPlace = $this->placeModel->find($data['id']);
        return $adPlace->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        //$adPlace = $this->placeModel->find($id);
        //\Log::debug($adPlace->ad);
        //$child = $adPlace->ad;
        //if (count($child)) {
        //    return false;
        //}
        return $this->placeModel->destroy($id);
    }

    /**
     * 查询
     * @param $id
     * @return mixed
     */
    public function itemFind($id)
    {
        return $this->adModel->find($id);
    }

    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function itemCreate($data)
    {
        return $this->adModel->create($data);
    }

    /**
     * 更新
     * @param $data
     * @return mixed
     */
    public function itemUpdate($data)
    {
        $item = $this->adModel->find($data['id']);
        return $item->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function itemDelete($id)
    {
        return $this->adModel->destroy($id);
    }
}