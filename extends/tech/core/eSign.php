<?php
/**
 * tech sdk php e签宝快捷签 SDK PHP版实现类
 *
 * User: wanglf
 * Date: 2016/12/14
 *
 * */
namespace tech\core;

use tech\constants\EventType;
use tech\constants\OrganRegType;
use tech\constants\UserType;
use tech\constants\OrganType;
use tech\constants\PersonArea;
use tech\constants\OrganizeTemplateType;
use tech\constants\PersonTemplateType;
use tech\constants\SealColor;
use tech\constants\ErrorConstant;
use tech\constants\SignType;
use tech\constants\LicenseType;
use tech\result\AddAccountResult;
use tech\result\AddEventCertResult;
use tech\result\AddTemplateResult;
use tech\result\FileSignResult;
use tech\result\GetSignDetailResult;
use tech\result\Result;
use tech\result\TextSignResult;
use tech\result\VerifyPdfResult;
use tech\core\JavaComm;
use tech\core\HttpUtils;
use tech\core\Util;
use tech\core\Recorder;
use tech\core\Upload;

class eSign
{
    /**
     * 版本号
     */
    const VERSION = '2.0.17';

    /**
     * 发送渠道
     */
    const CHANNEL = 'phptechsdk2.0.17';

    /**
     * 配置文件
     */
    private static $_CONFIG = array();

    /**
     * recorder 对象
     */
    private $recorder;

    /**
     * javaComm 对象
     */
    private $javaComm;

    public function __construct()
    {
        if (empty(self::$_CONFIG)) {
            self::$_CONFIG = include ESIGN_ROOT . '/comm/initConfig.php';
        }
        $this->javaComm = new javaComm(self::$_CONFIG['java_server']);
        $this->recorder = new Recorder();
        $this->init();
    }

    /*
     * 初始化，获取用户授权接口
     * */
    public function init($n = false)
    {
        //project_id 不能为空
        if (empty(self::$_CONFIG['project_id'])) {
            throw new \Exception(ErrorConstant::$PROJECT_ID_NULLPOINTER);
        }
        //签名方式为hmac-sha256，project_secret不能为空
        if (strtoupper(self::$_CONFIG['sign_algorithm']) == 'HMACSHA256'
            && empty(self::$_CONFIG['project_secret'])
        ) {
            throw new \Exception(ErrorConstant::$PROJECT_SECRET_NULLPOINTER);
        }
        //apiUrl 不能为空
        if (empty(self::$_CONFIG['open_api_url'])) {
            throw new \Exception('初始化地址不能为空');
        }

        //初始化本地java服务
        $this->javaComm->init(self::$_CONFIG);

        //是否需要重新初始化
        if ($n === false && $this->needInit() === false) {
            return 0;
        }

        //获取授权地址
        $result = $this->getAuthUrlList();

        if ($result === 0) {
            $this->recorder->write('pid', self::$_CONFIG['project_id']);
            $this->recorder->write('equipId', Util::getMacAddr());
            $this->recorder->write('openApiUrl', self::$_CONFIG['open_api_url']);
            $this->recorder->write('initTime', time());
        } else {
            throw new \Exception(Util::jsonEncode($result));
        }
        return $result;
    }

    /*
     * 是否需要初始化
     * @return bool   true 需要重新初始化， false 不用初始化
     * */
    private function needInit()
    {
        //项目Id是否变更
        static $project_id;
        if (empty($project_id)) {
            $project_id = $this->recorder->read('pid');
        }

        if (empty($project_id) ||
            0 !== strcmp(self::$_CONFIG['project_id'], $project_id)
        ) {
            return true;
        }

        //是否24小时内
        $initTime = $this->recorder->read('initTime');
        $timeOut = time() - $initTime > 86000;
        if ($timeOut) {
            return true;
        }

        //初始化环境是否一致
        $sameOpenApi = $this->recorder->read('openApiUrl') === self::$_CONFIG['open_api_url'];
        if (!$sameOpenApi) {
            return true;
        }

        //设备是否相同
        /*$sameEquip = substr($this->recorder->read('equipId'), 0, -7) == substr(Util::getMacAddr(), 0, -7);
        if (!$sameEquip) {
            return true;
        }*/
        return false;
    }

    /*
     * 获取授权地址
     * */
    private function getAuthUrlList()
    {
        //请求参数列表
        $keysArr = array(
            'project_id' => self::$_CONFIG['project_id'],
            'project_secret' => self::$_CONFIG['project_secret'],
            'channel' => self::CHANNEL,
            'version' => self::VERSION,
            'http_type' => empty(self::$_CONFIG['http_type']) ? 'HTTPS' : self::$_CONFIG['http_type']
        );

        //初始化请求
        $res = HttpUtils::request()->noSignHttpPost(
            self::$_CONFIG['open_api_url'],
            http_build_query($keysArr),
            $postJson = false,
            $proxy = true
        );

        $ret = new Result($res);
        $res = $ret->getData();
        $errCode = !isset($res['errCode']) ? 101 : $res['errCode'];
        if ($errCode != 0) {
            return $res;
        }
        if (strtolower(self::$_CONFIG['http_type']) == 'http') {
            $this->saveUrlInfo($res['urls']);
        } else {
            $this->saveUrlInfo($res['https_urls']);
        }
        return 0;
    }

    /**
     * 将初始化授权链接缓存到本地
     * @param array $urlAry 从服务器上获取的授权链接
     */
    private function saveUrlInfo(array $urlAry)
    {
        foreach ($urlAry as $i => $url) {
            if (in_array($url['urlKey'], self::$techUrlKey)) {
                $this->recorder->write($url['urlKey'], $url['urlValue']);
            }
        }
    }

    /**
     * 添加个人账户
     * @param $mobile 手机
     * @param $name 姓名
     * @param $idNo 证件号
     * @param int $personarea 地区
     * @param string $email 邮箱
     * @param string $organ
     * @param string $title
     * @param string $address 地址
     * @return array|mixed|MyErrorException
     */
    public function addPersonAccount($mobile,
                                     $name,
                                     $idNo,
                                     $personarea = PersonArea::MAINLAND,
                                     $email = '',
                                     $organ = '',
                                     $title = '',
                                     $address = '')
    {
        return $this->_addPersonAccount($mobile, $name, $idNo, $personarea, $email, $organ, $title, $address, false);
    }

    /**
     * 简约签,添加账号不生成证书
     * @param $mobile
     * @param $name
     * @param $idNo
     * @param string $personarea
     * @param string $email
     * @param string $organ
     * @param string $title
     * @param string $address
     * @return array|null
     */
    public function addPersonAccountSimple($mobile,
                                           $name,
                                           $idNo,
                                           $personarea = PersonArea::MAINLAND,
                                           $email = '',
                                           $organ = '',
                                           $title = '',
                                           $address = '')
    {
        return $this->_addPersonAccount($mobile, $name, $idNo, $personarea, $email, $organ, $title, $address, true);
    }

    private function _addPersonAccount($mobile,
                                       $name,
                                       $idNo,
                                       $personarea = PersonArea::MAINLAND,
                                       $email = '',
                                       $organ = '',
                                       $title = '',
                                       $address = '',
                                       $simple = false)
    {
        /*if (empty($mobile)) {
            return ErrorConstant::$MOBILE_NULLPOINTER;
        }*/
        if (empty($name)) {
            return ErrorConstant::$PERSON_NAME_NULLPOINTER;
        }
        if (empty($idNo)) {
            return ErrorConstant::$PERSON_IDNO_NULLPOINTER;
        }
        if ($personarea === '' || is_null($personarea) ) {
            return ErrorConstant::$LEGAL_AREA_INVALIDATE;
        }

        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'account' => array(
                'email' => $email,    //邮箱地址
                'mobile' => $mobile,    //手机号码
                'person' => array(
                    'name' => $name,        //真实姓名
                    'idNo' => $idNo,        //身份证号码
                    'organ' => $organ,        //公司
                    'title' => $title,        //职务
                    'address' => $address,    //邮寄地址
                    'personArea' => (int)$personarea //用户归属地
                )
            )
        );

        if ($simple === true) {
            $res = $this->withSignHttpPost(self::TECH_ADD_SIMPLE_ACCOUNT_URL, $keysArr);
        } else {
            $res = $this->withSignHttpPost(self::TECH_ADD_ACCOUNT_URL, $keysArr);
        }

        $result = new AddAccountResult($res);
        return $result->getData();
    }

    /**
     * *
     * 更新个人账户
     * @param $accountId
     * @param array $modifyArray = array(
     *                       'mobile' => '13111111111',
     *                       'email' => '',
     *                       'title' => '222',
     *                       'address' => '2222',
     *                       'organ' =>  NULL,
     *                       'name' => $name,
     *                       'personArea' => PersonArea::MAINLAND
     *                       );
     * @return array|mixed
     */
    public function updatePersonAccount($accountId, $modifyArray = array())
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }
        $account['accountUid'] = $accountId;
        $person = array();
        $clearList = array();

        //可修改的person字段
        $personFields = array(
            'name',        //姓名
            'organ',        //公司
            'title',        //职务
            'address',    //邮寄地址
            'personArea' //用户归属地
        );
        //可清空字段
        $clearFields = array(
            'email' => '0',
            'organ' => '1',
            'title' => '2',
            'address' => '3'
        );
        foreach ($modifyArray as $key => $val) {
            /*if ($key == 'name' ) {
                return array('errCode' => 1000012, 'msg' => '姓名name不能修改', 'errShow' => true);
            }*/
            if ($key == 'personArea' || $key == 'idNo') {
                return array('errCode' => 1000012, 'msg' => '个人归属地personArea或证件号idNo不能修改', 'errShow' => true);
            }
            //值为空" "或 NULL 清空字段
            if (is_null($val) || $val === '') {
                if (isset($clearFields[$key])) {
                    $clearList[] = $clearFields[$key];
                    continue;
                }
            }
            //mobile 或 email 字段
            if ($key == 'mobile' || $key == 'email') {
                $account[$key] = $val;
            }
            //$psesonArea
            if ($key == 'personArea') {
                $val = (int)$val;
                /*if (!in_array($val, PersonArea::getArray())) {
                    return ErrorConstant::$PERSON_AREA_ILLEGAL;
                }*/
            }
            if (in_array($key, $personFields)) {
                $person[$key] = $val;
            }
        }
        $account['person'] = empty($person) ? null : $person;
        /*if (isset($account['mobile']) && isset($account['email']) && empty($person) && empty($clearList)) {
            //没有需要修改的项
            return;
        }*/
        //参数
        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'account' => $account,
            'accountContentList' => $clearList
        );
        $res = $this->withSignHttpPost(self::TECH_UPDATE_ACCOUNT_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 添加企业账户
     * @param $mobile 手机，必填
     * @param $name 企业名称 必填
     * @param $organCode 组织机构代码号或社会信用代码号 或 工商注册号
     * @param string $email 邮箱
     * @param int $organType 单位类型 0 普通企业
     * @param string $legalName 法人姓名
     * @param int $legalArea 地区
     * @param string $userType 注册类型 1、代理人 2、法人
     * @param string $agentName 代理人姓名
     * @param string $agentIdNo 代理人证件号
     * @param string $legalIdNo 法人证件号
     * @param string $regType 证件类型
     * @param string $address //地址
     * @param string $scop //经营范围
     * @return array|mixed
     */
    public function addOrganizeAccount($mobile,
                                       $name,
                                       $organCode,
                                       $regType = OrganRegType::NORMAL,
                                       $email = '',
                                       $organType = 0,
                                       $legalArea = PersonArea::MAINLAND,
                                       $userType = UserType::USER_DEFAULT,
                                       $agentName = '',
                                       $agentIdNo = '',
                                       $legalName = '',
                                       $legalIdNo = '',
                                       $address = '',
                                       $scope = '')
    {
        return $this->_addOrganizeAccount($mobile, $name, $organCode, $regType, $email, $organType, $legalArea,
            $userType, $agentName, $agentIdNo, $legalName, $legalIdNo, $address, $scope, false);
    }

    /**
     * 简约签署添加账号
     */
    public function addOrganizeAccountSimple($mobile,
                                             $name,
                                             $organCode,
                                             $regType = OrganRegType::NORMAL,
                                             $email = '',
                                             $organType = 0,
                                             $legalArea = PersonArea::MAINLAND,
                                             $userType = UserType::USER_DEFAULT,
                                             $agentName = '',
                                             $agentIdNo = '',
                                             $legalName = '',
                                             $legalIdNo = '',
                                             $address = '',
                                             $scope = '')
    {
        return $this->_addOrganizeAccount($mobile, $name, $organCode, $regType, $email, $organType, $legalArea,
            $userType, $agentName, $agentIdNo, $legalName, $legalIdNo, $address, $scope, true);
    }

    private function _addOrganizeAccount($mobile,
                                         $name,
                                         $organCode,
                                         $regType = OrganRegType::NORMAL,
                                         $email = '',
                                         $organType = 0,
                                         $legalArea = PersonArea::MAINLAND,
                                         $userType = UserType::USER_DEFAULT,
                                         $agentName = '',
                                         $agentIdNo = '',
                                         $legalName = '',
                                         $legalIdNo = '',
                                         $address = '',
                                         $scope = '', $simple = false)
    {
        /*if (empty($mobile)) {
            return ErrorConstant::$MOBILE_NULLPOINTER;
        }*/
        if (empty($name)) {
            return ErrorConstant::$ORGANIZE_NAME_NULLPOINTER;
        }
        //单位类型
        if (!in_array($organType, OrganType::OrganTypeArray())) {
            return ErrorConstant::$ORGAN_TYPE_INVALIDATE;
        }
        //地区
        if ($legalArea === '' ||  is_null($legalArea) ) {
            return ErrorConstant::$LEGAL_AREA_INVALIDATE;
        }
        //证件类型判断
        /*if (!in_array($regType, OrganRegType::getArray())) {
            $regType = OrganRegType::NORMAL;
        }*/
        if (!in_array($userType, UserType::getArray())) {
            $userType = UserType::USER_DEFAULT;
        }
        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'account' => array(
                'email' => $email,
                'mobile' => $mobile,
                'organize' => array(
                    'name' => $name,
                    'organCode' => $organCode,
                    'organType' => $organType,
                    'legalName' => $legalName,
                    'userType' => $userType,
                    'legalArea' => $legalArea, //用户归属地
                    'agentName' => $agentName, //代理人姓名
                    'agentIdNo' => $agentIdNo, //代理人身份证号
                    'legalIdNo' => $legalIdNo, //法人身份证号
                    'licenseType' => $regType,//营业执照类型
                    'address' => $address,
                    'scope' => $scope
                )
            )
        );
        if ($simple === true) {
            $res = $this->withSignHttpPost(self::TECH_ADD_SIMPLE_ACCOUNT_URL, $keysArr);
        } else {
            $res = $this->withSignHttpPost(self::TECH_ADD_ACCOUNT_URL, $keysArr);
        }
        $result = new AddAccountResult($res);
        return $result->getData();
    }


    /**
     * 更新企业账号
     * @param $accountId
     * @param array $modifyArray
     * @return array|mixed
     */
    public function updateOrganizeAccount($accountId, array $modifyArray)
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }
        $account['accountUid'] = $accountId;
        $clearList = array();
        $organize = array();

        //可修改字段
        $organizeFields = array(
            'name',
            'organType',//单位类型
            'userType',  //注册类型，1-代理人注册，2-法人注册
            'legalArea', //用户归属地
            'agentName', //代理人姓名
            'agentIdNo', //代理人身份证号
            'legalName', //法人姓名
            'legalIdNo', //法人身份证号
            'address', //公司地址
            'scope' //经营范围
        );
        //可清空字段
        $clearFields = array(
            'email' => '0',
            'legalIdNo' => '4',
            'legalName' => '5',
            'agentIdNo' => '6',
            'agentName' => '7',
            'address' => '8',
            'scope' => '9'
        );
        foreach ($modifyArray as $key => $val) {
            /*if ($key == 'name') {
                return array('errCode' => 1000012, 'msg' => '企业name不能修改', 'errShow' => true);
            }*/

            if ($key == 'regType' || $key == 'organCode') {
                return array('errCode' => 1000012, 'msg' => '企业注册类型regType或证件号organCode不能修改', 'errShow' => true);
            }
            //值为空" "或 NULL 清空字段
            if (is_null($val) || $val === '') {
                if (isset($clearFields[$key])) {
                    $clearList[] = $clearFields[$key];
                    continue;
                }
            }
            //mobile 或 email 字段
            if ($key == 'mobile' || $key == 'email') {
                $account[$key] = $val;
            }
            //$legalArea
            if ($key == 'legalArea') {
                $val = (int)$val;
                if (!in_array($val, PersonArea::getArray())) {
                    return ErrorConstant::$PERSON_AREA_ILLEGAL;
                }
            }
            if ($key == 'userType') {
                $val = (int)$val;
            }
            if (in_array($key, $organizeFields)) {
                $organize[$key] = $val;
            }
        }
        $account['organize'] = $organize;
        //参数
        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'account' => $account,
            'accountContentList' => $clearList
        );
        $res = $this->withSignHttpPost(self::TECH_UPDATE_ACCOUNT_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 注销账号
     * @param $accountId
     * @return array|mixed
     */
    public function delUserAccount($accountId)
    {
        $keysArr = array(
            'account' => array(
                'accountUid' => $accountId
            )
        );
        $res = $this->withSignHttpPost(self::TECH_DELETE_ACCOUNT_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 创建模板印章,返回印章图片base64字符串
     * @param $accountId 用户ID
     * @param string $templateType 模板类型
     * @param string $color 印章颜色 red blue black
     * @param string $hText 生成印章中的横向文内容，允许空，只有企业账户创建模板的时候有效不能超过8个字
     * @param string $qText 生成印章中的下弦文内容，允许空，只有企业账户创建模板的时候有效,不能超过15个字
     * @return array|mixed|MyErrorException  返回电子印章图片base64字符串
     */
    public function addTemplateSeal($accountId,
                                    $templateType = PersonTemplateType::SQUARE,
                                    $color = SealColor::RED,
                                    $hText = '',
                                    $qText = '')
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }
        $isPersonTemp = in_array($templateType, PersonTemplateType::getArray());
        $isOrganizeTemp = in_array($templateType, OrganizeTemplateType::getArray());
        if (empty($templateType) || (!$isPersonTemp && !$isOrganizeTemp)) {
            return ErrorConstant::$TEMPLATE_NOT_EXIST;
        }

        if (!in_array($color, SealColor::getArray())) {
            return ErrorConstant::$SEALCOLOR_NULLPOINTER;
        }

        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'accountId' => $accountId,
            'templateType' => $templateType,
            'color' => $color,
            'hText' => $hText,
            'qText' => $qText
        );
        $res = $this->withSignHttpPost(self::TECH_ADD_TEMP_SEAL_URL, $keysArr);
        $result = new AddTemplateResult($res);
        return $result->getData();
    }

    /**
     * 创建 个人本地印章模板
     * @param $text
     * @param $templateType
     * @param string $color
     * @return null
     */
    public function addPersonalSealLocal($text, $templateType, $color = SealColor::RED)
    {
        if (empty($text) || empty($templateType)) {
            return array('errCode' => 1016, 'msg' => '参数不能为空：text、templateType', 'errShow' => true);
        }
        $res = $this->javaComm->addPersonalTemplateSeal($text, $templateType, $color);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 创建 企业本地印章模板
     * @param $roundText
     * @param $templateType
     * @param string $color
     * @param $hText
     * @param $qText
     * @return null
     */
    public function addOrganizeSealLocal($roundText, $templateType, $color = SealColor::RED, $hText, $qText)
    {
        if (empty($roundText) || empty($templateType)) {
            return array('errCode' => 1016, 'msg' => '参数不能为空：roundText、templateType', 'errShow' => true);
        }
        $res = $this->javaComm->addOrganizeTemplateSeal($roundText, $templateType, $color, $hText, $qText);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 添加平台事件证书
     *
     * @param $content 事件内容
     * @param array $objects 事件对象
     *              [[‘name’=>‘参与者名称’,‘licenseType’ => 0, license’=> ‘11111111111’ ],[name,licenseType,license]]
     * @param  $eventType
     * @return array
     */
    public function addEventCert($content, $objects, $eventType = EventType::EVENT_TYPE_TEXT)
    {
        if (empty($content)) {
            return array('errCode' => 1016, 'msg' => 'content不能为空', 'errShow' => true);
        }

        if ($eventType === EventType::EVENT_TYPE_FILE) {
            $filePath = Util::encodePath($content);
            if (is_file($filePath)) {
                $content = file_get_contents($filePath);
            } else {
                return ErrorConstant::$FILE_NOT_EXIST;
            }
        }

        //是否数组，数组：计算数组长度；非数组：size为0
        $objSize = is_array($objects) ? count($objects) : 0;
        if ($objSize > 2000) {
            return array('errCode' => 1016, 'msg' => 'objects大小不能超过2000个', 'errShow' => true);
        }
        $obj = array();
        //objects Size 不为0，name、lisenceType、lisence非空校验；
        if ($objSize) {
            foreach ($objects as $key => $item) {
                if (!isset($item['licenseType']) || !in_array($item['licenseType'], LicenseType::getArray())) {
                    return array('errCode' => 1016, 'msg' => 'licenseType未定义或无效值', 'errShow' => true);
                }
                if (empty($item['name']) || empty($item['license'])) {
                    return array('errCode' => 1016, 'msg' => 'license或name未定义或为空值', 'errShow' => true);
                }
                $obj[$key]['name'] = $item['name'];
                $obj[$key]['license'] = $item['license'];
                $obj[$key]['licenseType'] = (int)$item['licenseType'];
            }
        }
        $eventStr = Util::jsonEncode(array('content' => $content, 'objects' => $obj));
        $eventDigest = md5($eventStr);
        $filename = 'EventObj_' . $eventDigest;
        //文件直传
        $res = $this->uploadFile($eventStr, $filename);
        if (empty($res['fileKey'])) {
            return $res;
        }

        $keysArr = array(
            'event' => array(
                'digest' => $eventDigest,
                'ossKey' => $res['fileKey'],
                'content' => $content,
            )
        );
        $res = $this->withSignHttpPost(self::TECH_ADD_DIGEST_EVENT_CERT_URL, $keysArr);
        $result = new AddEventCertResult($res);
        return $result->getData();
    }


    /**
     * 事件证书摘要签署
     *
     * @param array $signFile 待签署PDF文档
     * @param array $signPos 签署位置
     * @param $signType 签章类型 1-单页签章，2-多页，3-骑缝，4-关键字
     * @param $certId 事件证书ID
     * @param string $sealData 印章图片base64字符串
     * @param bool|false $stream
     * @return array|mixed
     */
    public function eventSignPDF(array $signFile, array $signPos, $signType, $certId, $sealData = '', $stream = false)
    {
        $srcPdfFile = Util::encodePath($signFile['srcPdfFile']);
        if (!is_file($srcPdfFile)) {
            return ErrorConstant::$SING_FILE_NOT_EXISTS;
        }
        if (empty($signFile['dstPdfFile'])) {
            return ErrorConstant::$SIGNED_FILE_NOT_EXISTS;
        }
        if (empty($certId)) {
            return ErrorConstant::$CERT_ID_NULLPOINTER;
        }
        if (!in_array($signType, SignType::getArray())) {
            return ErrorConstant::$SIGNTYPE_NULLPOINTER;
        }
        if ($stream === true) {
            $res = $this->javaComm->eventSignPDFSteam($signFile, $signPos, $signType, $certId, $sealData);
        } else {
            $res = $this->javaComm->eventSignPDF($signFile, $signPos, $signType, $certId, $sealData);
        }
        $result = new FileSignResult($res);
        return $result->getData();
    }

    /**
     * 平台用户摘要签署 文件或 文件流方式
     *
     * @param array $signFile
     * @param array $signPos
     * @param $sealId
     * @param $signType
     * @param bool|false $stream
     * @return array|mixed
     */
    public function selfSignPDF(array $signFile, array $signPos, $sealId, $signType, $stream = false)
    {
        $srcPdfFile = Util::encodePath($signFile['srcPdfFile']);
        if (!is_file($srcPdfFile)) {
            return ErrorConstant::$SING_FILE_NOT_EXISTS;
        }

        if (empty($signFile['dstPdfFile'])) {
            return ErrorConstant::$SIGNED_FILE_NOT_EXISTS;
        }
        if (!in_array($signType, SignType::getArray())) {
            return ErrorConstant::$SIGNTYPE_NULLPOINTER;
        }
        if ($stream === true) {
            $res = $this->javaComm->selfSignPDFStream($signFile, $signPos, $sealId, $signType);
        } else {
            $res = $this->javaComm->selfSignPDF($signFile, $signPos, $sealId, $signType);
        }
        $result = new FileSignResult($res);
        return $result->getData();
    }

    /**
     * 平台用户PDF摘要签署
     *
     * @param $accountId
     * @param array $signFile
     * @param $signType
     * @param array $signPos
     * @param $sealData
     * @param $mobile
     * @param $code
     * @param bool|false $stream 是否文件流
     * @return array|mixed
     */
    private function _userSignPDF($accountId,
                                  array $signFile,
                                  array $signPos,
                                  $signType,
                                  $sealData,
                                  $mobile,
                                  $code,
                                  $stream = false,
                                  $smiple = false)
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }
        $srcPdfFile = Util::encodePath($signFile['srcPdfFile']);
        if (!is_file($srcPdfFile)) {
            return ErrorConstant::$SING_FILE_NOT_EXISTS;
        }
        if (empty($signFile['dstPdfFile'])) {
            return ErrorConstant::$Doc_SVAEPATH_NULLPOINTER;
        }
        if (!in_array($signType, SignType::getArray())) {
            return ErrorConstant::$SIGNTYPE_NULLPOINTER;
        }
        if ($stream === true) {
            $res = $this->javaComm->userSignPDFStream($accountId, $signFile, $signPos, $signType, $sealData, $mobile, $code, $smiple);
        } else {
            $res = $this->javaComm->userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $mobile, $code, $smiple);
        }
        $result = new FileSignResult($res);
        return $result->getData();
    }

    /**
     * 平台用户PDF摘要签署,不需要验证短信
     */
    public function userSignPDF($accountId, array $signFile, array $signPos, $signType, $sealData, $stream = false)
    {
        return $this->_userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, '', '', $stream);
    }

    /**
     * 简约签，平台用户PDF摘要签署,不需要验证短信
     */
    public function userSignPDFSimple($accountId, array $signFile, array $signPos, $signType, $sealData, $stream = false)
    {
        return $this->_userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, '', '', $stream, true);
    }

    /**
     * 用户pdf摘要签署，短信验证码
     */
    public function userSafeSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $code, $stream = false)
    {
        if (empty($code)) {
            return ErrorConstant::$CODE_NULLPOINTER;
        }
        return $this->_userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, '', $code, $stream);
    }

    /**
     * 用户pdf摘要签署 , 指定手机短信验证
     */
    public function userSafeMobileSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $mobile, $code, $stream = false)
    {
        if (empty($mobile)) {
            return ErrorConstant::$MOBILE_NULLPOINTER;
        }
        if (empty($code)) {
            return ErrorConstant::$CODE_NULLPOINTER;
        }
        return $this->_userSignPDF($accountId, $signFile, $signPos, $signType, $sealData, $mobile, $code, $stream);
    }

    /**
     * 短信批量签署
     * @param $accountId
     * @param $signParams
     * @param string $sealData
     * @param string $mobile
     * @param $code
     * @return array|mixed
     */
    public function userMutilSignPDF($accountId, $signParams, $sealData, $mobile = '', $code)
    {
        $count = is_array($signParams) ? count($signParams) : 0;
        if ($count <= 0) {
            return array('errCode' => 1016, 'msg' => '待签署文档不能为空', 'errShow' => true);
        }
        if ($count > 10) {
            return array('errCode' => 1016, 'msg' => '待签署文档超过文件数上限10份', 'errShow' => true);
        }
        $res = $this->javaComm->userMutilSignPDF($accountId, $signParams, $sealData, $mobile, $code);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 天谷证明章签署
     * @param $signFile
     * @param $signPos
     * @param $signType
     * @param bool|false $stream
     * @return array|null
     */
    public function tgSignPDF($signFile, $signPos, $signType, $stream = false)
    {
        $srcPdfFile = Util::encodePath($signFile['srcPdfFile']);
        if (!is_file($srcPdfFile)) {
            return ErrorConstant::$SING_FILE_NOT_EXISTS;
        }
        if (empty($signFile['dstPdfFile'])) {
            return ErrorConstant::$Doc_SVAEPATH_NULLPOINTER;
        }
        if (!in_array($signType, SignType::getArray())) {
            return ErrorConstant::$SIGNTYPE_NULLPOINTER;
        }
        if ($stream === true) {
            $res = $this->javaComm->tgStreamSign($signFile, $signPos, $signType);
        } else {
            $res = $this->javaComm->tgFileSign($signFile, $signPos, $signType);
        }
        $result = new FileSignResult($res);
        return $result->getData();
    }

    /**
     * 验证PDF文档签名的有效性
     *
     * @param $filepath 已签的pdf文件完整路径 包含文件名
     * @param bool $stream 是否文件流
     * @return array|mixed|MyErrorException
     */
    public function fileVerify($filepath, $stream = false)
    {
        if (!is_file(Util::encodePath($filepath))) {
            return ErrorConstant::$FILE_NOT_EXIST;
        }
        if ($stream === true) {
            $res = $this->javaComm->streamVerify($filepath);
        } else {
            $res = $this->javaComm->filePathVerify($filepath);
        }
        $result = new VerifyPdfResult($res);
        return $result->getData();
    }

    /**
     * 文本验签
     * @param $srcData 待验证的文本数据原文
     * @param $signResult 签署结果
     * @return array|mixed|MyErrorException
     */
    public function localVerifyText($srcData, $signResult)
    {
        if (empty($srcData)) {
            return ErrorConstant::$PDF_HASH_NULLPOINTER;
        }

        if (empty($signResult)) {
            return ErrorConstant::$SIGNRESULT_NULLPOINTER;
        }
        $res = $this->javaComm->localVerifyText($srcData, $signResult);
        $result = new Result($res);
        return $result->getData();
    }


    /**
     * 文件直传
     * @param $file
     * @param $filename
     * @return array|mixed
     */
    private function uploadFile($file, $filename)
    {
        //是否使用代理
        $host = isset(self::$_CONFIG['proxy_ip']) ? self::$_CONFIG['proxy_ip'] : '';
        $port = isset(self::$_CONFIG['proxy_port']) ? self::$_CONFIG['proxy_port'] : '';
        $upload = new upload($host, $port);
        if (is_file($file)) {
            $upload->setUploadFile($file);
        } else {
            $upload->setFileContent($file);
        }
        $size = $upload->getFileSize();
        $fileMd5 = $upload->getFileMd5();
        //获取文件上传授权地址 //上传文件
        $res = $this->getUploadSignUrl($fileMd5, $filename, $size);

        if (!empty($res['url'])) {
            $ret = $upload->saveFile($res['url']);
            if ($ret['errCode'] !== 0) {
                return $ret;
            }
        }
        return $res;
    }

    /**
     * 获取文件直传授权 Url
     * @param $fileMd5
     * @param $filename
     * @param $contentLength
     * @return array|mixed
     */
    private function getUploadSignUrl($fileMd5, $filename, $contentLength = '')
    {
        $keysArr = array(
            'fileName' => $filename,
            'md5' => $fileMd5,
            'contentType' => HttpUtils::CONTENT_TYPE_STREAM
        );
        if (!empty($contentLength)) {
            $keysArr['contentLength'] = $contentLength;
        }
        $res = $this->withSignHttpPost(self::TECH_GET_FILE_SYSTEM_URL_URL, $keysArr);
        return $res;
    }


    /**
     * 查询签署记录详情
     * @param $signServiceId
     * @return array
     */
    public function getSignDetail($signServiceId)
    {
        $keysArr = array(
            'signServiceId' => $signServiceId
        );
        $res = $this->withSignHttpPost(self::TECH_GET_SIGN_DETAIL_URL, $keysArr);
        $result = new GetSignDetailResult($res);
        return $result->getData();
    }

    /**
     * 平台用户或平台自身文本签署 不需要短信验证
     *
     * @param $data 待签署文本内容
     * @param string $accountId 签署账号，如果为平台自身签署此项空
     * @return array|bool|mixed|MyErrorException
     */
    public function signDataHash($data, $accountId = '')
    {
        return $this->_signDataHash($data, $accountId);
    }

    /**
     * 平台用户或平台自身文本签署,需要短信验证码
     *
     * @param $data
     * @param string $accountId
     * @param $code
     * @return array|bool|mixed|MyErrorException
     */
    public function safeSignDataHash($data, $accountId = '', $code)
    {
        if (empty($code)) {
            return ErrorConstant::$CODE_NULLPOINTER;
        }
        return $this->_signDataHash($data, $accountId, $code);
    }

    /**
     * 平台用户或平台自身文本签署
     *
     * @param $data 待签署文本内容
     * @param string $accountId 签署账号，如果为平台自身签署此项空
     * @param string $code 短信验证码
     * @return array|bool|mixed|MyErrorException
     */
    private function _signDataHash($data, $accountId = '', $code = '')
    {
        if (empty($data)) {
            return ErrorConstant::$PDF_HASH_NULLPOINTER;
        }

        $hash = base64_encode(hash('sha256', $data, true));
        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'accountId' => $accountId,
            'hash' => $hash,
            'code' => $code
        );

        $response = $this->withSignHttpPost(self::TECH_ADD_SIGN_HASH_URL, $keysArr);
        $errCode = $response['errCode'];

        //签署成功，保存签署结果
        if ($errCode == 0) {
            $signInfo = $response['signResult'];
            $saveRet = $this->saveSignLog($hash, $signInfo, $accountId);

            //签署结果保存成功，返回签署信息
            if ($saveRet['errCode'] === 0) {
                $response['signId'] = $saveRet['signId'];
            } else {
                $saveRet['msg'] .= ' - 保存签署记录失败';
                $saveRet['signResult'] = $signInfo;
                return $saveRet;
            }
        }
        $response = new TextSignResult($response);
        $response = $response->getData();
        return $response;
    }

    /**
     * 发送签署认证短信接口
     *
     * @param $accountId 发送短信的账号
     * @return array|mixed|MyErrorException
     */
    public function sendSignCode($accountId)
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }

        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'type' => 4,
            'accountUid' => $accountId
        );

        $res = $this->withSignHttpPost(self::TECH_SEND_MOBILE_CODE_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 发送签署认证短信到指定的手机号
     *
     * @param $accountId 发送短信的账号
     * @param $mobile 指定接收短信的手机号
     * @return array|mixed|MyErrorException
     */
    public function sendSignCodeToMobile($accountId, $mobile)
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }

        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'type' => 4,
            'accountUid' => $accountId,
            'mobile' => $mobile
        );

        $res = $this->withSignHttpPost(self::TECH_SEND_MOBILE_3RD_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 发送签署语音验证，语音会发送给指定用户Id的手机上
     *
     * @param $accountId 用户ID
     * @return array|mixed
     */
    public function sendMobileVoice($accountId)
    {
        if (empty($accountId)) {
            return ErrorConstant::$ACCOUNT_NULLPOINTER;
        }

        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'type' => 4,
            'accountUid' => $accountId,
        );
        $res = $this->withSignHttpPost(self::TECH_SEND_VOICE_CODE_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }


    /**
     * 合并模版生成文档
     * @param $templateId
     * @param array $keyValuePair
     * @return array|mixed
     */
    public function generatePdfByTemplate($templateId, array $keyValuePair)
    {
        if (empty($templateId) || empty($keyValuePair)) {
            return ErrorConstant::$PARAM_INVALIDATE;
        }
        $keysArr = array(
            'templateId' => $templateId,
            'userFormkeyvaluepair' => $keyValuePair
        );
        $res = $this->withSignHttpPost(self::PDF_TEMPLATE_URL, $keysArr);
        return $res;
    }

    /**
     * 存证指引
     * @param $signServiceId
     * @param array $witnessArray
     * @return array|mixed
     */
    public function saveWitnessGuide($signServiceId, array $witnessArray)
    {
        if (empty($signServiceId)) {
            return ErrorConstant::$SIGNDATA_NULLPOINTER;
        }
        $certificateImg = $witnessArray['certImgBase64']; //企业证件照base64

        $fileKey = '';
        if (!empty($certificateImg)) {
            $fileName = 'save_witness_guide_' . md5($certificateImg . time());
            $res = $this->uploadFile($certificateImg, $fileName);
            if (empty($res['fileKey'])) {
                return $res;
            }
            $fileKey = $res['fileKey'];
        }
        $witness = array(
            'cbm' => $fileKey,
            'autonymDate' => isset($witnessArray['autonymDate']) ? $witnessArray['autonymDate'] : '',
            'loginDate' => isset($witnessArray['loginDate']) ? $witnessArray['loginDate'] : '',
            'loginIP' => isset($witnessArray['loginIP']) ? $witnessArray['loginIP'] : '',
            'signIPList' => isset($witnessArray['signIPList']) ? $witnessArray['signIPList'] : ''
        );
        $keysArr = array(
            'signServiceId' => $signServiceId,
            'dataType' => 0,
            'fileKey' => $fileKey,
            'witnessGuide' => $witness
        );
        $res = $this->withSignHttpPost(self::SAVE_WITNESS_GUIDE_URL, $keysArr);
        return $res;
    }

    /**
     * 根据证件号获取账号详细信息
     * @param $idNo
     * @param $idNoType
     * @return array
     */
    public function getAccountInfoByIdNo($idNo, $idNoType)
    {
        if (empty($idNo) || empty($idNoType)) {
            return ErrorConstant::$PARAM_INVALIDATE;
        }

        $keysArr = array(
            'idNo' => $idNo,
            'idNoType' => $idNoType
        );

        $res = $this->withSignHttpPost(self::GET_ACCOUNT_INFO_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }

    /**
     * 根据本地模板生成PDF
     * @param array $tmpFile
     * @param $isFlat
     * @param array $txtFields
     * @param $isStream
     * @return array|mixed
     */
    public function createFromTemplate(array $tmpFile, $isFlat, array $txtFields, $isStream) {
        if (!is_array($tmpFile) or !is_array($txtFields)) {
            return ErrorConstant::$PARAM_NULLPOINTER;
        }
        if (empty($tmpFile['srcFileUrl'])) {
            return array('errCode' => 10003, 'msg' => '文档不存在', 'errShow' => true);
        }
        return $this->javaComm->createFromTemplate($tmpFile, $isFlat, $txtFields, $isStream);
    }

	/**
     * 预先验证短信验证码
     * @param array $accountId
     * @param $code
     */
	public function preverifyCode($accountId, $code) {
		return $this->javaComm->preverifyCode($accountId, $code);		
	}	
	
	/**
     * 预先验证指定手机号的短信验证码
     * @param array $accountId
     * @param $code
     * @param $code
     */
	
	public function preverify3rdCode($accountId, $mobile, $code) {		
		return $this->javaComm->preverify3rdCode($accountId, $mobile, $code);		
	}
	
	
    /**
     * 保存文本签署结果
     * @param $hash  未签署的原文本hash摘要
     * @param $signInfo 文本签署结果
     * @param string $accountId 关联账户，如果为平台签署，为空
     * @return array|bool|mixed 返回true签署结果保存成功，其他签署失败
     */
    private function saveSignLog($hash, $signInfo, $accountId = '')
    {
        $keysArr = array(
            'equipId' => $this->recorder->read('equipId'),
            'accountId' => $accountId,
            'docName' => '',
            'docHash' => $hash,
            'signInfo' => $signInfo,
            'timestamp' => '',
        );
        $res = $this->withSignHttpPost(self::TECH_SAVE_SIGN_LOG_URL, $keysArr);
        $result = new Result($res);
        return $result->getData();
    }


    /**
     * 发送网络请求
     * @param $urlKey
     * @param $keysArr
     * @param bool|true $postJson //以json方式发送post参数
     * @return array|mixed
     * @throws Exception
     */
    private function withSignHttpPost($urlKey, $keysArr, $postJson = true)
    {
        $authUrl = $this->recorder->read($urlKey);
        return HttpUtils::request()->buildSignHttpRequest($authUrl, $keysArr, $postJson);
    }

    const TECH_ADD_ACCOUNT_URL = 'techAddAccountUrlNew'; //1.添加账号
    const TECH_ADD_SIMPLE_ACCOUNT_URL = 'techAddSimpleSignAccount'; //1.1.添加账号
    const TECH_UPDATE_ACCOUNT_URL = 'techUpdateAccountUrlNew'; //2.更新账号
    const TECH_DELETE_ACCOUNT_URL = 'techDeleteAccountUrlNew'; //3.注销账号
    const TECH_ADD_TEMP_SEAL_URL = 'techAddTempSealUrlNew'; //4.创建模板印章
    const TECH_ADD_FILE_SEAL_URL = 'techAddFileSealUrlNew'; //5.创建手绘印章
    const TECH_ADD_SIGN_HASH_URL = 'techSignHashUrlNew'; //6.文本签署
    const TECH_SAVE_SIGN_LOG_URL = 'techSaveSignlogUrlNew'; //7.保存 文本摘要签署结果
    const TECH_CONVERT_DOC_URL = 'ConvertDocUrl'; //8.文档转换
    const LOCAL_PDF_TO_IMAGE_URL = 'localPdfToImageUrl'; //9.pdf转图片
    const TECH_SEND_MOBILE_CODE_URL = 'techSendMobileCodeUrlNew'; //10.发送验证短信
    const TECH_SEND_MOBILE_3RD_URL = 'techSendMobile3rdNew'; //10.1.发送验证短信到指定手机
    const TECH_SEND_VOICE_CODE_URL = 'techSendCodeVoiceUrlNew'; //10.2.发送语音验证码
    const TECH_ADD_EVENT_CERT_URL = 'techAddEventCertUrlNew'; //11.添加事件证书
    const TECH_ADD_DIGEST_EVENT_CERT_URL = 'techAddDigestEventCert'; //12.添加摘要事件证书
    const TECH_GET_FILE_SYSTEM_URL_URL = 'techGetFileSystemUrl'; //13.获取文件直传上传地址
    const SDK_DOC_PRESERVATION = 'sdkDocPreservation'; //13.1.获取文档保全上传地址
    const TECH_SAVE_FILE_WITH_SINGID_URL = 'techSigneddocSaveUrl'; //14.文档保全 关联签署记录
    const TECH_GET_DOC_URL = 'techGetDocUrlUrlNew'; //15.获取文档下载链接地址
    const TECH_GET_SIGN_DETAIL_URL = 'techGetSignDetail'; //16.查询签署记录详情
    const SAVE_WITNESS_GUIDE_URL = 'saveWitnessGuideUrl'; //17.存证指引
    const PDF_TEMPLATE_URL = 'mergeParamterWithPdfTemplate'; //18.合并模版生成文档
    const GET_ACCOUNT_INFO_URL = 'getAccountInfoByIdNo'; //19.根据证件号获取账号详情

    static $techUrlKey = array(
        self::TECH_ADD_ACCOUNT_URL, //1.添加账号
        self::TECH_ADD_SIMPLE_ACCOUNT_URL, //1.1.简约签，添加账号
        self::TECH_UPDATE_ACCOUNT_URL, //2.更新账号
        self::TECH_DELETE_ACCOUNT_URL, //3.注销账号
        self::TECH_ADD_TEMP_SEAL_URL, //4.创建模板印章
        self::TECH_ADD_FILE_SEAL_URL, //5.创建手绘印章
        self::TECH_ADD_SIGN_HASH_URL, //6.文本再要签署
        self::TECH_SAVE_SIGN_LOG_URL, //7.保存 文本摘要签署结果
        self::TECH_CONVERT_DOC_URL, //8.文档转换
        self::LOCAL_PDF_TO_IMAGE_URL, //9.pdf转图片
        self::TECH_SEND_MOBILE_CODE_URL, //10.发送验证短信
        self::TECH_SEND_MOBILE_3RD_URL, //10.1.发送验证短信到指定手机
        self::TECH_SEND_VOICE_CODE_URL,//10.2.发送语音验证码
        self::TECH_ADD_EVENT_CERT_URL, //11.添加摘要事件证书
        self::TECH_ADD_DIGEST_EVENT_CERT_URL, //12.添加摘要事件证书
        self::TECH_GET_FILE_SYSTEM_URL_URL, //13.获取文件直传上传地址
        self::SDK_DOC_PRESERVATION, //13.1.获取文档保全上传地址
        self::TECH_SAVE_FILE_WITH_SINGID_URL, //14.文档保全 关联签署记录
        self::TECH_GET_DOC_URL, //15.获取文档下载链接地址
        self::TECH_GET_SIGN_DETAIL_URL, //16.查询签署记录详情
        self::SAVE_WITNESS_GUIDE_URL, //17.存证指引
        self::PDF_TEMPLATE_URL, //18
        self::GET_ACCOUNT_INFO_URL, //19.
    );
}