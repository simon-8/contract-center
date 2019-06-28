<?php

namespace App\Http\Requests;

class UserAddressRequest extends BaseRequest
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
    protected function storeRules()
    {
        return [
            'linkman' => 'required',
            'mobile' => 'required',
            //'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
            //'postcode' => 'required',
        ];
    }

    /**
     * @param $data
     * @return $this|bool|\Illuminate\Http\JsonResponse
     */
    public function validateStore($data)
    {
        return $this->check($data, $this->storeRules());
    }
}
