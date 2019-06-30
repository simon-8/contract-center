<?php
/**
 * User: wanglf
 * Date: 2017/1/11
 */

namespace tech\result;


abstract class AbstractResult
{
    /**
     * 请求是否成功
     */
    protected $isOk = false;

    /**
     * 由子类解析过的数据
     */
    protected $parsedData = null;

    protected $rawResponse;

    protected $errInfo;

    public function __construct($response)
    {
        if ($response === null) {
            throw new \Exception("response is null");
        }
        $this->rawResponse = $response;
        $this->parseResponse();
    }

    public function parseResponse()
    {
        if ($this->rawResponse['errCode'] === 0) {
            if (empty($this->rawResponse['msg'])) {
                $this->rawResponse['msg'] = '成功';
            }
            $this->errInfo = array(
                'errCode' => $this->rawResponse['errCode'],
                'msg' => $this->rawResponse['msg'],
                'errShow' => false
            );
            $this->parsedData = $this->parseData();
        } else {
            if (empty($this->rawResponse['msg'])) {
                $this->rawResponse['msg'] = '失败';
            }
            $this->parsedData = $this->rawResponse;
        }
    }

    /**
     * 由子类实现，不同的请求返回不同的结果集
     *
     * @return mixed
     */
    abstract protected function parseData();

    /**
     * 得到返回数据，不同的请求返回数据格式不同
     *
     * $return mixed
     */
    public function getData()
    {
        return $this->parsedData;
    }

}