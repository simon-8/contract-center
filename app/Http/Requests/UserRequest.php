<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends BaseRequest
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
    protected function sendSmsRules()
    {
        return [
            'mobile'  => 'required|zh_mobile',
        ];
    }

    /**
     * @return array
     */
    protected function verifyCodeRules()
    {
        return [
            'mobile' => 'required|zh_mobile',
            'code' => 'required'
        ];
    }

    /**
     * @param $data
     */
    public function validateSendSms($data)
    {
        $this->check($data, $this->sendSmsRules());
    }

    /**
     * @param $data
     */
    public function validateVerifyCode($data)
    {
        $this->check($data, $this->verifyCodeRules());
    }
}
