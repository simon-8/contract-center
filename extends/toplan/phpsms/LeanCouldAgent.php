<?php

namespace Toplan\PhpSms;

/**
 * Class
 *
 * @property string $apikey
 */
class LeanCouldAgent extends Agent implements ContentSms
{
	protected static $smsUrl = 'https://leancloud.cn';

	public function sendTemplateSms($to, $tempId, array $tempData)
    {

    }

    /**
     * @param array|string $to
     * @param string $content
     */
    public function sendContentSms($to, $content = null)
    {
        $api = '/1.1/requestSmsCode';

        $data = array(
            'mobilePhoneNumber' => $to,
            //'ttl' => 10,
        );

	    $response = $this->curlPost(self::$smsUrl . $api, $data, [
	        'CURLOPT_HTTPHEADER' => [
                "Content-Type:application/json",
                "X-LC-Id: {$this->appid}",
                "X-LC-Key: {$this->appkey}"
            ]
        ]);

        $this->setResult($response);
    }


    /**
     * @param $result
     */
    protected function setResult($result)
    {
        $this->result(Agent::INFO, $result);

        $this->result(Agent::SUCCESS, $result['request'] == 1);
        $this->result(Agent::CODE, $result['response']);// $result['response'] 为json string
    }

}
