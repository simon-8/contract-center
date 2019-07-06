<?php

namespace App\Http\Requests;

class ContractRequest extends BaseRequest
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
     * @return array
     */
    protected function confirmRules()
    {
        return [
            'user_type' => 'required',
        ];
    }

    /**
     * @param $data
     * @return array|bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateConfirm($data)
    {
        return $this->check($data, $this->confirmRules());
    }
}
