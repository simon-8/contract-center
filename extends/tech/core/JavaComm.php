<?php
/**
 * User: Administrator
 * Date: 2016/12/8
 */

namespace tech\core;

use tech\constants\SignType;
use tech\core\HttpUtils;
use tech\core\Util;
use tech\core\Log;

class JavaComm
{
    private $serverName;

    private static $serverUrl = array(
        'javaInitUrl' => '/tech-sdkwrapper/timevale/init',
        'selfFileSignUrl' => '/tech-sdkwrapper/timevale/sign/selfFileSign',
        'selfStreamSignUrl' => '/tech-sdkwrapper/timevale/sign/selfStreamSign',
        'userFileSignUrl' => '/tech-sdkwrapper/timevale/sign/userFileSign',
        'userFileSignCodeUrl' => '/tech-sdkwrapper/timevale/sign/userFileCodeSign',
        'userFileSignMobileUrl' => '/tech-sdkwrapper/timevale/sign/userFileMobileSign',
        'userStreamSignUrl' => '/tech-sdkwrapper/timevale/sign/userStreamSign',
        'userStreamSignCodeUrl' => '/tech-sdkwrapper/timevale/sign/userStreamCodeSign',
        'userStreamSignMobileUrl' => '/tech-sdkwrapper/timevale/sign/userStreamMobileSign',
        'eventFileSignUrl' => '/tech-sdkwrapper/timevale/sign/eventFileSign', //事件证书摘要签署
        'eventStreamSignUrl' => '/tech-sdkwrapper/timevale/sign/eventStreamSign', //事件证书文件流签署
        'verifyPdfUrl' => '/tech-sdkwrapper/timevale/verify/fileVerify',
        'streamVerifyUrl' => '/tech-sdkwrapper/timevale/verify/streamVerify',
        'verifyTextUrl' => '/tech-sdkwrapper/timevale/verify/textVerify',
        'codeMultiSignUrl' => '/tech-sdkwrapper/timevale/sign/codeMultiSign',
        'mobileMultiSignUrl' => '/tech-sdkwrapper/timevale/sign/mobileMultiSign',//短信批量签署
        'simpleFileSignUrl' => '/tech-sdkwrapper/timevale/sign/simpleFileSign',//简约签，平台用户签署
        'simpleStreamSignUrl' => '/tech-sdkwrapper/timevale/sign/simpleStreamSign',//简约签，平台用户文件流签署
        'tgFileSign' => '/tech-sdkwrapper/timevale/sign/tgFileSign', //天谷证明章
        'tgStreamSign' => '/tech-sdkwrapper/timevale/sign/tgStreamSign', //天谷证明章 文件流方式
        'addPersonTemplate' => '/tech-sdkwrapper/timevale/seal/createPersonalTemplateSeal', //创建个人本地印章
        'addOfficialTemplateSeal' => '/tech-sdkwrapper/timevale/seal/createOfficialTemplateSeal', //创建企业本地印章
        'createFromTemplate' => '/tech-sdkwrapper/timevale/doc/file/createFromTemplate', //本地pdf模板生成
        'createFromTemplateStream' => '/tech-sdkwrapper/timevale/doc/stream/createFromTemplate', //本地pdf模板生成,文件流
		'preverifyCode' => '/tech-sdkwrapper/timevale/mobile/preverifyCode',
		'preverify3rdCode' => '/tech-sdkwrapper/timevale/mobile/preverify3rdCode',
    );

    public function __construct($serverName)
    {
        $this->serverName = $serverName;
    }

    /**
     * 初始化 本地java服务
     * @param $config
     * @throws \Exception
     */
    public function init($config)
    {
        if (!empty($config['rsa_private_key'])) {
            $privateKey = $config['rsa_private_key'];
        } else {
            $privateKey = '';
        }
        if (!empty($config['esign_public_key'])) {
            $publicKey = $config['esign_public_key'];
        } else {
            $publicKey = '';
        }
        //请求参数
        $keysArr = array(
            'projectConfig' => array(
                'projectId' => $config['project_id'],
                'projectSecret' => $config['project_secret'],
                'itsmApiUrl' => $config['open_api_url']
            ),
            'httpConfig' => array(
                'proxyIp' => $config['proxy_ip'],
                'proxyPort' => $config['proxy_port'],
                'retry' => empty($config['retry']) ? 3 : $config['retry'],
                'httpType' => empty($config['http_type']) ? 'HTTPS' : $config['http_type']
            ),
            'signConfig' => array(
                'algorithm' => $config['sign_algorithm'],
                'privateKey' => $privateKey,
                'esignPublicKey' => $publicKey
            )
        );
        $res = $this->postJson('javaInitUrl', $keysArr);
        //$result = new Result($res);
        //$res = $result->getData();
        $errCode = !isset($res['errCode']) ? 101 : $res['errCode'];
        if ((int)$errCode !== 0) {
            throw new \Exception('本地java服务初始化失败 - ' . Util::encodePath($res['httpContent']));
        }
    }

    /**
     * 使用事件证书对文档进行签署，此签署过程不将文档上传至e签宝平台，只传递文档摘要信息。
     * 注：事件证书具有单次有效性，即使用证书完成签署后，此证书立即失效，不可重复使用。
     *
     * @param array $signFile
     * @param array $signPos
     * @param $signType
     * @param $certId
     * @param string $sealData
     * @return array|mixed
     */
    public function eventSignPDF(array $signFile, array $signPos, $signType, $certId, $sealData = '')
    {
        if (!empty($signPos['key'])) {
            $posType = 1;
        } else {
            $posType = 0;
        }

        $keysArr = array(
            'signPos' => array(
                'posType' => $posType,
                'posPage' => isset($signPos['posPage']) ? $signPos['posPage'] : 1,
                'posX' => isset($signPos['posX']) ? floatval($signPos['posX']) : 0,
                'posY' => isset($signPos['posY']) ? floatval($signPos['posY']) : 0,
                'key' => isset($signPos['key']) ? $signPos['key'] : '',
                'width' => isset($signPos['width']) ? floatval($signPos['width']) : 0,
                'qrcodeSign' => (isset($signPos['isQrcodeSign'])
                    && $signPos['isQrcodeSign'] === true) ? true : false,
                'cacellingSign ' => (isset($signPos['cacellingSign'])
                    && $signPos['cacellingSign'] === true) ? true : false,
                'addSignTime' => (!empty($signPos['addSignTime'])
                    && $signPos['addSignTime'] === true) ? true : false //是否显示签署时间
            ),
            'signType' => $signType,
            'certId' => $certId,
            'sealData' => $sealData,
            'file' => array(
                'srcPdfFile' => $signFile['srcPdfFile'],
                'dstPdfFile' => $signFile['dstPdfFile'],
                'fileName' => isset($signFile['fileName']) ? $signFile['fileName'] : '',
                'ownerPassword' => isset($signFile['ownerPassword']) ? $signFile['ownerPassword'] : ''
            )
        );

        $response = $this->postJson('eventFileSignUrl', $keysArr);
        return $response;
    }

    /**
     * 使用事件证书对文档进行签署，此签署过程不将文档上传至e签宝平台，只传递文档摘要信息。
     * 注：事件证书具有单次有效性，即使用证书完成签署后，此证书立即失效，不可重复使用。
     *
     * @param array $signFile
     * @param array $signPos
     * @param $signType
     * @param $certId
     * @param string $sealData
     * @return array|mixed
     */
    public function eventSignPDFSteam(array $signFile, array $signPos, $signType, $certId, $sealData = '')
    {
        if (!empty($signPos['key'])) {
            $posType = 1;
        } else {
            $posType = 0;
        }

        $pos = array(
            'posType' => $posType,
            'posPage' => isset($signPos['posPage']) ? $signPos['posPage'] : 1,
            'posX' => isset($signPos['posX']) ? floatval($signPos['posX']) : 0,
            'posY' => isset($signPos['posY']) ? floatval($signPos['posY']) : 0,
            'key' => isset($signPos['key']) ? $signPos['key'] : '',
            'width' => isset($signPos['width']) ? floatval($signPos['width']) : 0,
            'qrcodeSign' => (isset($signPos['isQrcodeSign'])
                && $signPos['isQrcodeSign'] === true) ? true : false,
            'cacellingSign ' => (isset($signPos['cacellingSign'])
                && $signPos['cacellingSign'] === true) ? true : false,
             'addSignTime' => (!empty($signPos['addSignTime'])
            && $signPos['addSignTime'] === true) ? true : false //是否显示签署时间
        );
        $keysArr = array(
            'signPos' => Util::jsonEncode($pos),
            'signType' => $signType,
            'certId' => $certId,
            'sealData' => $sealData,
            'file' => HttpUtils::request()->getRealFileIgnore(Util::encodePath($signFile['srcPdfFile'])),
            'fileName' => isset($signFile['fileName']) ? $signFile['fileName'] : '',
            'ownerPassword' => isset($signFile['ownerPassword']) ? $signFile['ownerPassword'] : ''
        );
        $response = $this->post('eventStreamSignUrl', $keysArr);
        if ($response['errCode'] === 0) {
            $s = file_put_contents(Util::encodePath($signFile['dstPdfFile']), base64_decode($response['stream']), true);
            if ($s === false) {
                return array(
                    'errCode' => 103,
                    'msg' => '签署后的文档保存至目标文件失败!' . $signFile['dstPdfFile'],
                );
            }
        }
        return $response;
    }

    /**
     * pdf本地文件签署
     *
     * @param array $signFile
     * @param array $signPos
     * @param $sealId
     * @param $signType
     * @return array|mixed
     */
    public function selfSignPDF(array $signFile, array $signPos, $sealId, $signType)
    {
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, false);
        $keysArr['sealId'] = (int)$sealId;
        $response = $this->postJson('selfFileSignUrl', $keysArr);
        return $response;
    }

    /**
     * pdf本地签署 ，文件流方式
     * @param array $signFile
     * @param array $signPos
     * @param $sealId
     * @param $signType
     * @return mixed
     * @throws Exception
     */
    public function selfSignPDFStream(array $signFile, array $signPos, $sealId, $signType)
    {
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, true);
        $keysArr['sealId'] = (int)$sealId;
        $response = $this->post('selfStreamSignUrl', $keysArr);
        //$ret = new Result($response);
        //$res = $ret->getData();
        if ($response['errCode'] == 0) {
            $s = file_put_contents(Util::encodePath($signFile['dstPdfFile']), base64_decode($response['stream']), true);
            if ($s === false) {
                return array(
                    'errCode' => 103,
                    'msg' => '签署后的文档保存至目标文件失败。' . $signFile['dstPdfFile'],
                );
            }
        }
        return $response;
    }

    /**
     * 平台用户本地摘要签署
     *
     * @param $accountId
     * @param $sealData
     * @param $signFile
     * @param $signType
     * @param $signPos
     * @return array|mixed
     */
    public function userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $mobile = '', $code = '', $smiple = false)
    {
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, false);
        $keysArr['accountId'] = $accountId;
        $keysArr['sealData'] = $sealData;
        if (!empty($code)) {
            $keysArr['code'] = $code;
            if (!empty($mobile)) {
                $keysArr['mobile'] = $mobile;
                $response = $this->postJson('userFileSignMobileUrl', $keysArr);
            } else {
                //var_dump($keysArr);
                $response = $this->postJson('userFileSignCodeUrl', $keysArr);
            }
        } else {
            //$response = $this->postJson('userFileSignUrl', $keysArr);
            if ($smiple === true) {
                $response = $this->postJson('simpleFileSignUrl', $keysArr);
            } else {
                $response = $this->postJson('userFileSignUrl', $keysArr);
            }
        }

        return $response;
    }

    /**
     * 平台用户文档摘要签署，文件流方式
     * @param $accountId
     * @param $signFile
     * @param $signPos
     * @param $signType
     * @param $sealData
     * @param string $mobile
     * @param string $code
     * @return mixed
     * @throws Exception
     */
    public function userSignPDFStream($accountId, $signFile, $signPos, $signType, $sealData, $mobile = '', $code = '', $smiple = false)
    {
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, true);
        $keysArr['accountId'] = $accountId;
        $keysArr['sealData'] = $sealData;
        if (!empty($code)) {
            $keysArr['code'] = $code;
            if (!empty($mobile)) {
                $keysArr['mobile'] = $mobile;
                $response = $this->post('userStreamSignMobileUrl', $keysArr);
            } else {
                $response = $this->post('userStreamSignCodeUrl', $keysArr);
            }
        } else {
            //$response = $this->post('userStreamSignUrl', $keysArr);
            if ($smiple === true) {
                $response = $this->post('simpleStreamSignUrl', $keysArr);
            } else {
                $response = $this->post('userStreamSignUrl', $keysArr);
            }
        }

        //签署后的文件流保存到本地
        if ($response['errCode'] == 0) {
            $s = file_put_contents(Util::encodePath($signFile['dstPdfFile']), base64_decode($response['stream']), true);
            if ($s === false) {
                return array(
                    'errCode' => 103,
                    'msg' => '签署后的文档保存失败' . $signFile['dstPdfFile'],
                );
            }
        }
        return $response;
    }

    /**
     * @param $accountId  用户ID
     * @param $signParams 待签署文档信息 最多10份
     * @param $sealData 印章数据
     * @param string $mobile 是否指定验证码手机号；
     * @param $code 短信验证码
     * @return array|mixed
     */
    public function userMutilSignPDF($accountId, $signParams, $sealData, $mobile = '', $code)
    {
        foreach ($signParams as $key => $val) {
            if ($val['signType'] === SignType::KEYWORD) {
                $posType = 1;
            } else {
                $posType = 0;
            }
            $signParams[$key]['signPos']['posType'] = $posType;
        }
        $keysArr = array(
            'accountId' => $accountId,
            'sealData' => $sealData,
            'code' => $code,
            'signParams' => $signParams
        );
        if (!empty($mobile)) {
            $keysArr['mobile'] = $mobile;
            $response = $this->postJson('mobileMultiSignUrl', $keysArr); //指定手机验证码
        } else {
            $response = $this->postJson('codeMultiSignUrl', $keysArr);
        }
        return $response;
    }

    /**
     * 天谷证明章签署 非文件流
     * @param array $signFile
     * @param array $signPos
     * @param $signType
     * @return array|mixed
     */
    public function tgFileSign(array $signFile, array $signPos, $signType)
    {
        //TODO
        if (!empty($signPos['key'])) {
            $posType = 1;
        } else {
            $posType = 0;
        }
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, false);
        $response = $this->postJson('tgFileSign', $keysArr);
        return $response;
    }

    /**
     * 天谷证明章签署 文件流
     * @param array $signFile
     * @param array $signPos
     * @param $signType
     * @return array|mixed
     */
    public function tgStreamSign(array $signFile, array $signPos, $signType)
    {
        $keysArr = $this->buildRequest($signFile, $signPos, $signType, true);
        $response = $this->post('tgStreamSign', $keysArr);
        if ($response['errCode'] == 0) {
            $s = file_put_contents(Util::encodePath($signFile['dstPdfFile']), base64_decode($response['stream']), true);
            if ($s === false) {
                return array(
                    'errCode' => 103,
                    'msg' => '签署后的文档保存失败' . $signFile['dstPdfFile'],
                );
            }
        }
        return $response;
    }


    /**
     * 验证PDF文档签名的有效性
     * @param $filepath 已签的pdf文件完整路径 包含文件名
     * @return array|mixed|MyErrorException
     */
    public function filePathVerify($filepath)
    {
        $keysArr = array(
            "file" => $filepath
        );

        $response = $this->postJson('verifyPdfUrl', $keysArr);
        return $response;
    }

    /**
     * 验证PDF文档签名的有效性，支持文件流
     * @param $file
     * @return mixed|MyErrorException
     */
    public function streamVerify($file)
    {
        if (empty($file)) {
            return ErrorConstant::$FILE_NOT_EXIST;
        }
        $keysArr['file'] = HttpUtils::request()->getRealFileIgnore(Util::encodePath($file));
        $response = $this->post('streamVerifyUrl', $keysArr);
        return $response;
    }

    /**
     * 文本验签
     * @param $srcData 待验证的文本数据原文
     * @param $signResult 签署结果
     * @return array|mixed|MyErrorException
     */
    public function localVerifyText($srcData, $signResult)
    {
        $keysArr = array(
            "srcData" => $srcData,
            "signResult" => $signResult
        );
        $response = $this->postJson('verifyTextUrl', $keysArr);
        return $response;
    }

    public function  addOrganizeTemplateSeal($roundText, $templateType, $color, $hText, $qText)
    {
        $keysArr = array(
            'roundText' => $roundText,
            'templateType' => $templateType,
            'color' => $color,
            'hText' => $hText,
            'qText' => $qText
        );
        $response = $this->postJson('addOfficialTemplateSeal', $keysArr);
        return $response;
    }

    public function  addPersonalTemplateSeal($text, $templateType, $color)
    {
        $keysArr = array(
            'text' => $text,
            'templateType' => $templateType,
            'color' => $color
        );
        $response = $this->postJson('addPersonTemplate', $keysArr);
        return $response;
    }


    /**
     * 本地文档模板生成pdf
     * @param $tmpFile
     * @param $isFlat
     * @param $txtFields
     * @param $isStream
     * @return array|mixed
     */
    public function createFromTemplate($tmpFile, $isFlat, $txtFields, $isStream)
    {
        $keysArr = array(
            'ownerPassword' => isset($tmpFile['ownerPassword']) ? $tmpFile['ownerPassword'] : '',
            'flatten' =>  (!empty($isFlat) && $isFlat === true) ? true : false
        );
        $isStream = (!empty($isStream) && $isStream === true) ? true : false;
        if ($isStream === true) {
            //var_dump($keysArr);
            if (!empty($txtFields)) {
                $keysArr['txtFields'] = Util::jsonEncode($txtFields);
            }
            $keysArr['file'] = HttpUtils::request()->getRealFileIgnore(Util::encodePath($tmpFile['srcFileUrl']));
            
            $response = $this->post('createFromTemplateStream', $keysArr);

            /*if ($response['errCode'] == 0 && !empty($tmpFile['dstFileUrl'])) {
                $s = file_put_contents(Util::encodePath($tmpFile['dstFileUrl']), base64_decode($response['stream']));
                $response['dstFileUrl'] = $tmpFile['dstFileUrl'];
            }*/
            return $response;
        } else {
            if (!empty($txtFields)) {
                $keysArr['txtFields'] = $txtFields;
            }
            $keysArr['srcFileUrl'] = $tmpFile['srcFileUrl'];
            $keysArr['dstFileUrl'] = $tmpFile['dstFileUrl'];
            $response = $this->postJson('createFromTemplate', $keysArr);
        }
        return $response;
    }

	public function preverifyCode($accountId, $code) {
		$keysArr = array(
            'accountId' => $accountId,
            'code' =>  $code
        );
		$response = $this->postJson('preverifyCode', $keysArr);
		return $response;
	}

	
	public function preverify3rdCode($accountId, $mobile, $code) {
		$keysArr = array(
            'accountId' => $accountId,
            'mobile' => $mobile,
            'code' =>  $code
        );
		$response = $this->postJson('preverify3rdCode', $keysArr);
		return $response;
	}

    /**
     * 构建签署的请求参数
     * @param $signFile
     * @param $signPos
     * @param $signType
     * @param bool|false $stream
     * @return array
     */
    private function buildRequest($signFile, $signPos, $signType, $stream = false)
    {
        if (!empty($signPos['key'])) {
            $posType = 1;
        } else {
            $posType = 0;
        }
        $signPos = array(
            'posType' => $posType,
            'posPage' => isset($signPos['posPage']) ? $signPos['posPage'] : 1,
            'posX' => isset($signPos['posX']) ? floatval($signPos['posX']) : 0,
            'posY' => isset($signPos['posY']) ? floatval($signPos['posY']) : 0,
            'key' => isset($signPos['key']) ? $signPos['key'] : '',
            'width' => isset($signPos['width']) ? floatval($signPos['width']) : 0,
            'qrcodeSign' => (!empty($signPos['isQrcodeSign'])
                && $signPos['isQrcodeSign'] === true) ? true : false,//签章二维码
            'cacellingSign' => (!empty($signPos['cacellingSign'])
                && $signPos['cacellingSign'] === true) ? true : false, //作废签
            'addSignTime' => (!empty($signPos['addSignTime'])
                && $signPos['addSignTime'] === true) ? true : false //是否显示签署时间
        );
        $keysArr = array(
            'signType' => $signType
        );
        if ($stream === true) {
            $keysArr['signPos'] = Util::jsonEncode($signPos);
            $keysArr['file'] = HttpUtils::request()->getRealFileIgnore(Util::encodePath($signFile['srcPdfFile']));
            $keysArr['fileName'] = isset($signFile['fileName']) ? $signFile['fileName'] : '';
            $keysArr['ownerPassword'] = isset($signFile['ownerPassword']) ? $signFile['ownerPassword'] : '';
        } else {
            $keysArr['signPos'] = $signPos;
            $keysArr['file'] = array(
                'srcPdfFile' => $signFile['srcPdfFile'],
                'dstPdfFile' => $signFile['dstPdfFile'],
                'fileName' => isset($signFile['fileName']) ? $signFile['fileName'] : '',
                'ownerPassword' => isset($signFile['ownerPassword']) ? $signFile['ownerPassword'] : ''
            );
        }
        return $keysArr;
    }

    /**
     * 发送请求 参数JSON方式
     * @param $urlKey
     * @param $keysArr
     * @return array|mixed
     * @throws Exception
     */
    private function postJson($urlKey, $keysArr)
    {
        $authUrl = $this->serverName . self::$serverUrl[$urlKey];
        try {
            $response = HttpUtils::request()->noSignHttpPost($authUrl, $keysArr, true, false);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }

    /**
     * 发送请求， POST
     * @param $urlKey
     * @param $keysArr
     * @return mixed
     */
    private function post($urlKey, $keysArr)
    {
        $authUrl = $this->serverName . self::$serverUrl[$urlKey];
        $response = HttpUtils::request()->noSignHttpPost($authUrl, $keysArr, false, false);
        //$response = $this->postFile($authUrl, $keysArr);
        return $response;
    }

    private function postFile($url, array $keysArr = array())
    {
        // invalid characters for "name" and "filename"
        static $disallow = array("\0", "\"", "\r", "\n");

        $body = array();
        // build normal parameters
        foreach ($keysArr as $k => $v) {
            if ($k == 'file') {
                $file = $v->name;
                // build file parameters
                $data = file_get_contents($file);
                $body[] = implode("\r\n", array(
                    "Content-Disposition: form-data; name=\"file\"; filename=\"{$file}\"",
                    "Content-Type: application/octet-stream",
                    "",
                    $data,
                ));
            }

            $k = str_replace($disallow, "_", $k);
            $body[] = implode("\r\n", array(
                "Content-Disposition: form-data; name=\"{$k}\"",
                "",
                filter_var($v),
            ));
        }

        // generate safe boundary
        do {
            $boundary = "---------------------" . md5(mt_rand() . microtime());
        } while (preg_grep("/{$boundary}/", $body));

        // add boundary for each parameters
        array_walk($body, function (&$part) use ($boundary) {
            $part = "--{$boundary}\r\n{$part}";
        });

        // add final boundary
        $body[] = "--{$boundary}--";
        $body[] = "";

        HttpUtils::request()->sendHttpRequestPost(
            $url,
            implode("\r\n", $body),
            $header = array(
                "Content-Type: multipart/form-data; boundary={$boundary}",
            )
        );
        return json_decode(HttpUtils::request()->responseBody, TRUE);
    }

}