<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class AddAccountResult extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;
        $result = array();
        if (isset($resp['accountId'])) {
            $result['accountId'] = $resp['accountId'];
        }
        return array_merge($this->errInfo, $result);
    }

}