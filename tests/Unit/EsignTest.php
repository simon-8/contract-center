<?php

namespace Tests\Unit;

use App\Services\EsignFaceService;
use App\Services\EsignService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EsignTest extends TestCase
{
    public $afterApplicationCreatedCallbacks = [];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testGetToken()
    {
        $service = new EsignFaceService();
        $token = $service->getToken();
        $this->assertIsString($token);
    }

    public function testUserCreate()
    {
        $service = new EsignFaceService();
        $accountId = $service->userCreate(10000);
        $this->assertIsString($accountId);
    }

    public function testUserDel()
    {
        $service = new EsignFaceService();
    }
    //
    //public function testFaceUrl()
    //{
    //    $service = new EsignFaceService();
    //    $response = $service->getFaceUrl('8dddcbbc54914fb1b28423f627a6f07a');
    //    info(__METHOD__, [$response]);
    //    $this->assertIsString($response);
    //}
}
