<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * 新增数据验证规则
     * @return array
     */
    protected function createRules()
    {
        return [
            'item' => 'required|unique:settings',
            'name' => 'required',
            'value' => 'required',
        ];
    }

    /**
     * 更新数据验证规则
     * @param $id
     * @return array
     */
    protected function updateRules($id)
    {
        return [
            'item' => 'required|unique:settings,item,'.$id,
            'name' => 'required',
            'value' => 'required',
        ];
    }

    /**
     * @param $data
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    public function validateCreate($data)
    {
        return $this->check($data, $this->createRules());
    }

    /**
     * @param $data
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    public function validateUpdate($data)
    {
        return $this->check($data, $this->updateRules($data['id']));
    }
}
