<?php
/**
 * User: Administrator
 * Date: 2016/12/16
 */

namespace tech\core;


class Upload
{
    const CONTENT_TYPE = 'application/octet-stream';

    /**
     * 要保存的本地文件全路径
     */
    private $uploadFile = null;

    private $fileHandle = null;
    private $fileSize = null;

    private $fileContent = null;

    private $proxy = null;

    /**
     * 解析远程响应状态
     */
    private $responseCode;

    public function __construct($host = '', $port = '')
    {
        $host .= empty($port) ? '' : ':' . $port;
        $this->proxy = $host;
    }

    public function setFileContent($fileContent)
    {
        $this->fileContent = $fileContent;
        $this->fileSize = strlen($this->fileContent);
        return $this;
    }

    public function setUploadFile($uploadFile)
    {
        $this->uploadFile = $uploadFile;
        //$this->fileHandle = fopen($uploadFile, 'r');
        //$this->fileSize = filesize($uploadFile);
        $this->fileContent = file_get_contents($uploadFile);
        $this->fileSize = strlen($this->fileContent);

        return $this;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function getFileMd5()
    {
        return base64_encode(md5($this->fileContent, true));
    }

    public function saveFile($uploadUrl)
    {
        //$file = $this->fileContent;
        //$file = $this->uploadFile;
        $header = array(
            'Content-Type:' . self::CONTENT_TYPE,
            'Content-Md5:' . $this->getFileMd5()
        );

        $res = $this->sendHttpPUT($uploadUrl, $header);
        //return $this->parseResponse($res);
        return $res;
    }


    /**
     * 发送远程请求，HTTP PUT方式
     * @param $url
     * @param $header
     * @return mixed
     * @throws \Exception
     */
    private function sendHttpPUT($url, $header)
    {

        $status = '';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);
        curl_setopt($curl_handle, CURLOPT_HEADER, true); // 输出HTTP头 true
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5184000);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 120);
        //代理设置
        if (!empty($this->proxy)) {
            $header[] = 'Expect:';
            //curl_setopt($curl_handle, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($curl_handle, CURLOPT_PROXY, $this->proxy);
        }

        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
        if (is_resource($this->fileHandle)) {
            curl_setopt($curl_handle, CURLOPT_INFILESIZE, $this->fileSize);
            curl_setopt($curl_handle, CURLOPT_INFILE, $this->fileHandle);
            curl_setopt($curl_handle, CURLOPT_UPLOAD, true);
        } else {
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $this->fileContent);
        }
        $result = curl_exec($curl_handle);
        $status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

        if ($result === false) {
            $status = curl_errno($curl_handle);
            $result = 'put file to oss - curl error :' . curl_error($curl_handle);
        }
        curl_close($curl_handle);
        if (ESIGN_DEBUGE) {
            Log::debug('【文件直传返回结果：】' . $result);
        }
        $this->responseCode = $status;
        return $this->parseResponse($result);
    }


    /**
     * 解析远程返回的响应数据
     * @param $response
     * @return array
     */
    private function parseResponse($response)
    {
        if ($this->responseCode == 200) {
            //list($resheader, $resbody) = explode("\r\n\r\n", $response, 2);
            //echo 'header:' . $resheader;
            //echo 'body:' . $resbody;
            //$body = json_decode($response, true);
            $body = array(
                'errCode' => 0,
                'msg' => "成功"
            );
            return $body;
        } else {
            return array(
                'errCode' => $this->responseCode,
                'msg' => $response
            );
        }
    }

    /**
     * 清除文件资源
     */
    public function __destruct()
    {
        if (isset($this->uploadFile) && isset($this->fileHandle)) {
            fclose($this->fileHandle);
        }
        return $this;
    }
}