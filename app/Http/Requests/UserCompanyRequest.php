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
     * 保存校验
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateStore($data)
    {
        $rule = [
            'name' => 'required',
            'organ_code' => 'required',
            'reg_type' => 'required',
            'legal_name' => 'required',
            'address' => 'required',
            //'legal_idno' => 'required',
            'mobile' => 'required|zh_mobile',
            'captcha' => 'required'
        ];
        $this->check($data, $rule);
    }

    /**
     * 更新校验
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateUpdate($data)
    {
        $rule = [
            'name' => 'required',
            'organ_code' => 'required',
            'reg_type' => 'required',
            'legal_name' => 'required',
            //'legal_idno' => 'required',
            'address' => 'required',
        ];
        $this->check($data, $rule);
    }

    /**
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateToPay($data)
    {
        $rules = [
            'name' => 'required',
            'cardno' => 'required',
            'subbranch' => 'required',
            'bank' => 'required',
            'province' => 'required',
            'city' => 'required',
        ];
        $this->check($data, $rules);
    }

    /**
     * @param $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateBanks($data)
    {
        $rules = [
            'keyword' => 'required',
        ];
        $this->check($data, $rules);
    }
}
