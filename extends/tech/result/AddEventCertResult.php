<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class AddEventCertResult extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;
        $result = array();
        if (isset($resp['certId'])) {
            $result['certId'] = $resp['certId'];
        }
        return array_merge($this->errInfo, $result);
    }

}