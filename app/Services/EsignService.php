<?php
/**
 * Note: E签宝Service
 * User: Liu
 * Date: 2019/6/26
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;

use tech\core\eSign;
use tech\core\Util;
use tech\constants\SignType;
use tech\constants\PersonTemplateType;
use tech\constants\OrganizeTemplateType;
use tech\constants\OrganRegType;
use tech\constants\SealColor;

class EsignService
{
    //protected $config;
    //protected $accessToken;
    //
    //// API接口调用地址
    //protected $baseUrl = 'https://evislb.tsign.cn:443';
    //protected $baseUrlDev = 'https://smlcunzheng.tsign.cn:9443';
    //
    //// 存证证明查看页面Url
    //protected $baseViewPageUrl = 'https://smlcunzheng.tsign.cn';
    //protected $baseViewPageUrlDev = 'https://eviweb.tsign.cn';

    public static $eSign;

    public function __construct()
    {
        //$this->config = config('tsign');
        //include (base_path("extends/esign/eSignOpenAPI.php"));
        self::$eSign = new eSign();
    }

    /**
     * @param $data
     * @return string
     */
    //protected function makeRequestSign($data) {
    //    $signature = hash_hmac('sha256', $data, $this->config['appSecret'], FALSE);
    //    return $signature;
    //}

    /**
     * @param $api
     * @return string
     */
    //protected function getUrl($api)
    //{
    //    $baseUrl = config('app.env') === 'local' ? $this->baseUrlDev : $this->baseUrl;
    //    return $baseUrl. $api;
    //}

}