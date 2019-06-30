<?php
/**
 * User: Administrator
 * Date: 2017/1/11
 */

namespace tech\result;


class Result extends AbstractResult
{
    public function parseData()
    {
        $res = $this->rawResponse;

        return $res;
    }

}