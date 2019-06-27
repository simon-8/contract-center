<?php

namespace App\Http\Requests;

class OrderRequest extends BaseRequest
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
            'contract_id' => 'required',
            'channel' => 'required',
            'gateway' => 'required',
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
