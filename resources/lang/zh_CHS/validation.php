<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

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

    'accepted' => '无效的 :attribute。',
    'active_url' => ':attribute 不是有效的URL。',
    'after' => ':attribute 必须晚于 :date。',
    'after_or_equal' => ':attribute 必须不早于 :date。',
    'alpha' => ':attribute 只能含有英文字母。',
    'alpha_dash' => ':attribute 只能含有英文字母、数字、中划线、及下划线。',
    'alpha_num' => ':attribute 只能含有英文字母及数字。',
    'array' => ':attribute 必须为数组。',
    'before' => ':attribute 必须早于 :date。',
    'before_or_equal' => ':attribute 必须不晚于 :date。',
    'between' => [
        'numeric' => ':attribute 必须在 :min 和 :max 之间。',
        'file' => ':attribute 的大小必须在 :min KB 和 :max KB 之间。',
        'string' => ':attribute 的字数必须在 :min 和 :max 之间。',
        'array' => ':attribute 的条数必须在 :min 和 :max 之间。',
    ],
    'boolean' => ':attribute 只可以是 true 或 false。',
    'confirmed' => ':attribute 与确认输入不一样。',
    'date' => ':attribute 不是正确的日期。',
    'date_equals' => ':attribute 必须等于 :date。',
    'date_format' => ':attribute 格式不符合 :format.',
    'different' => ':attribute 与 :other 必须一样。',
    'digits' => ':attribute 必须为 :digits 位。',
    'digits_between' => ':attribute 的位数必须在 :min 和 :max 之间。',
    'dimensions' => ':attribute 尺寸不正确。',
    'distinct' => ':attribute 的内容不唯一。',
    'email' => ':attribute 必须为正确的电子邮件地址。',
    'ends_with' => ':attribute 必须以 :values 结尾。',
    'exists' => ':attribute 不存在。',
    'file' => ':attribute 必须为文件。',
    'filled' => ':attribute 必须填写。',
    'gt' => [
        'numeric' => ':attribute 必须大于 :value。',
        'file' => ':attribute 大小必须大于 :value KB。',
        'string' => ':attribute 必须多于 :value 字。',
        'array' => ':attribute 必须多于 :value 条。',
    ],
    'gte' => [
        'numeric' => ':attribute 必须不小于 :value。',
        'file' => ':attribute 大小必须不小于 :value KB。',
        'string' => ':attribute 必须不小于 :value 字。',
        'array' => ':attribute 必须不小于 :value 条。',
    ],
    'image' => ':attribute 为图片。',
    'in' => ':attribute 不正确。',
    'in_array' => '在 :other 中找不到 :attribute。',
    'integer' => ':attribute 必须为整数。',
    'ip' => ':attribute 必须为IP地址。',
    'ipv4' => ':attribute 必须为IPv4地址。',
    'ipv6' => ':attribute 必须为IPv6地址。',
    'json' => ':attribute 必须为JSON字符串。',
    'lt' => [
        'numeric' => ':attribute 必须小于 :value。',
        'file' => ':attribute 大小必须小于 :value KB。',
        'string' => ':attribute 必须小于 :value 字。',
        'array' => ':attribute 必须小于 :value 条。',
    ],
    'lte' => [
        'numeric' => ':attribute 必须不大于 :value。',
        'file' => ':attribute 大小必须不大于 :value KB。',
        'string' => ':attribute 必须不多于 :value 字。',
        'array' => ':attribute 必须不多于 :value 条。',
    ],
    'max' => [
        'numeric' => ':attribute 不能大于 :max。',
        'file' => ':attribute 不能大于 :max KB。',
        'string' => ':attribute 不能多于 :max 字。',
        'array' => ':attribute 不能多于 :max 条。',
    ],
    'mimes' => ':attribute 必须为 :values 类型的文件。',
    'mimetypes' => ':attribute 必须为 :values 类型的文件。',
    'min' => [
        'numeric' => ':attribute 不能小于 :min.',
        'file' => ':attribute 不能小于 :min KB。',
        'string' => ':attribute 不能少于 :min 字。',
        'array' => ':attribute 不能少于 :min 条。',
    ],
    'not_in' => ':attribute 不正确',
    'not_regex' => ':attribute 格式不正确。',
    'numeric' => ':attribute 必须为数字',
    'password' => '密码不正确。',
    'present' => ':attribute 必须提供。',
    'regex' => ':attribute 格式不正确。',
    'required' => ':attribute 必须填写',
    'required_if' => '当 :other 为 :value 时， :attribute 必须填写。',
    'required_unless' => ':attribute 必须填写，除非 :other 为 :values。',
    'required_with' => '当填写了 :values 中的任意一项时，:attribute 必须填写。',
    'required_with_all' => '当 :values 全部都填写了，:attribute 必须填写。',
    'required_without' => '当 :values 中的任意项目没有填写时，:attribute 必须填写。',
    'required_without_all' => '当 :values 全部都没填写时，:attribute 必须填写。',
    'same' => ':attribute 和 :other 必须一样。',
    'size' => [
        'numeric' => ':attribute 必须为 :size。',
        'file' => ':attribute 的大小必须为 :size KB。',
        'string' => ':attribute 必须为 :size 字。',
        'array' => ':attribute 必须有 :size 条。',
    ],
    'starts_with' => ':attribute 必须以 :values 开头。',
    'string' => ':attribute 必须为字符串。',
    'timezone' => ':attribute 必须为有效时区。',
    'unique' => ':attribute 已被占用。',
    'uploaded' => '无法上传 :attribute',
    'url' => ':attribute 必须为有效的URL。',
    'uuid' => ':attribute 必须为有效的UUID。',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
