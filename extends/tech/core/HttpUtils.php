<?php
/**
 * User: timevale
 * Date: 2016/12/7
 */

namespace tech\core;

use tech\core\Log;
use tech\core\Util;

class HttpUtils
{
    /**
     * curl超时时间 单位:秒
     */
    const CURL_TIMEOUT = 60;
    /**
     * 重试次数
     */
    const TRY_NUMBER = 3;

    const CONTENT_TYPE_JSON = 'application/json';

    const CONTENT_TYPE_STREAM = 'application/octet-stream';

    const CONTENT_TYPE_FORM_URLENCODE = 'application/x-www-form-urlencoded';

    const CONTENT_TYPE_FORM_DATA = 'multipart/form-data';

    //const CONTENT_TYPE_TEXT_XML = 'text/xml';

    //const CONTENT_TYPE_TEXT_PLAIN = 'text/plain';

    /**
     * 配置文件
     */
    private $_config = array();

    /**
     * 请求头
     */
    private $requestHeader = array();

    /**
     * 设置curl是否返回header信息，签名验签必须返回，设置为 true 或 1
     */
    private $outHeader = false;

    private $proxy = null;
    /**
     * 响应状态
     */
    public $responseStatus;

    /**
     * 响应头
     */
    public $responseHeader;

    /**
     * 响应内容
     */
    public $responseBody;

    /**
     * @return HttpUtils
     */
    public static function request()
    {
        static $req = false;
        if ($req === false) {
            $_config = include ESIGN_ROOT . '/comm/initConfig.php';
            $req = new HttpUtils($_config);
        }
        return $req;
    }

    /*
     * 构建
     *
     **/
    public function __construct($config)
    {
        $this->_config = $config;
        $this->requestHeader = array(
            'X-timevale-mode: package',
            'X-timevale-project-id:' . $config['project_id'],
            'X-timevale-signature-algorithm:' . strtolower($config['sign_algorithm']),
        );
        if (!empty($config['proxy_ip'])) {
            $this->proxy['host'] = $config['proxy_ip'];
            $this->proxy['port'] = $config['proxy_port'];
        }
    }

    /**
     * 建立HTTP的POST请求，需要构建签名验签
     * @param string $url
     * @param array $data
     * @param bool|true $isJson
     * @return array|mixed
     * @throws \Exception
     */
    public function buildSignHttpRequest($url, array $data, $isJson)
    {
        if (empty($url)) {
            return array(
                'errCode' => 102,
                'msg' => '请求地址为空',
                'errShow' => false
            );
        }

        if ($isJson === true) {
            $contentType = 'Content-Type:' . self::CONTENT_TYPE_JSON . ";charset=UTF-8";
            //转出json字符串
            $data = Util::jsonEncode($data);
        } else {
            $contentType = 'Content-Type:' . self::CONTENT_TYPE_FORM_URLENCODE . ";charset=UTF-8";
            //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
            $data = $this->toQueryString($data);
        }

        //生成签名结果
        $mySign = $this->buildRequestSign($data);

        //构建请求头
        $header = $this->requestHeader;
        $header[] = 'X-timevale-signature:' . $mySign;
        $header[] = $contentType;
        //输出响应头
        $this->outHeader = true;
        //远程获取数据
        $this->sendHttpRequestPost($url, $data, $header, $this->proxy);

        unset($header);
        return $this->getResultByVerify($url);
    }

    /**
     * 建立HTTP的POST请求，没有签名验签
     * @param $url  请求地址
     * @param array $data 请求参数
     * @param bool|true $postJson 以json方式发送post参数
     * @param bool $proxy 是否使用代理
     * @return array|mixed
     * @throws Exception
     */
    public function noSignHttpPost($url, $data, $postJson, $proxy)
    {
        if (empty($url)) {
            return array(
                'errCode' => 102,
                'msg' => '请求地址为空',
                'errShow' => false
            );
        }

        //构建请求头
        $header = $this->requestHeader;

        //请求参数提交方式
        if ($postJson === true) {
            $contentType = 'Content-Type:' . self::CONTENT_TYPE_JSON . ";charset=UTF-8";
            $postStr = Util::jsonEncode($data);
            $header[] = $contentType;
        } else {
            //$contentType = 'Content-Type:' . self::CONTENT_TYPE_FORM_DATA . ";charset=UTF-8";
            $postStr = $data;
        }

        //不输出响应头
        $this->outHeader = false;
        //发送请求
        if ($proxy === true) {
            $this->sendHttpRequestPost($url, $postStr, $header, $this->proxy);
        } else {
            $this->sendHttpRequestPost($url, $postStr, $header, array());
        }
        return $this->getResult($url);
    }


    /**
     * 解析请求结果，不需要验证服务端返回的签名信息
     *
     * @param string $url
     * @return array|mixed
     */
    protected function getResult($url = '')
    {
        $status = $this->responseStatus;
        //请求失败直接返回
        if ($status !== 200) {
            return array(
                'errCode' => $status,
                'msg' => '服务接口调用失败! ' . $status,
                'httpUrl' => $url,
                'httpContent' => $this->responseBody,
                'errShow' => false
            );
        }
        //decode body
        $res = json_decode($this->responseBody, TRUE);
        return $res;
    }

    /**
     * 解析结果，需要验证服务端返回的签名信息
     * @param string $url
     * @return array|mixed
     */
    protected function getResultByVerify($url = '')
    {
        $status = $this->responseStatus;
        $header = $this->responseHeader;
        $body = $this->responseBody;
        //请求失败直接返回
        if ($status !== 200) {
            return array(
                'errCode' => $status,
                'msg' => '调用服务接口失败!' . $status,
                'httpUrl' => $url,
                //'httpContent' => $body,
                'errShow' => false
            );
        }

        //解析头
        $headerArray = $this->parseHeader($header);
        $signature = isset($headerArray['x-timevale-signature']) ? $headerArray['x-timevale-signature'] : '';

        //相应数据签名验证
        $verify = $this->verifyResponse($body, $signature);
        if (false == $verify) {
            //验签失败
            return array(
                'errCode' => $status,
                'msg' => '返回信息签名验签失败',
                'errShow' => false,
                'header' => $header,
                //'body' => $body
            );
        }

        //decode body
        $res = json_decode(trim($body), TRUE);
        return $res;
    }

    /**
     * 发送CURL请求，POST模式
     * @param   string $url 指定URL完整路径地址
     * @param   string|array $postStr 请求的数据
     * @param   array $header 请求头
     * @return  string 远程输出的数据
     * @throws  \Exception
     */
    public function sendHttpRequestPost($url, $postStr, $requestHeader = array(), $proxy = array())
    {
        $result = '';
        $requestHeader[] = 'Expect:';

        for ($i = 0; $i < self::TRY_NUMBER; $i++) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_HEADER, $this->outHeader); // 输出HTTP头 true
            curl_setopt($curl, CURLOPT_TIMEOUT, self::CURL_TIMEOUT);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
            if (!empty($proxy)) {
                $host = $proxy['host'];
                $host .= ($proxy['port']) ? ':' . $proxy['port'] : '';
                //curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, true);
                curl_setopt($curl, CURLOPT_PROXY, $host);
            }
            curl_setopt($curl, CURLOPT_POST, true); // post传输数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postStr);// post传输数据
            curl_setopt($curl, CURLOPT_HTTPHEADER, $requestHeader);

            $result = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (false !== $result) {
                $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                break;
            } else {
                $result = curl_error($curl);
            }
            curl_close($curl);
            sleep(1);
        }

        if ($this->outHeader == true) {
            $responseHeader = substr($result, 0, $headerSize);
            $responseBody = substr($result, $headerSize);
        } else {
            $responseHeader = '';
            $responseBody = $result;
        }

        $this->responseStatus = empty($httpCode) ? 101 : $httpCode;
        $this->responseHeader = $responseHeader;
        $this->responseBody = $responseBody;

        //打印日志
        $this->debug($url, $postStr, $requestHeader, $result);
    }

    private function debug($url, $postStr, $requestHeader, $result)
    {
        //$ret = json_decode($this->responseBody, true);
        //$isError = (isset($ret['errCode']) && $ret['errCode'] === 0) ? true : false;
        //if (ESIGN_DEBUGE && ($isError || $this->responseStatus !== 200)) {
        if (ESIGN_DEBUGE) {
            $str = PHP_EOL . '【请求地址】：' . $url;
            $str .= PHP_EOL . '【请求参数】：' . (is_array($postStr) ? Util::jsonEncode($postStr) : $postStr);
            $str .= PHP_EOL . '【请求头】：' . json_encode($requestHeader);
            $str .= PHP_EOL . '【返回】 : ' . $result . PHP_EOL;
            Log::debug($str);
        }
    }

    /**
     *  兼容不同版本的文件上传
     * @param $filePath
     * @return string|CURLFile
     */
    public function getRealFileIgnore($filePath)
    {
        if (class_exists('\CURLFile')) {
            return new \CURLFile($filePath);

        } else {
            return '@' . $filePath;
        }
    }

    /**
     * 生成签名结果
     * @param string $query 要签名的参数
     * @return string 签名结果字符串
     */
    private function buildRequestSign($query)
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
     * 解析响应头
     * @param $headerStr 响应头字符串
     * @return array
     */
    private function parseHeader($headerStr)
    {
        //切割字符串
        $headerStr = explode("\r\n\r\n", trim($headerStr));
        $headerStr = array_pop($headerStr);
        $headerStr = explode("\r\n", $headerStr);
        array_shift($headerStr);

        $headerArray = array();
        foreach ($headerStr as $item) {
            $res = explode(':', $item);
            $res[1] = trim($res[1]);
            $headerArray[strtolower($res[0])] = isset($res[1]) ? $res[1] : '';
        }
        return $headerArray;
    }


    /**
     * 把数组所有元素用“&”字符拼接成字符串
     *
     * @param array $data 需要拼接的数组
     * @return string 返回诸如 key1=value1&key2=value2
     */
    private function toQueryString(array $data)
    {
        $result = http_build_query($data);
        return $result;
    }

}