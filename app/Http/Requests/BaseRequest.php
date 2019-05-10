<?php
/**
 * Note: 验证基类
 * User: Liu
 * Date: 2018/6/18
 * Time: 21:01
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * 校验数据
     * @param array $data
     * @param array $rules
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    protected function check(array $data, array $rules)
    {
        $validator = \Validator::make($data, $rules);
        if ($validator->failed()) {
            if (\Request::ajax()) {
                return response_exception($validator->errors()->first());
            } else {
                return back()->withErrors($validator->errors())->withInput();
            }
        }
        return true;
    }
}