<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCompanyRequest extends BaseRequest
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
            //
        ];
    }

    /**
     * @return array
     */
    protected function storeRules()
    {
        return [
            'name' => 'required',
            'organ_code' => 'required',
            'reg_type' => 'required',
        ];
    }

    /**
     * @return array
     */
    protected function updateRules()
    {
        return [
            'name' => 'required',
            'organ_code' => 'required',
            'reg_type' => 'required',
        ];
    }

    /**
     * 保存校验
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateStore($data)
    {
        $this->check($data, $this->storeRules());
    }

    /**
     * 更新校验
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateUpdate($data)
    {
        $this->check($data, $this->updateRules());
    }
}
