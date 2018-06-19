<?php
/**
 * Note: 广告位
 * User: Liu
 * Date: 2018/6/19
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\AdPlaceRequest;
use App\Repositories\AdPlaceRepository;

class AdPlaceController extends Controller
{

    /**
     * 首页
     * @param AdPlaceRepository $adPlaceRepository
     * @return mixed
     */
    public function index(AdPlaceRepository $adPlaceRepository)
    {
        $lists = $adPlaceRepository->list();
        $data = [
            'lists' => $lists
        ];
        return admin_view('ad_place.index', $data);
    }

    /**
     * @param AdPlaceRequest $request
     * @param AdPlaceRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(AdPlaceRequest $request, AdPlaceRepository $repository)
    {
        $data = $request->all();
        if ($repository->create($data)) {
            return redirect()->route('ad-place.index')->with('Message', __('web.success'));
        } else {
            return back()->withInput()->withErrors(__('web.failed'));
        }
    }

    /**
     * @param AdPlaceRequest $request
     * @param AdPlaceRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(AdPlaceRequest $request, AdPlaceRepository $repository)
    {
        $data = $request->all();
        if (!$repository->update($data)) {
            return back()->withInput()->withErrors(__('web.failed'));
        }
        return redirect()->route('ad-place.index')->with('Message', __('web.success'));
    }

    /**
     * @param AdPlaceRepository $repository
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(AdPlaceRepository $repository, $id)
    {
        if (!$repository->delete($id)) {
            return back()->withErrors(__('web.failed'));
        }
        return redirect()->route('ad-place.index')->with('Message', __('web.success'));
    }

}