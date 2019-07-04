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
use tech\constants\PersonArea;

class EsignService
{
    public static $eSign;

    /**
     * EsignService constructor.
     */
    public function __construct()
    {
        logger(__METHOD__, []);
        $this->init();
        self::$eSign = new eSign();
    }

    /**
     * 定义常量
     */
    protected function init()
    {
        logger(__METHOD__, []);
        if (defined('ESIGN_ROOT')) {
            return;
        }
        define("ESIGN_ROOT", base_path('extends/tech'));
        define("ESIGN_CLASS_PATH", ESIGN_ROOT . "/core/");

        //调试模式，false：不打印相关日志；true、请设置日志文件目录以及读写权限
        define('ESIGN_DEBUGE', true);

        //日志文件目录
        define("ESIGN_LOG_DIR", storage_path('logs/esign/'));
        if (ESIGN_DEBUGE && !is_dir(ESIGN_LOG_DIR)) mkdir(ESIGN_LOG_DIR, 0777, true);
        define('INC_DAT_PATH', ESIGN_ROOT . "/comm/inc.dat");
    }

    /**
     * 创建个人账户
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function addPerson($data)
    {
        $mobile = $data['mobile'];
        $name = $data['name'];
        $idNo = $data['idcard'];
        $personarea = PersonArea::MAINLAND;// 地区类型 0大陆 1香港 2澳门 3台湾 4外籍
        $email = $data['email'] ?? '';
        $organ = $data['organ'] ?? '';
        $title = $data['title'] ?? '';
        $address = $data['address'] ?? '';

        $ret = self::$eSign->addPersonAccount($mobile, $name, $idNo, $personarea, $email, $organ, $title, $address);
        if ($ret['errCode']) {
            throw new \Exception($ret['msg']);
        }
        $accountid = end($ret);
        return $accountid;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function userSign($data)
    {
        $accountId = $data['accountid'];
        $signFile = $data['signFile'];
        $signPos = $data['signPos'];
        $signType = $data['signType'];
        $sealData = $data['sealData'];
        $stream = $data['stream'];
        $ret = self::$eSign->userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $stream);
        if ($ret['errCode']) {
            throw new \Exception($ret['msg']);
        }
        $signServiceId = end($ret);
        return $signServiceId;
    }

    /**
     * 创建个人印章
     * @param $personAccountId
     * @return mixed
     */
    //public function addPersonTemplateSeal($personAccountId)
    //{
    //    $accountId = $personAccountId;
    //    $templateType = PersonTemplateType::RECTANGLE;
    //    $color = SealColor::RED;
    //    $ret = self::$eSign->addTemplateSeal($accountId, $templateType, $color);
    //    $imageBase64 = end($ret);
    //    return $imageBase64;
    //}

    /**
     * 平台自身签署
     * @return mixed
     * @throws \Exception
     */
    //public function selfSignPDF11()
    //{
    //    $sealId = "0";
    //    //  Single	单页签章、Multi	多页签章、Edges	签骑缝章、Key	关键字签章
    //    $signType = SignType::SINGLE;
    //    $signPos = array(
    //        'posPage'       => "1",
    //        'posX'          => "400",
    //        'posY'          => "700",
    //        'key'           => "",
    //        'width'         => '159',
    //        'isQrcodeSign'  => false,
    //        'cacellingSign' => false,
    //        'addSignTime'   => false
    //    );
    //    $signFile = array(
    //        'srcPdfFile'    => "D:/test.pdf",
    //        'dstPdfFile'    => "D:/签署后_self72.pdf",
    //        'fileName'      => "",
    //        'ownerPassword' => ''
    //    );
    //    $ret = self::$eSign->selfSignPDF($signFile, $signPos, $sealId, $signType, $stream = true);
    //    if ($ret['errCode']) {
    //        throw new \Exception($ret['msg']);
    //    }
    //    $signServiceId = end($ret);
    //    return $signServiceId;
    //}

    /**
     * 发送签署短信验证码
     * @param $personAccountId
     * @return bool
     * @throws \Exception
     */
    //public function sendSignCode($personAccountId)
    //{
    //    $ret = self::$eSign->sendSignCode($personAccountId);
    //    if ($ret['errCode']) {
    //        throw new \Exception($ret['msg']);
    //    }
    //    return true;
    //}

    /**
     * 发送签署短信验证码（指定手机号）
     * @param $accountId
     * @param $mobile
     * @return bool
     * @throws \Exception
     */
    //public function sendMassge3rd($accountId, $mobile)
    //{
    //    $ret = self::$eSign->sendSignCodeToMobile($accountId, $mobile);
    //    if ($ret['errCode']) {
    //        throw new \Exception($ret['msg']);
    //    }
    //    return true;
    //}

    /**
     * 平台用户PDF摘要签署（文件流&短信验证）
     * @param $accountid
     * @param $sealData
     * @param $code
     * @return mixed
     */
    //public function sendSignCode_sign($accountid, $sealData, $code)
    //{
    //    //  Single	单页签章、Multi	多页签章、Edges	签骑缝章、Key	关键字签章
    //    $signType = SignType::SINGLE;
    //    $signPos = array(
    //        'posPage'       => "1",
    //        'posX'          => "400",
    //        'posY'          => "700",
    //        'key'           => "",
    //        'width'         => '159',
    //        'isQrcodeSign'  => true,
    //        'cacellingSign' => false,
    //        'addSignTime'   => true
    //    );
    //    $signFile = array(
    //        'srcPdfFile'    => "D:/test.pdf",
    //        'dstPdfFile'    => "D:/签署后_self628.pdf",
    //        'fileName'      => "",
    //        'ownerPassword' => ''
    //    );
    //    $ret = self::$eSign->userSafeSignPDF($accountid, $signFile, $signPos, $signType, $sealData, $code, $stream = false);
    //    $signServiceId = end($ret);
    //    return $signServiceId;
    //}

    /**
     * 指定手机号发送短信验证码签署
     * @param $accountid
     * @param $sealData
     * @param $mobile
     * @param $code
     * @return mixed
     */
    //public function sendMassge3rd_sign($accountid, $sealData, $mobile, $code)
    //{
    //    //  Single	单页签章、Multi	多页签章、Edges	签骑缝章、Key	关键字签章
    //    $signType = SignType::SINGLE;
    //    $signPos = array(
    //        'posPage'       => "1",
    //        'posX'          => "400",
    //        'posY'          => "700",
    //        'key'           => "",
    //        'width'         => '159',
    //        'isQrcodeSign'  => true,
    //        'cacellingSign' => false,
    //        'addSignTime'   => true
    //    );
    //    $signFile = array(
    //        'srcPdfFile'    => "D:/test.pdf",
    //        'dstPdfFile'    => "D:/签署后_self628.pdf",
    //        'fileName'      => "",
    //        'ownerPassword' => ''
    //    );
    //    $ret = self::$eSign->userSafeMobileSignPDF($accountid, $signFile, $signPos, $signType, $sealData, $mobile, $code, $stream = false);
    //    $signServiceId = end($ret);
    //    return $signServiceId;
    //}

    /**
     * 本地pdf模版生成
     * @return mixed
     */
    //public function createFromTemplate()
    //{
    //    $isFlat = true;
    //    $tmpFile = array(
    //        'srcFileUrl'    => "D:/ceshi_12-07/1/授权协议书.pdf",
    //        'dstFileUrl'    => "D:/授权协议书_填充后823.pdf",
    //        'ownerPassword' => "",
    //        'fileName'      => ""
    //    );
    //    $txtFields = array(
    //        'name'     => "叠风",
    //        'address'  => '杭州西湖',
    //        'authName' => '叠风22',
    //        'authTime' => '2018-06-26'
    //    );
    //    $ret = self::$eSign->createFromTemplate($tmpFile, $isFlat, $txtFields, false);
    //    $dstPdfFile = end($ret);
    //    return $dstPdfFile;
    //}

    /**
     * 创建个人模板印章
     * @return mixed
     */
    //public function addPersonalSealLocal(){
    //    $text = "叠风_12";
    //    $templateType = PersonTemplateType::RECTANGLE;
    //    $color = SealColor::RED;
    //    $ret = self::$eSign->addPersonalSealLocal($text,$templateType,$color);
    //    //print_r($ret);
    //    $imageBase64 = end($ret);
    //    return $imageBase64;
    //}
}