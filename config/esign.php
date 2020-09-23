<?php
/**
 * Note: E签宝配置
 * User: Liu
 * Date: 2019/6/26
 */
return [
    'debug' => env('ESIGN_DEBUG', false),
    'appid' => env('ESIGN_APPID'),
    'appSecret' => env('ESIGN_SECRET'),
    'javaServer' => env('ESIGN_JAVA_SERVER') ?: 'http://127.0.0.1:8080'
];