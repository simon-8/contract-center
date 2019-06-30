<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class AddTemplateResult extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;
        $result = array();
        if (isset($resp['imageBase64'])) {
            $result['imageBase64'] = $resp['imageBase64'];
        }
        return array_merge($this->errInfo, $result);
    }

}