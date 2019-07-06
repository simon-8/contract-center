<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ' :attribute 必须确认.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => ' :attribute 必须是个数组.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute 必须为 true 或者 false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute 格式不正确.',
    'exists'               => ':attribute 的值无效.',
    'file'                 => ':attribute 文件无效.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute 必须是个图像.',
    'in'                   => ':attribute 的值不正确.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute 必须是个整数.',
    'ip'                   => ':attribute 必须是个正确的 IP 地址.',
    'ipv4'                 => ':attribute 必须是个正确的 IPv4 地址.',
    'ipv6'                 => ':attribute 必须是个正确的 IPv6 地址.',
    'json'                 => ':attribute 必须是个正确的 JSON 字符串.',
    'max'                  => [
        'numeric' => ' :attribute 不能大于 :max.',
        'file'    => ' :attribute 不能大于 :max kilobytes.',
        'string'  => ' :attribute 不能大于 :max 个字符.',
        'array'   => ' :attribute 不能大于 :max 个值.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ' :attribute 不能小于 :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => ' :attribute 不能少于 :min 个字符.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => '选择的:attribute无效.',
    'numeric'              => ':attribute 必须是个数字.',
    'present'              => ':attribute 必须存在.',
    'regex'                => ':attribute 格式错误.',
    'required'             => ':attribute 必填.',
    'required_if'          => '当 :other 是 :value 时, :attribute 必填.',
    'required_unless'      => '当 :other 不是 :values 时, :attribute 必填.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => '当 :values 未填写时, :attribute 必填',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute 和 :other 必须匹配.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => ' :attribute 必须是字符串.',
    'timezone'             => ' :attribute 必须是有效的区域.',
    'unique'               => ':attribute 已经存在.',
    'uploaded'             => ' :attribute 上传失败.',
    'url'                  => ':attribute 格式错误.',
    'captcha'              => ':attribute 不正确',
    'zh_mobile'            => ':attribute 格式不正确',
    'confirm_mobile_not_change' => ':attribute 校验码不匹配',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'area'        => '区/县',
        'address'     => '详细地址',
        'back_img'    => '身份证反面',
        'catid'       => '分类',
        'captcha'     => '验证码',
        'channel'     => '支付通道',
        'content'     => '内容',
        'contract_id' => '合同ID',
        'country'     => '国家',
        'city'        => '城市',
        'email'       => '邮箱',
        'face_img'    => '身份证正面',
        'gateway'     => '支付网关',
        'height'      => '高度',
        'ico'         => '图标',
        'is_admin'    => '管理员',
        'link'        => '链接',
        'linkman'     => '联系人',
        'listorder'   => '排序',
        'name'        => '名称',
        'mobile'      => '手机',
        'password'    => '密码',
        'postcode'    => '邮编',
        'province'    => '省份',
        'role'        => '权限',
        'route'       => '路由',
        'status'      => '状态',
        'title'       => '标题',
        'thumb'       => '图片',
        'truename'    => '真实姓名',
        'url'         => '链接地址',
        'username'    => '用户名',
        'user_type'   => '身份类型',
        'width'       => '宽度',
    ],

];
