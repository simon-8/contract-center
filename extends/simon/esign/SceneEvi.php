<?php
/**
 * Note: *
 * User: Liu
 * Date: 2020/5/6
 * Time: 22:15
 */

namespace Simon\Esign;

class SceneEvi
{
    const API_HOST_DEV = 'https://smlcunzheng.tsign.cn:9443';
    const API_HOST = 'https://evislb.tsign.cn:443';

    const VIEWPAGE_HOST_DEV = 'https://smlcunzheng.tsign.cn';
    const VIEWPAGE_HOST = "https://eviweb.tsign.cn";

    const API_BUS_ADD = '/evi-service/evidence/v1/sp/temp/bus/add';
    const API_SCENE_ADD = '/evi-service/evidence/v1/sp/temp/scene/add';
    const API_SEG_ADD = '/evi-service/evidence/v1/sp/temp/seg/add';
    const API_SEGPROP_ADD = '/evi-service/evidence/v1/sp/temp/seg-prop/add';
    const API_VOUCHER = '/evi-service/evidence/v1/sp/scene/voucher';
    const API_ORIGINAL_STANDARD = '/evi-service/evidence/v1/sp/segment/original-std/url';
    const API_ORIGINAL_ADVANCED = '/evi-service/evidence/v1/sp/segment/original-adv/url';
    const API_ORIGINAL_DIGEST = 'evi-service/evidence/v1/sp/segment/abstract/url';
    const API_VOUCHER_APPEND = '/evi-service/evidence/v1/sp/scene/append';
    const API_RELATE = '/evi-service/evidence/v1/sp/scene/relate';
    const URL_VIEWPAGE = '/evi-web/static/certificate-info.html';

    protected $_config = [];

    protected $debug = false;

    public function __construct(array $config, $debug = false)
    {
        $this->_config = $config;
        $this->debug = $debug;
    }

    /**
     * 获取 API 域名地址
     * @return string
     */
    protected function getApiHost()
    {
        if ($this->debug) {
            return self::API_HOST_DEV;
        }
        return self::API_HOST;
    }

    /**
     * 获取 View 域名地址
     * @return string
     */
    protected function getViewHost()
    {
        if ($this->debug) {
            return self::VIEWPAGE_HOST_DEV;
        }
        return self::VIEWPAGE_HOST;
    }

    /**
     * @param $api
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function notifyToServer($api, $data)
    {
        \Log::debug('ServerRequest ==> ' . $this->getApiHost() . $api);
        \Log::debug('ServerRequest ==> ' . (is_array($data) ? var_export($data, true) : $data));
        $response = $this->requestPost($this->getApiHost() . $api, $data);

        \Log::debug('ServerResponse ==> ' . $response);
        $response = json_decode($response, true);
        if ($response['errCode']) {
            throw new \Exception($response['msg']);
        }
        return $response;
    }

    /**
     * 设置请求头
     * @param $sign
     * @return array
     */
    protected function makeRequesHeader($sign)
    {
        return [
            'X-timevale-mode: package',
            'X-timevale-project-id:' . $this->_config['project_id'],
            'X-timevale-signature-algorithm:' . strtolower($this->_config['sign_algorithm']),
            'X-timevale-signature:' . $sign,
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
     * 获取文件的Content-MD5
     * 原理：1.先计算MD5加密的二进制数组（128位）。
     * 2.再对这个二进制进行base64编码（而不是对32位字符串编码）。
     * @param $filePath
     * @return string
     */
    protected function getContentBase64Md5($filePath)
    {
        //获取文件MD5的128位二进制数组
        $md5file = md5_file($filePath, true);
        //计算文件的Content-MD5
        $contentBase64Md5 = base64_encode($md5file);
        return $contentBase64Md5;
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
        if (!empty($_SERVER['HTTP_USER_AGENT'])) curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
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
        $ch = curl_init($api . '?' . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        if (!empty($_SERVER['HTTP_USER_AGENT'])) curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
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
     * 通过 HTTP 发送文件
     * @param $url
     * @param $contentBase64Md5
     * @param $fileContent
     * @return int|mixed|string
     */
    protected function sendHttpPUT($url, $contentBase64Md5, $fileContent)
    {
        $header = [
            'Content-Type:application/octet-stream',
            'Content-Md5:' . $contentBase64Md5
        ];

        $status = '';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);
        curl_setopt($curl_handle, CURLOPT_HEADER, true); // 输出HTTP头 true
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5184000);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');

        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $fileContent);
        $result = curl_exec($curl_handle);
        $status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

        if ($result === false) {
            $status = curl_errno($curl_handle);
            $result = 'put file to oss - curl error :' . curl_error($curl_handle);
        }
        curl_close($curl_handle);
        return $status;
    }

    /**
     * 定义行业类型
     * @param string $business
     * @return array
     * @throws \Exception
     */
    public function createBusiness($business) :array
    {
        $business = is_string($business) ? [$business] : $business;
        $param = [
            'name' => $business,
        ];
        $response = $this->notifyToServer(self::API_BUS_ADD, $param);
        return $response['result'];
    }

    /**
     * 业务凭证名称 (场景)
     * @param $businessId
     * @param $sceneName
     * @return array
     * @throws \Exception
     */
    public function createScene($businessId, $sceneName) :array
    {
        $sceneName = is_string($sceneName) ? [$sceneName] : $sceneName;
        $param = [
            'businessTempletId' => $businessId,
            'name'              => $sceneName,
        ];
        $response = $this->notifyToServer(self::API_SCENE_ADD, $param);
        return $response['result'];
    }

    /**
     * 创建证据点(名称)
     * @param $sceneId
     * @param $segName
     * @return array
     * @throws \Exception
     */
    public function createSeg($sceneId, $segName) :array
    {
        $segName = is_string($segName) ? [$segName] : $segName;
        $param = [
            'sceneTempletId' => $sceneId,
            'name'           => $segName,
        ];
        $response = $this->notifyToServer(self::API_SEG_ADD, $param);
        return $response['result'];
    }

    /**
     * 创建证据点字段属性
     * @param string $segId
     * @param array $properties
     * @return bool
     * @throws \Exception
     */
    public function createSegProp(string $segId, array $properties) :bool
    {
        $param = [
            'segmentTempletId' => $segId,
            'properties'       => $properties
        ];
        $response = $this->notifyToServer(self::API_SEGPROP_ADD, $param);
        return !!$response['result'];
    }


    /**
     * 创建证据链
     * @param $sceneName
     * @param $sceneId
     * @param array $linkIds
     * @return string
     * @throws \Exception
     */
    public function createLink($sceneName, $sceneId, $linkIds = []): string
    {
        $param = [
            'sceneName'       => $sceneName,
            'sceneTemplateId' => $sceneId,
            'linkIds'         => $linkIds,
        ];
        $response = $this->notifyToServer(self::API_VOUCHER, $param);
        return $response['evid'];
    }

    /**
     * 创建一个原文基础版证据点
     * @param string $segId 证据点名称ID
     * @param string $filePath 文件地址
     * @param array $segmentData 证据点参数
     * @return mixed evid && url
     * @throws \Exception
     */
    public function createPointBasic(string $segId, string $filePath, $segmentData = []) :array
    {
        $fileName = basename($filePath);
        $fileSize = filesize($filePath);
        $contentBase64Md5 = $this->getContentBase64Md5($filePath);

        //设置创建证据点参数
        $param = [
            "segmentTempletId" => $segId,
            "segmentData"      => json_encode($segmentData),
            "content"          => [
                "contentDescription" => $fileName,
                "contentLength"      => $fileSize,
                "contentBase64Md5"   => $contentBase64Md5
            ]
        ];
        $response = $this->notifyToServer(self::API_ORIGINAL_STANDARD, $param);
        return $response;
    }

    /**
     * 上传代保全文档
     * @param string $fileUploadUrl
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    public function uploadFile(string $fileUploadUrl, string $filePath)
    {
        $fileContent = file_get_contents($filePath);
        $contentBase64Md5 = $this->getContentBase64Md5($filePath);
        $status = $this->sendHttpPUT($fileUploadUrl, $contentBase64Md5, $fileContent);
        if ($status != 200) {
            throw new \Exception('待保全文档上传失败');
        }
        return true;
    }

    /**
     * 添加证据点到证据链
     * @param string $linkId
     * @param string $pointId
     * @param array $serviceIds
     * @return bool
     * @throws \Exception
     */
    public function addPointToLink(string $linkId, string $pointId, $serviceIds = []) :bool
    {
        $param = [
            'evid'    => $linkId,
            'linkIds' => [
                [
                    "type"  => "0",
                    "value" => $pointId,
                ],
            ]
        ];
        foreach ($serviceIds as $serviceId) {
            $param['linkIds'][] = [
                'type'  => '1',
                'value' => $serviceId,
            ];
        }
        $response = $this->notifyToServer(self::API_VOUCHER_APPEND, $param);
        return !!$response['success'];
    }

    /**
     * 关联证据链和用户
     * @param string $linkId
     * @param array $users
     * @return bool
     * @throws \Exception
     */
    public function addLinkToUser(string $linkId, array $users) :bool
    {
        $param = [
            'evid'         => $linkId,
            'certificates' => $users,
        ];
        $response = $this->notifyToServer(self::API_RELATE, $param);
        return !!$response['success'];
    }

    /**
     * 拼接查看存证证明URL
     * @param $linkId
     * @param int $expiredAt
     * @return string
     */
    public function getViewUrl($linkId, int $expiredAt = 0)
    {
        // 过期时间为毫秒级时间戳
        if ($expiredAt) {
            $timestampString = $expiredAt . '000';// 当前系统的时间戳
        } else {
            $timestampString = time() . '000';// 当前系统的时间戳
        }

        /*
         * $reverse
         * false表示timestamp字段为链接的生效时间，在生效30分钟后该链接失效
         * */
        $param = "id=" . $linkId . "&projectId=" . $this->_config['project_id'] . "&timestamp=" . $timestampString .
            "&reverse=" . (!$expiredAt) . "&type=" . "ID_CARD" . "&number=" . "540101198709260015";

        $signture = $this->makeRequestSign($param);
        return $this->getViewHost() . self::URL_VIEWPAGE . "?" . $param . "&signature=" . $signture;
    }
}
