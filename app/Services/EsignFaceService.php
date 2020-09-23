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
    public static $apiDomain = '';

    const API_AUTH_TOKEN = '/v1/oauth2/access_token';
    // 用户
    const API_USER_CREATE = '/v1/accounts/createByThirdPartyUserId';
    const API_USER_DEL = '/v1/accounts/{accountId}';
    const API_USER_INDENT_FACE = '/v2/identity/auth/web/{accountId}/indivIdentityUrl';
    const API_USER_DETAIL = '/v1/accounts/{accountId}';

    // 公司
    const API_COMPANY_CREATE = '/v1/organizations/createByThirdPartyUserId';
    const API_COMPANY_DEL = '/v1/organizations/{orgId}';

    // 查询认证
    const API_IDENTITY_DETAIL = '/v2/identity/auth/api/common/{flowId}/detail';

    public function __construct()
    {
        // 单元测试时使用沙盒
        if (config('esign.debug')) {
           self::$apiDomain = 'https://smlopenapi.esign.cn';
        } else {
             self::$apiDomain = 'https://openapi.esign.cn';
        }
    }

    protected function requestHeader()
    {
        return [
            'X-Tsign-Open-App-Id:'. config('esign.appid'),
            'X-Tsign-Open-Token:'. $this->getToken(),
            'Content-Type:application/json',
        ];
    }

    /**
     * 发送GET请求
     * @param $api
     * @param $data
     * @param array $header
     * @return bool|string
     * @throws \Exception
     */
    protected function requestGet($api, $data = [], $header = [])
    {
        if (!empty($data) && is_array($data)) {
            $data = http_build_query($data);
        } else {
            $data = '';
        }
        $ch = curl_init($api . '?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        if (!empty($_SERVER['HTTP_USER_AGENT'])) curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        if ($header !== false) {
            $header[] = 'X-Tsign-Open-App-Id:'. config('esign.appid');
            $header[] = 'Content-Type:application/json';
            if ($token = Cache::get('esign:v2:token')) $header[] = "X-Tsign-Open-Token:{$token}";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        info($header);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (empty($error)) return $response;
        throw new \Exception($error);
    }

    /**
     * 发送POST请求
     * @param $api
     * @param $data
     * @param string $method
     * @return false|string
     * @throws \Exception
     */
    protected function requestPost($api, $data, $method = '')
    {
        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->requestHeader());
        if ($method) {
            switch ($method) {
                case "POST":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    break;
                case "PUT":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    break;
                case "DELETE":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                default:
            }
        }
        ob_start();
        curl_exec($ch);
        $response = ob_get_contents();
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        ob_end_flush();
        curl_close($ch);
        //dd($return_content, $return_code);
        info(__METHOD__, [$response, $responseCode]);
        if ($responseCode == 200) return $response;
        throw new \Exception($responseCode);
    }

    protected function get($api, $data = [], $header = [])
    {
        $url = self::$apiDomain . $api;
        info('EsignGetRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestGet($url, $data, $header);
        info('EsignGetResponse ==> ' . $response);
        return json_decode($response, true);
    }

    /**
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function post($api, $data = [])
    {
        $url = self::$apiDomain . $api;
        info('EsignPostRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestPost($url, $data);
        info('EsignPostResponse ==> ' . $response);
        return json_decode($response, true);
    }

    /**
     * 删除
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function delete($api, $data = [])
    {
        $url = self::$apiDomain . $api;
        info('EsignPostRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestPost($url, $data, 'DELETE');
        info('EsignPostResponse ==> ' . $response);
        return json_decode($response, true);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {
        $token = Cache::get('esign:v2:token');
        if ($token) return $token;

        $params = [
            'appId' => config('esign.appid'),
            'secret' => config('esign.appSecret'),
            'grantType' => 'client_credentials',
        ];
        $response = $this->get(self::API_AUTH_TOKEN, $params, false);
        if ($response['code']) throw new \Exception($response['message']);

        $token = $response['data']['token'];
        $expireMs = $response['data']['expiresIn'];// 毫秒
        Cache::put('esign:v2:token', $token, Carbon::createFromTimestampMs($expireMs));
        return $token;
    }

    /**
     * @param $accountId
     * @param array $contextInfo
     * @param array $indivInfo
     * @return mixed
     * @throws \Exception
     */
    public function getFaceUrl($accountId, $contextInfo = [], $indivInfo = [])
    {
        $params = [
            'authType' => 'PSN_FACEAUTH_BYURL',
            'availableAuthTypes' => ['PSN_FACEAUTH_BYURL'],
            //'contextInfo' => [
            //    'contextId' => $accountId,
            //    'notifyUrl' => request()->fullUrl(),
            //    'origin' => 'APP',
            //    //'redirectUrl' => 'esignAppScheme=weixin://dl/moments'
            //],
            //'indivInfo' => [
            //    'certNo' => '340811199012035318',
            //    'certType' => 'INDIVIDUAL_CH_IDCARD',
            //    'name' => '刘文静',
            //]
        ];
        if ($contextInfo) $params['contextInfo'] = $contextInfo;
        if ($indivInfo) $params['indivInfo'] = $indivInfo;

        $response = $this->post(str_replace('{accountId}', $accountId, self::API_USER_INDENT_FACE), $params);
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data'];
    }

    /**
     * 创建用户
     * @param $userId
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function userCreate($userId, $name = '')
    {
        $params = [
            'thirdPartyUserId' => $userId,
            'name' => $name,
        ];
        $response = $this->post(self::API_USER_CREATE, $params);
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data']['accountId'];
    }

    /**
     * 删除用户
     * @param $accountId
     * @return bool
     * @throws \Exception
     */
    public function userDel($accountId)
    {
        $response = $this->delete(str_replace('{accountId}', $accountId, self::API_USER_DEL), []);
        if ($response['code']) throw new \Exception($response['message']);
        return true;
    }

    /**
     * 用户详情
     * @param $accountId
     * @return mixed
     * @throws \Exception
     */
    public function userDetail($accountId)
    {
        $response = $this->get(str_replace('{accountId}', $accountId, self::API_USER_DETAIL));
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data'];
    }

    /**
     * 添加企业号
     * @param $userId
     * @param $accountId
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function companyCreate($userId, $accountId, $name = '')
    {
        $params = [
            'thirdPartyUserId' => $userId,
            'creator' => $accountId,
            'name' => $name,
            //'idType' => '',
            //'idNumber' => '',
            //'orgLegalIdNumber' => '',
            //'orgLegalName' => '',
        ];
        $response = $this->post(self::API_COMPANY_CREATE, $params);
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data']['orgId'];
    }

    /**
     * 删除企业
     * @param $orgId
     * @return bool
     * @throws \Exception
     */
    public function companyDel($orgId)
    {
        $response = $this->delete(str_replace('{orgId}', $orgId, self::API_COMPANY_DEL), []);
        if ($response['code']) throw new \Exception($response['message']);
        return true;
    }

    /**
     * 查询认证详情
     * @param $flowId
     * @return bool|mixed
     * @throws \Exception
     */
    public function identityDetail($flowId)
    {
        $response = $this->get(str_replace('{flowId}', $flowId, self::API_IDENTITY_DETAIL));
        if ($response['code']) throw new \Exception($response['message']);
        return $response['data'];
        if ($response['data']['objectType'] === 'INDIVIDUAL') {
            /*
             * ['indivInfo']['name']
             * ['indivInfo']['certNo']
             * ['indivInfo']['mobileNo']
             * */
        } else {
            /*
             * ['organInfo']['name']
             * ['organInfo']['certNo']
             * ['organInfo']['legalRepName']
             * ['organInfo']['legalRepCertNo']
             * */
        }
        return $response['data']['status'] === 'SUCCESS';
    }
}
