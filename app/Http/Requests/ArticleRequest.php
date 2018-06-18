<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends BaseRequest
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
            'catid' => 'required|numeric',
            'title' => 'required|min:1',
            'introduce' => 'nullable',
            'status' => 'numeric'
        ];
    }

    /**
     * @return array
     */
    protected function updateRules()
    {
        return [
            'catid' => 'required|numeric',
            'title' => 'required|min:1',
            'introduce' => 'nullable',
            'status' => 'numeric'
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
