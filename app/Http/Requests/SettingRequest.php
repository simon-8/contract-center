<?php

namespace App\Http\Requests;

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
     * @param $data
     * @return array|bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateStore($data)
    {
        return $this->check($data, [
            'item' => 'required',
            'name' => 'required',
            //'value' => 'required',
        ]);
    }

    /**
     * @param $data
     * @return array|bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateUpdate($data)
    {
        return $this->check($data, [
            'data' => 'required',
            //'value' => 'required',
        ]);
    }
}
