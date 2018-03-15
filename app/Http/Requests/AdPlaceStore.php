<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdPlaceStore extends FormRequest
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
            'name' => 'required',
            'width' => 'required|min:1|numeric',
            'height' => 'required|min:1|numeric',
            'status' => 'required|in:0,1|numeric'
        ];
    }
}
