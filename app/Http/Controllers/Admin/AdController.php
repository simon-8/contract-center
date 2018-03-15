<?php
/**
 * Note: 广告位管理
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:50
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\AdRepository;

class AdController extends Controller
{

    /**
     * 首页
     * @param AdRepository $adRepository
     * @return mixed
     */
    public function getIndex(AdRepository $adRepository)
    {
        $lists = $adRepository->lists();
        $data = [
            'lists' => $lists
        ];
        return admin_view('ad.index', $data);
    }

    /**
     * 添加广告位
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        if ($adRepository->create($data)) {
            return redirect()->route('admin.ad.index')->with('Message', '添加成功');
        } else {
            return back()->withInput()->withErrors('添加失败');
        }
    }

    /**
     * 更新广告位
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdate(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        if ($adRepository->update($data)) {
            return redirect()->route('admin.ad.index')->with('Message', '更新成功');
        } else {
            return back()->withInput()->withErrors('更新失败');
        }
    }

    /**
     * 删除广告位
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        if ($adRepository->delete($data['id'])) {
            return redirect()->route('admin.ad.index')->with('Message', '删除成功');
        } else {
            return back()->withErrors('删除失败, 请检查广告位下是否含有广告');
        }
    }

    /**
     * 广告列表
     * @param AdRepository $adRepository
     * @param $pid
     * @return mixed
     */
    public function itemIndex(AdRepository $adRepository, $pid)
    {
        $adPlace = $adRepository->find($pid);
        $data = [
            'adPlace' => $adPlace
        ];
        return admin_view('ad.items', $data);
    }

    /**
     * 新增
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function itemCreate(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        if ($adRepository->itemCreate($data)) {
            return redirect()->route('admin.ad.item.index', $data['pid'])->with('Message', '添加成功');
        } else {
            return back()->withInput()->withErrors('添加失败');
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function itemUpdate(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        if ($adRepository->itemUpdate($data)) {
            return redirect()->route('admin.ad.item.index', $data['pid'])->with('Message', '更新成功');
        } else {
            return back()->withInput()->withErrors('更新失败');
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param AdRepository $adRepository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function itemDelete(\Request $request, AdRepository $adRepository)
    {
        $data = $request::all();
        $ad = $adRepository->itemFind($data['id']);
        if ($ad->delete()) {
            return redirect()->route('admin.ad.item.index', $ad['pid'])->with('Message', '删除成功');
        } else {
            return back()->withErrors('删除失败');
        }
    }
}