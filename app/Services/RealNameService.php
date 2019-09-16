<?php
/**
 * Note: 实名认证服务
 * User: Liu
 * Date: 2019/7/25
 * Time: 22:36
 */
namespace App\Services;

use App\Models\UserCompany;
use tech\core\HttpUtils;
use tech\realname\rest\external\Person;
use tech\realname\rest\external\Organ;

class RealNameService
{
    const API_DOMAIN_HTTP = 'http://openapi2.tsign.cn:8081';
    const API_DOMAIN_HTTPS = 'https://openapi2.tsign.cn:8444'; // 正式环境
    const API_DOMAIN_HTTP_TEST = 'http://smlrealname.tsign.cn:8080';
    const API_DOMAIN_HTTPS_TEST = 'https://smlrealname.tsign.cn:443'; // 测试环境

    // 个人实名认证 运营商三要素
    const API_TELE_COM_AUTH = '/realname/rest/external/person/telecomAuth';
    // 企业信息校验
    const API_INFO_COM_AUTH = '/realname/rest/external/organ/infoAuth';
    // 企业对公打款
    const API_ORGAN_TO_PAY = '/realname/rest/external/organ/toPay';
    // 企业对公打款 金额校验
    const API_ORGAN_PAY_AMOUNT_CHECK = '/realname/rest/external/organ/payAuth';
    // 企业对公打款 银行列表
    const API_ORGAN_BANK_LIST = '/realname/rest/info/bank';

    protected $_config = [];

    protected function getConfig()
    {
        $this->_config = [
            'project_id' => config('esign.appid'),
            'project_secret' => config('esign.appSecret'),
            'sign_algorithm' => 'HMACSHA256',
        ];
    }

    public function __construct()
    {
        $this->getConfig();
    }

    /**
     * @return string
     */
    protected function getServerUrl()
    {
        if (is_debug_env() && env('APP_ENV') === 'local') {
            return self::API_DOMAIN_HTTPS_TEST;
        }
        return self::API_DOMAIN_HTTPS;
    }

    /**
     * 个人实名 运营商三要素
     * @param $data
     * @return array|mixed
     * @throws \Exception
     */
    public function teleComAuth($data)
    {
        $param = [];
        $param['mobile'] = $data['mobile'] ?? '';
        $param['name'] = $data['name'] ?? '';
        $param['idno'] = $data['idno'] ?? '';
        $response = $this->notifyToServer(self::API_TELE_COM_AUTH, $param);
        if ($response['errCode']) {
            throw new \Exception('实名认证失败:'. $response['msg'].', 请确认当前绑定手机号为本人使用');
        }
        return $response;
    }

    /**
     * 企业身份验证
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function infoComAuth($data)
    {
        $param = [];
        $param['name'] = $data['name'] ?? '';
        if (UserCompany::REG_TYPE_NORMAL) {
            $param['codeORG'] = $data['organ_code'] ?? '';
        } else if (UserCompany::REG_TYPE_MERGE) {
            $param['codeUSC'] = $data['organ_code'] ?? '';
        } else if (UserCompany::REG_TYPE_REGCODE) {
            $param['codeREG'] = $data['organ_code'] ?? '';
        } else {
            $param['codeORG'] = $data['organ_code'] ?? '';
        }
        $param['legalName'] = $data['legal_name'] ?? '';
        $param['legalIdno'] = $data['legal_idno'] ?? '';
        $response = $this->notifyToServer(self::API_INFO_COM_AUTH, $param);
        if ($response['errCode']) {
            throw new \Exception('企业实名认证失败:'. $response['msg']);
        }
        return $response;
    }

    /**
     * 企业对公打款
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function organPay($data, $pid)
    {
        $param = [];
        $param['name'] = $data['name'];
        $param['cardno'] = $data['cardno'];
        $param['subbranch'] = $data['subbranch'];
        $param['bank'] = $data['bank'];
        $param['provice'] = $data['province'];
        $param['city'] = $data['city'];
        $param['notify'] = route('api.userCompanyOrder.notify', ['pid' => $pid]);
        $param['city'] = $data['city'];
        $param['serviceId'] = $data['service_id'];
        //$param['serviceId'] = $data['service_id'];
        $response = $this->notifyToServer(self::API_ORGAN_TO_PAY, $param);
        if ($response['errCode']) {
            throw new \Exception('尝试对公打款失败:'. $response['msg']);
        }
        return $response;
    }

    /**
     * 打款金额验证
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function organPayAmountCheck($data)
    {
        $param['serviceId'] = $data['service_id'];
        $param['cash'] = $data['cash'];
        $response = $this->notifyToServer(self::API_ORGAN_PAY_AMOUNT_CHECK, $param);
        if ($response['errCode']) {
            throw new \Exception('打款金额验证失败: '. $response['msg']);
        }
        return $response;
    }

    /**
     * 企业对公打款 银行列表
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function organBankList($data)
    {
        $param['keyword'] = $data['keyword'];
        $response = $this->notifyToServer(self::API_ORGAN_BANK_LIST, $param);
        if ($response['errCode']) {
            throw new \Exception('打款金额验证失败: '. $response['msg']);
        }
        return $response;
    }

    /**
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function notifyToServer($api, $data)
    {
        \Log::debug('ServerRequest ==> ' . $api);
        \Log::debug('ServerRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestPost($this->getServerUrl(). $api, $data);

        \Log::debug('ServerResponse ==> ' . $response);
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * @param $api
     * @param $data
     * @return bool|mixed|string
     * @throws \Exception
     */
    protected function queryFromServer($api, $data)
    {
        \Log::debug('ServerRequest ==> ' . $api);
        \Log::debug('ServerRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestGet($this->getServerUrl(). $api, $data);

        \Log::debug('ServerResponse ==> ' . $response);
        $response = json_decode($response, true);
        return $response;
    }

    protected function makeRequesHeader($sign)
    {
        return [
            'X-timevale-mode: package',
            'X-timevale-project-id:' . $this->_config['project_id'],
            'X-timevale-signature-algorithm:' . strtolower($this->_config['sign_algorithm']),
            'X-timevale-signature:'. $sign,
            'Content-Type:application/json;charset=UTF-8',
        ];
    }

    /**
     * 生成签名结果
     * @param string $query 要签名的参数
     * @return string 签名结果字符串
     */
    private function makeRequestSign($query)
    {
        switch (strtoupper(trim($this->_config['sign_algorithm']))) {
            case 'HMACSHA256' :
                $mySign = $this->hmacSHA256Sign($query, $this->_config['project_secret']);
                break;
            case 'RSA' :
                $mySign = $this->rsaSign($query, $this->_config['rsa_private_key']);
                break;
            default :
                $mySign = '';
        }
        return $mySign;
    }

    /**
     * 验证服务端返回的签名结果
     * @param string $str 要验证的字符串
     * @param string $sign 签名字符串
     * @return bool        验证结果
     */
    private function verifyResponse($str, $sign)
    {
        //验证服务端返回的签名
        switch (strtoupper(trim($this->_config['sign_algorithm']))) {
            case 'HMACSHA256':
                return $this->hmacSHA256Verify($str, $sign, $this->_config['project_secret']);
            case 'RSA':
                return $this->rsaVerify($str, $sign, $this->_config['esign_public_key']);
                break;
        }
        return false;
    }

    /**
     * 签名字符串
     * @param string $str 需要签名的字符串
     * @param string $key 私钥
     * @return string       签名结果
     */
    private function hmacSHA256Sign($str, $key)
    {
        return hash_hmac('sha256', $str, $key);
    }

    /**
     * 验证签名
     * @param string $str 需要签名的字符串
     * @param string $sign 签名结果
     * @param string $key 私钥
     * @return bool
     */
    private function hmacSHA256Verify($str, $sign, $key)
    {
        $mySign = $this->hmacSHA256Sign($str, $key);
        return ($mySign === $sign);
    }

    /**
     * RSA签名
     * @param string $str 待签名数据
     * @param string $priKey 接入平台私钥文件路径
     * @return string 签名结果
     */
    private function rsaSign($str, $priKey)
    {
        //$priKey = file_get_contents($privateKeyPath);
        //$res = openssl_get_privatekey($priKey);
        $res = openssl_pkey_get_private($priKey);
        openssl_sign($str, $sign, $res);
        openssl_free_key($res);
        return bin2hex($sign);
    }

    /**
     * RSA验签
     * @param string $str 待签名数据
     * @param string $sign 要校对的的签名结果
     * @param string $pubKey e签宝的公钥文件路径
     * @return bool 验证结果
     */
    private function rsaVerify($str, $sign, $pubKey)
    {
        //$pubKey = file_get_contents($publicKeyPath);
        //$res = openssl_get_publickey($pubKey);
        $res = openssl_pkey_get_public($pubKey);
        $result = openssl_verify($str, pack("H*", $sign), $res);
        openssl_free_key($res);
        return (1 == $result);
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
        //if (!empty($data) && is_array($data)) {
        //    $data = http_build_query($data);
        //}
        $data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $sign = $this->makeRequestSign($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->makeRequesHeader($sign));
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
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
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
}
