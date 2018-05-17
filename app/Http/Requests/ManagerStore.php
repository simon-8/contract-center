<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerStore extends FormRequest
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
            'username' => 'required|unique:manager',
            'password' => 'required',
            'truename' => 'required',
            'email' => 'nullable|email',
            'role'  => 'required|array'
            //'is_admin' => 'required_without:role'
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
            'username' => 'required|unique:manager,username,'. $id,
            'truename' => 'required',
            'email' => 'nullable|email',
            'role'  => 'required|array'
            //'is_admin' => 'required_without:role'
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
