<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends BaseRequest
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
     *
     * @return array
     */
    protected function createRules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'to_userid' => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    protected function updateRules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'to_userid' => 'required|numeric',
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
        return $this->check($data, $this->updateRules());
    }
}
