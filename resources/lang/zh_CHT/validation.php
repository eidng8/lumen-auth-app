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

    'accepted' => '無效的 :attribute。',
    'active_url' => ':attribute 不是有效的URL。',
    'after' => ':attribute 必須晚於 :date。',
    'after_or_equal' => ':attribute 必須不早於 :date。',
    'alpha' => ':attribute 只能含有英文字母。',
    'alpha_dash' => ':attribute 只能含有英文字母、數字、中劃線、及下劃線。',
    'alpha_num' => ':attribute 只能含有英文字母及數字。',
    'array' => ':attribute 必須為數組。',
    'before' => ':attribute 必須早於 :date。',
    'before_or_equal' => ':attribute 必須不晚於 :date。',
    'between' => [
        'numeric' => ':attribute 必須在 :min 和 :max 之間。',
        'file' => ':attribute 的大小必須在 :min KB 和 :max KB 之間。',
        'string' => ':attribute 的字數必須在 :min 和 :max 之間。',
        'array' => ':attribute 的條數必須在 :min 和 :max 之間。',
    ],
    'boolean' => ':attribute 只可以是 true 或 false。',
    'confirmed' => ':attribute 與確認輸入不一樣。',
    'date' => ':attribute 不是正確的日期。',
    'date_equals' => ':attribute 必須等於 :date。',
    'date_format' => ':attribute 格式不符合 :format.',
    'different' => ':attribute 與 :other 必須一樣。',
    'digits' => ':attribute 必須為 :digits 位。',
    'digits_between' => ':attribute 的位數必須在 :min 和 :max 之間。',
    'dimensions' => ':attribute 尺寸不正確。',
    'distinct' => ':attribute 的內容不唯一。',
    'email' => ':attribute 必須為正確的電郵地址。',
    'ends_with' => ':attribute 必須以 :values 結尾。',
    'exists' => ':attribute 不存在。',
    'file' => ':attribute 必須為文件。',
    'filled' => ':attribute 必須填寫。',
    'gt' => [
        'numeric' => ':attribute 必須大於 :value。',
        'file' => ':attribute 大小必須大於 :value KB。',
        'string' => ':attribute 必須多於 :value 字。',
        'array' => ':attribute 必須多於 :value 條。',
    ],
    'gte' => [
        'numeric' => ':attribute 必須不小於 :value。',
        'file' => ':attribute 大小必須不小於 :value KB。',
        'string' => ':attribute 必須不小於 :value 字。',
        'array' => ':attribute 必須不小於 :value 條。',
    ],
    'image' => ':attribute 為圖片。',
    'in' => ':attribute 不正確。',
    'in_array' => '在 :other 中找不到 :attribute。',
    'integer' => ':attribute 必須為整數。',
    'ip' => ':attribute 必須為IP地址。',
    'ipv4' => ':attribute 必須為IPv4地址。',
    'ipv6' => ':attribute 必須為IPv6地址。',
    'json' => ':attribute 必須為JSON字符串。',
    'lt' => [
        'numeric' => ':attribute 必須小於 :value。',
        'file' => ':attribute 大小必須小於 :value KB。',
        'string' => ':attribute 必須小於 :value 字。',
        'array' => ':attribute 必須小於 :value 條。',
    ],
    'lte' => [
        'numeric' => ':attribute 必須不大於 :value。',
        'file' => ':attribute 大小必須不大於 :value KB。',
        'string' => ':attribute 必須不多於 :value 字。',
        'array' => ':attribute 必須不多於 :value 條。',
    ],
    'max' => [
        'numeric' => ':attribute 不能大於 :max。',
        'file' => ':attribute 不能大於 :max KB。',
        'string' => ':attribute 不能多於 :max 字。',
        'array' => ':attribute 不能多於 :max 條。',
    ],
    'mimes' => ':attribute 必須為 :values 類型的文件。',
    'mimetypes' => ':attribute 必須為 :values 類型的文件。',
    'min' => [
        'numeric' => ':attribute 不能小於 :min.',
        'file' => ':attribute 不能小於 :min KB。',
        'string' => ':attribute 不能少於 :min 字。',
        'array' => ':attribute 不能少於 :min 條。',
    ],
    'not_in' => ':attribute 不正確',
    'not_regex' => ':attribute 格式不正確。',
    'numeric' => ':attribute 必須為數字',
    'password' => '密碼不正確。',
    'present' => ':attribute 必須提供。',
    'regex' => ':attribute 格式不正確。',
    'required' => ':attribute 必須填寫',
    'required_if' => '當 :other 為 :value 時， :attribute 必須填寫。',
    'required_unless' => ':attribute 必須填寫，除非 :other 為 :values。',
    'required_with' => '當填寫了 :values 中的任意一項時，:attribute 必須填寫。',
    'required_with_all' => '當 :values 全部都填寫了，:attribute 必須填寫。',
    'required_without' => '當 :values 中的任意項沒有填寫時，:attribute 必須填寫。',
    'required_without_all' => '當 :values 全部都沒填寫時，:attribute 必須填寫。',
    'same' => ':attribute 和 :other 必須一樣。',
    'size' => [
        'numeric' => ':attribute 必須為 :size。',
        'file' => ':attribute 的大小必須為 :size KB。',
        'string' => ':attribute 必須為 :size 字。',
        'array' => ':attribute 必須有 :size 條。',
    ],
    'starts_with' => ':attribute 必須以 :values 開頭。',
    'string' => ':attribute 必須為字符串。',
    'timezone' => ':attribute 必須為有效時區。',
    'unique' => ':attribute 已被佔用。',
    'uploaded' => '無法上載 :attribute',
    'url' => ':attribute 必須為有效的URL。',
    'uuid' => ':attribute 必須為有效的UUID。',

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
