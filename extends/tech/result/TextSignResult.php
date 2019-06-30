<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class TextSignResult extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;
        $result = array();
        if (isset($resp['signResult'])) {
            $result['signResult'] = $resp['signResult'];
        }
        if (isset($resp['signResult'])) {
            $result['signId'] = $resp['signId'];
        }
        return array_merge($this->errInfo, $result);
    }

}