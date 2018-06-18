<?php

namespace App\Http\Requests;

class MenuRequest extends BaseRequest
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
    protected function createRules()
    {
        return [
            'pid' => 'required',
            'name' => 'required',
            'route' => 'required_without:link',
            'link' => 'required_without:route',
            'ico',
            'listorder',
            'items',
        ];
    }

    /**
     * @return array
     */
    protected function updateRules()
    {
        return [
            'pid' => 'required',
            'name' => 'required',
            'route' => 'required_without:link',
            'link' => 'required_without:route',
            'ico',
            'listorder',
            'items',
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
        return $this->check($data, $this->createRules());
    }
}
