<?php
/**
 * User: Administrator
 * Date: 2017/3/30
 */

namespace tech\result;


class EvidenceResult  extends AbstractResult
{
    public function parseData()
    {
        $resp = $this->rawResponse;
        $result = array();
        if (!empty($resp['peid'])) {
            $result['selfEviNum'] = $resp['peid'];//平台存在编号
            $aeids = $resp['aeids'];
            $userEviInfo = array();
            if (count($resp['aeids']) > 0) {
                foreach ($aeids as $k => $v) {
                    $userEviInfo[$k]['accountId'] = $v['accountUid'];
                    $userEviInfo[$k]['eviNum'] = $v['eid'];//用户存证编号
                }
            }
            $result['userEviInfo'] = $userEviInfo;
        }
        return array_merge($this->errInfo, $result);
    }

}