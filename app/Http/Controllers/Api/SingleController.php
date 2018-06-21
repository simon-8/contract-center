<?php
/**
 * Note: 首页所需接口
 * User: Liu
 * Date: 2018/4/10
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SinglePageRepository;
use Chenhua\MarkdownEditor\Facades\MarkdownEditor;


class SingleController extends Controller
{
    /**
     * 列表
     * @param \Request $request
     * @param SinglePageRepository $singlePageRepository
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(\Request $request, SinglePageRepository $singlePageRepository)
    {
        return $singlePageRepository->lists(['status' => 1]);
    }

    /**
     * 详情
     * @param SinglePageRepository $singlePageRepository
     * @param $id
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|\Symfony\Component\HttpFoundation\Response|static|static[]
     */
    public function show(SinglePageRepository $singlePageRepository, $id)
    {
        try {
            $data = $singlePageRepository->find($id, true);
        } catch (\Exception $exception) {
            return response('', 404);
        }
        $data->increment('hits', 1);

        $data = $data->toArray();
        $data['content'] = $data['content']['content'];
        if ($data['is_md']) {
            $data['content'] = MarkdownEditor::parse($data['content']);
        }
        return $data;
    }
}