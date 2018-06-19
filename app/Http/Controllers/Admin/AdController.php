<?php
/**
 * Note: 广告管理
 * User: Liu
 * Date: 2018/3/12
 * Time: 21:50
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\AdPlaceRepository;
use App\Repositories\AdRepository;
use App\Http\Requests\AdRequest;

class AdController extends Controller
{

    /**
     * @param \Request $request
     * @param AdPlaceRepository $adPlaceRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Request $request, AdPlaceRepository $adPlaceRepository)
    {
        $adPlace = $adPlaceRepository->find($request::input('pid'));
        $data = [
            'adPlace' => $adPlace
        ];
        return admin_view('ad.index', $data);
    }

    /**
     * 新增
     * @param AdRequest $request
     * @param AdRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(AdRequest $request, AdRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        if (!$repository->create($data)) {
            return back()->withInput()->withErrors(__('web.failed'));
        }
        return redirect()->route('ad.index', ['pid' => $data['pid']])->with('Message', __('web.success'));
    }

    /**
     * 更新
     * @param AdRequest $request
     * @param AdRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(AdRequest $request, AdRepository $repository)
    {
        $data = $request->all();
        $data['thumb'] = upload_base64_thumb($data['thumb']);
        if (!$repository->update($data)) {
            return back()->withInput()->withErrors(__('web.failed'));
        }
        return redirect()->route('ad.index', ['pid' => $data['pid']])->with('Message', __('web.success'));
    }

    /**
     * 删除
     * @param AdRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(AdRepository $repository, $id)
    {
        $data = $repository->find($id);
        if (!$data->delete()) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('ad.index', ['pid' => $data['pid']])->with('Message', __('web.success'));
    }
}