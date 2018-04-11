<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SinglePageStore extends FormRequest
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
    /*    public function rules()
        {
            return [
                //
            ];
        }*/

    /**
     *
     * @return array
     */
    protected static function createRules()
    {
        return [
            'title' => 'required|min:1',
            'status' => 'numeric'
        ];
    }

    /**
     * @return array
     */
    protected static function updateRules()
    {
        return [
            'title' => 'required|min:1',
            'status' => 'numeric'
        ];
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validateCreate($data)
    {
        return \Validator::make($data, self::createRules());
    }

    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validateUpdate($data)
    {
        return \Validator::make($data, self::updateRules());
    }
}
