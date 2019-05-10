<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends BaseRequest
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
            'username' => 'required|unique:manager',
            'password' => 'required',
            'truename' => 'required',
            'email' => 'nullable|email',
            'role'  => 'required|array'
            //'is_admin' => 'required_without:role'
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
            'username' => 'required|unique:manager,username,'. $id,
            'truename' => 'required',
            'email' => 'nullable|email',
            'role'  => 'required|array'
            //'is_admin' => 'required_without:role'
        ];
    }

    /**
     * 新增数据验证
     * @param $data
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    public function validateCreate($data)
    {
        return $this->check($data, $this->createRules());
    }

    /**
     * 更新数据验证
     * @param $data
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    public function validateUpdate($data)
    {
        return $this->check($data, $this->updateRules($data['id']));
    }
}
