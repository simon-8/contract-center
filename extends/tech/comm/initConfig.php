<?php
/*
 * e签宝快捷签 PHP SDK配置文件
 * 版本：2.0.17
 * Create Data ： 2016-12-8
 * 环境：需支持命名空间 php >= 5.3 、php7
 *
 * */
return array(
//==================请在这里配置您的接入信息===================
    /*项目初始化请求地址*/
    //'open_api_url' => 'http://121.40.164.61:8080/tgmonitor/rest/app!getAPIInfo2',//模拟环境
    'open_api_url' => "http://openapi.tsign.cn:8080/tgmonitor/rest/app!getAPIInfo2", //正式环境

    /*接入平台项目ID,必填；*/
    'project_id' => config('esign.appid'),

    /*项目密钥，必填*/
    'project_secret' => config('esign.appSecret'),

    /**
     * 签名方式 ：支持RSA、 HMACSHA256
     * 使用RSA签名方式，需打开php_openssl扩展。
     */
    'sign_algorithm' => 'HMACSHA256',
    //'sign_algorithm' => 'RSA',

    /**
     * 接入平台rsa私钥包含“-----BEGIN PRIVATE KEY-----”和“-----END PRIVATE KEY-----”。用于对请求数据进行签名。
     * 如果签名方式设置为“RSA”时，请设置该参数；
     * 如果为HMACSHA256，置空
     */
    'rsa_private_key' => '',

    /**
     * e签宝公钥,包含“-----BEGIN PUBLIC KEY-----”和“-----END PUBLIC KEY-----”。用于对响应数据进行验签。
     * 如果签名方式设置为“RSA”时，请设置该参数
     * 如果为HMACSHA256，置空
     */
    'esign_public_key' => '',

    /* http请求代理服务器设置;不使用代理的时候置空 */
    'proxy_ip' => '',
    'proxy_port' => '',

    /* 与服务端通讯方式设置。HTTP或HTTPS */
    'http_type' => 'HTTPS',
    'retry' => 3,

    /* 本地java服务 */
    'java_server' => config('esign.javaServer', 'http://127.0.0.1:8080'),
);



