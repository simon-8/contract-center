<?php
/**
 * User: Administrator
 * Date: 2017/1/12
 */

namespace tech\result;


use tech\constants\LicenseType;

class GetSignDetailResult extends AbstractResult
{
    public function parseData()
    {
        $response = $this->rawResponse;
        $result = array();
        if (!isset($response['signDetail'])) {
            return array_merge($this->errInfo, array('signDetail' => $result));
        }

        $detail = $response['signDetail'];
        //签署人相关信息
        $signers = array();
        foreach ($detail['objects'] as $key => $val) {
            switch ($val['licenseType']) {
                case LicenseType::ORGCODE:
                    $val['licenseType'] = '组织机构代码号';
                    break;
                case LicenseType::CREDITCODE:
                    $val['licenseType'] = '企业统一信用代码';
                    break;
                case LicenseType::REGCODE:
                    $val['licenseType'] = '企业工商注册号';
                    break;
                case LicenseType::NORMALIDNO:
                    $val['licenseType'] = '个人身份证号';
                    break;
                default:
                    $val['licenseType'] = '自定义证件类型';
                    break;
            }
            $signers[$key] = $val;
        }
        $result['signers'] = $signers;

        //签署事件描述
        $result['comment'] = $detail['comment'];
        //签署中使用的证书详情
        $cert = isset($detail['signCert']) ? $detail['signCert'] : array();
        if (count($cert)) {
            $signCert['certName'] = isset($cert['certName']) ? $cert['certName'] : '';
            $signCert['sn'] = isset($cert['sn']) ? $cert['sn'] : '';
            $signCert['issuser'] = isset($cert['issuser']) ? $cert['issuser'] : '';
            $signCert['startDate'] = isset($cert['startDate']) ? $cert['startDate'] : '';
            $signCert['endDate'] = isset($cert['endDate']) ? $cert['endDate'] : '';
        }
        //签名域相关的信息
        $sign = isset($detail['signature']) ? $detail['signature'] : array();
        if (count($sign)) {
            $signature['signDate'] = isset($sign['signDate']) ? $sign['signDate'] : '';//签署时间
            $signature['fileDigest'] = isset($sign['fileDigest']) ? $sign['fileDigest'] : '';//文档摘要
            $signature['fileName'] = isset($sign['fileName']) ? $sign['fileName'] : '';//文档名称
            $signature['signature'] = isset($sign['signature']) ? $sign['signature'] : '';//签名结果
        }
        $result['signCert'] = $signCert; //签署中使用的证书详情
        $result['signature'] = $signature; //签名域相关的信息

        return array_merge($this->errInfo, array('signDetail' => $result));
    }

}