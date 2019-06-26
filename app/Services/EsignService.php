<?php
/**
 * Note: E签宝Service
 * User: Liu
 * Date: 2019/6/26
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class EsignService
{
    protected $config;

    protected $baseUrl = 'https://openapi.esign.cn';

    protected $baseUrlDev = 'https://smlopenapi.esign.cn';

    protected $accessToken;

    const API_OAUTH2_ACCESS_TOKEN = '/v1/oauth2/access_token';

    public function __construct()
    {
        $this->config = config('esign');
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
        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) {
            return $response;
        }
        throw new \Exception($error);
    }

    /**
     * GET请求
     * @param $api
     * @param $data
     * @return bool|string
     * @throws \Exception
     */
    protected function requestGet($api, $data)
    {
        if (!empty($data) && is_array($data)) {
            $data = http_build_query($data);
        }
        $ch = curl_init($api .'?'. $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) {
            return $response;
        }
        throw new \Exception($error);
    }

    /**
     * @param $api
     * @return string
     */
    protected function getUrl($api)
    {
        $baseUrl = config('app.env') === 'local' ? $this->baseUrlDev : $this->baseUrl;
        return $baseUrl. $api;
    }

    /**
     * POST
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function notifyToServer($api, $data = [])
    {
        \Log::debug('ServerRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));

        $response = $this->requestPost($this->getUrl($api), $data);

        \Log::debug('ServerResponse ==> ' . $response);
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * GET
     * @param $api
     * @param $data
     * @return bool|mixed|string
     * @throws \Exception
     */
    protected function queryFromServer($api, $data = '')
    {
        \Log::debug('ServerRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestGet($this->getUrl($api), $data);

        \Log::debug('ServerResponse ==> ' . $response);
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * 获取accessToken
     * @return mixed
     * @throws \Exception
     */
    public function getAccessToken()
    {
        $cacheKey = __CLASS__.'.AccessToken';
        $accessData = Cache::get($cacheKey);
        if ($accessData) {
            $this->accessToken = $accessData;
            return $accessData;
        }
        $response = $this->queryFromServer(self::API_OAUTH2_ACCESS_TOKEN, [
            'appId' => $this->config['appid'],
            'secret' => $this->config['appSecret'],
            'grantType' => 'client_credentials'
        ]);
        if ($response['code']) {
            throw new \Exception($response['code'].': '.$response['message']);
        }
        $accessData = $response['data'];
        Cache::put($cacheKey, $accessData, 120 * 60);

        $this->accessToken = $accessData;
        return $accessData;
    }


}