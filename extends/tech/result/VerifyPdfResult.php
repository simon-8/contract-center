<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class VerifyPdfResult extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;

        $signatures = array();
        if (is_array($resp['signatures'])) {
            foreach ($resp['signatures'] as $key => $val) {

                $signatures[$key]['sealName'] = isset($val['sealName']) ? $val['sealName'] : '';
                $signatures[$key]['sealData'] = isset($val['sealData']) ? $val['sealData'] : '';

                //签名使用的证书数据
                $cert = isset($val['cert']) ? $val['cert'] : array();
                $c = array();
                $c['cn'] = isset($cert['cn']) ? $cert['cn'] : '';
                $c['sn'] = isset($cert['sn']) ? $cert['sn'] : '';
                $c['endDate'] = isset($cert['endDate']) ? $cert['endDate'] : '';
                $c['issuerCN'] = isset($cert['issuerCN']) ? $cert['issuerCN'] : '';
                $c['startDate'] = isset($cert['startDate']) ? $cert['startDate'] : '';

                //签名数据
                $sign = isset($val['signature']) ? $val['signature'] : array();
                $s = array();
                $s['signatureName'] = isset($sign['signatureName']) ? $sign['signatureName'] : '';
                $s['validate'] = isset($sign['validate']) ? $sign['validate'] : '';
                $s['timeFrom'] = isset($sign['timeFrom']) ? $sign['timeFrom'] : '';
                $s['signDate'] = isset($sign['signDate']) ? $sign['signDate'] : '';

                $signatures[$key]['cert'] = $c;
                $signatures[$key]['signature'] = $s;
            }
        }
        $result = array(
            'signatures' => $signatures
        );
        return array_merge($this->errInfo, $result);
    }

}