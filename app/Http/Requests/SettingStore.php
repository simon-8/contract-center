<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingStore extends FormRequest
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
            'pid' => 'required',
            'name',
            'prefix',
            'route',
            'ico',
            'listorder',
            'items',
        ];
    }*/

    /**
     * 新增数据验证规则
     * @return array
     */
    protected static function createRules()
    {
        return [
            'item' => 'required',
            'name' => 'required',
            'value' => 'required',
        ];
    }

    /**
     * 更新数据验证规则
     * @param $id
     * @return array
     */
    protected static function updateRules($id)
    {
        return [
            'item' => 'required',
            'name' => 'required',
            'value' => 'required',
        ];
    }

    /**
     * 新增数据验证
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validateCreate($data)
    {
        return \Validator::make($data, self::createRules());
    }

    /**
     * 更新数据验证
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validateUpdate($data)
    {
        return \Validator::make($data, self::updateRules($data['id']));
    }
}
