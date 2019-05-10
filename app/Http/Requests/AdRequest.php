<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends BaseRequest
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
            'pid' => 'required',
            'thumb' => 'required',
            'url' => 'nullable|url',
            'title' => 'required',
            'content' => 'nullable',
            'listorder' => 'nullable'
        ];
    }
}
