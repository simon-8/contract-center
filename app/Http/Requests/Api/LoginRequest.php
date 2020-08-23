<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
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
     * 微信登录
     * @return mixed
     */
    public function validateWechat()
    {
        $rules = [
            'client_id' => 'required|numeric',
            //'app_id' => 'required|string',
            'code'   => 'required|string',
        ];
        $this->validate($rules);
        return $this->all();
    }
}
