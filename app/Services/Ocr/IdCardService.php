<?php
/**
 * Note: OCR识别服务 - 身份证识别
 * User: Liu
 * Date: 2019/7/1
 */

namespace App\Services\Ocr;

class IdCardService
{
    // 传统格式
    private $isOldFormat = false;

    // 调用地址
    private $baseUrl = 'https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json';


    /**
     * 获取身份信息
     * @param $file
     * @param string $side
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function getData($file, $side = 'face')
    {
        // 身份证正反面类型:face/back
        $config = [
            "side" => $side
        ];

        // 转换成base64数据
        $base64 = $this->imageToBase64($file);
        $headers = [
            "Authorization:APPCODE " . config('ocr.idcard.appcode'),
            "Content-Type:application/json; charset=UTF-8",
        ];

        //if ($this->isOldFormat == true) {
        //    $request = array();
        //    $request["image"] = array(
        //        "dataType"  => 50,
        //        "dataValue" => "$base64"
        //    );
        //
        //    if (count($config) > 0) {
        //        $request["configure"] = array(
        //            "dataType"  => 50,
        //            "dataValue" => json_encode($config)
        //        );
        //    }
        //    $data = json_encode(array("inputs" => array($request)));
        //} else {
            $request = [
                "image" => "$base64"
            ];
            if (count($config) > 0) {
                $request["configure"] = json_encode($config);
            }
            $data = json_encode($request);
        //}
        $response = $this->requestPost($this->baseUrl, $data, $headers);
        if (!$response) {
            throw new \Exception('API接口未响应');
        }
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * @param $url
     * @param $data
     * @param array $headers
     * @return bool|string
     * @throws \Exception
     */
    private function requestPost($url, $data, $headers = [])
    {
        $method = "POST";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $rheader = substr($result, 0, $header_size);
        $rbody = substr($result, $header_size);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            //printf("Http error code: %d\n", $httpCode);
            //printf("Error msg in body: %s\n", $rbody);
            //printf("header: %s\n", $rheader);
            throw new \Exception($rbody);
        }

        if ($this->isOldFormat) {
            $output = json_decode($rbody, true);
            $result_str = $output["outputs"][0]["outputValue"]["dataValue"];
        } else {
            $result_str = $rbody;
        }
        return $result_str;
    }

    /**
     * 图片文件转换成base64格式
     * @param $file
     * @return string
     * @throws \Exception
     */
    protected function imageToBase64($file)
    {
        if ($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file)); // 文件读取
            fclose($fp);
            $base64 = base64_encode($binary); // 转码
            return $base64;
        }
        throw new \Exception('图片文件不存在');
    }
}