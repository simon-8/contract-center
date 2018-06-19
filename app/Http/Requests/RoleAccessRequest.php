<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleAccessRequest extends BaseRequest
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
            'name' => 'required|unique:role_access',
            'method' => 'nullable',
            'path' => 'nullable'
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
            'name' => 'required|unique:role_access,name,'. $id,
            'method' => 'nullable',
            'path' => 'nullable'
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
