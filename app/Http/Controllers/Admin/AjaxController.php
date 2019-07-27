<?php
/**
 * Note: Ajax集中处理
 * User: Liu
 * Date: 2018/11/02
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Cblink\Region\Area;
use Storage;

//use Cblink\Region\Region;

class AjaxController extends Controller
{
    /**
     * @param \Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(\Request $request)
    {
        $ac = $request::input('ac');
        switch ($ac){
            case 'thumb':
                return view('admin.ajax.'.$ac , $request::all());
                break;
            case 'uploadImages':
                $name = 'file';
                if (!$request::hasFile($name)) {
                    return responseException('请选择文件');
                }
                if (!$request::file($name)->isValid()) {
                    return responseException('文件无效');
                }
                $result = $request::file($name)->store('/images/'.date('Ym/d'), 'uploads');
                $basePath = str_replace(public_path(), '', Storage::disk('uploads')->path(''));
                $url = $basePath.$result;
                // todo 保存到session中
                //$imageService->pushSessionImages($url);
                return responseMessage($url);
                break;
        }
        abort(404);
    }

}
