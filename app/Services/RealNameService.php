<?php
/**
 * Note: 实名认证服务
 * User: Liu
 * Date: 2019/7/25
 * Time: 22:36
 */
namespace App\Services;

use tech\realname\rest\external\Person;
use tech\realname\rest\external\Organ;

class RealNameService
{
    const API_DOMAIN_HTTP = 'http://openapi2.tsign.cn:8081';
    const API_DOMAIN_HTTPS = 'https://openapi2.tsign.cn:8444'; // 正式环境
    const API_DOMAIN_HTTP_TEST = 'http://smlrealname.tsign.cn:8080';
    const API_DOMAIN_HTTPS_TEST = 'https://smlrealname.tsign.cn:443'; // 测试环境

    const API_TELE_COM_AUTH = '/realname/rest/external/person/telecomAuth';

    /**
     * @return string
     */
    public function getServerUrl()
    {
        if (is_debug_env() && env('APP_ENV') === 'local') {
            return self::API_DOMAIN_HTTPS_TEST;
        }
        return self::API_DOMAIN_HTTPS;
    }

    public function telecomAuth()
    {

    }

    /**
     * 发送POST请求
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function requestPost($api, $data)
    {
        if (!empty($data) && is_array($data)) {
            $data = http_build_query($data);
        }
        //$header = $this->makeHeader();
        $ch = curl_init($this->getServerUrl() . $api);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) {
            return $response;
        }
        throw new \Exception($error);
    }
}
