<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/9/16
 * Time: 21:39
 */
namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class EsignFaceService
{
    //const API_DOMAIN = 'https://smlopenapi.esign.cn';// 测试
    const API_DOMAIN = 'https://openapi.esign.cn';// 正式

    protected function requestHeader()
    {
        return [
            'X-Tsign-Open-App-Id:'. config('esign.appid'),
            'X-Tsign-Open-Token:'. $this->getToken(),
            'Content-Type:application/json',
        ];
    }

    protected function requestGet($api, $data, $header = [])
    {
        if (!empty($data) && is_array($data)) {
            $data = http_build_query($data);
        }
        $api = self::API_DOMAIN. $api;
        $ch = curl_init($api . '?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        if (!empty($_SERVER['HTTP_USER_AGENT'])) curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if ($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($ch);
        info($response);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) {
            return $response;
        }
        throw new \Exception($error);
    }

    protected function requestPost($api, $data)
    {
        //if (!empty($data) && is_array($data)) {
        //    $data = http_build_query($data);
        //}
        $api = self::API_DOMAIN. $api;
        $ch = curl_init($api);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        //if (!empty($_SERVER['HTTP_USER_AGENT'])) curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->requestHeader());
        info(json_encode($data));

        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        dd($return_content, $return_code);
        $response = curl_exec($ch);
        info(__METHOD__, [$response]);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) {
            return $response;
        }
        throw new \Exception($error);
    }

    public function getToken()
    {
        $token = Cache::get('esign:v2:token');
        if ($token) return $token;

        $url = '/v1/oauth2/access_token';
        $response = $this->requestGet($url, [
            'appId' => config('esign.appid'),
            'secret' => config('esign.appSecret'),
            'grantType' => 'client_credentials',
        ]);
        $response = json_decode($response, true);
        if ($response['code']) throw new \Exception($response['message']);
        $token = $response['data']['token'];
        $expireMs = $response['data']['expiresIn'];// 毫秒
        Cache::put('esign:v2:token', $token, Carbon::createFromTimestampMs($expireMs));
        return $token;
    }

    public function getFaceUrl($accountId)
    {
        $url = "/v2/identity/auth/web/{$accountId}/indivIdentityUrl";
        $response = $this->requestPost($url, [
            'authType' => 'PSN_FACEAUTH_BYURL',
            'availableAuthTypes' => ['PSN_FACEAUTH_BYURL'],
            'contextInfo' => [
                'contextId' => $accountId,
                'notifyUrl' => request()->fullUrl(),
                'origin' => 'APP',
                //'redirectUrl' => 'esignAppScheme=weixin://dl/moments'
            ],
            'indivInfo' => [
                'certNo' => '340811199012035318',
                'certType' => 'INDIVIDUAL_CH_IDCARD',
                'name' => '刘文静',
            ]
            //'receiveUrlMobileNo',
            //'contextInfo',
            //'authType',
        ]);
        $response = json_decode($response, true);
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data']['shortLink'];
    }
}
