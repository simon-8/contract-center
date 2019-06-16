<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testStatus()
    {
        $url = '/api/contract/status';
        $response = $this->get($url);
        $response->assertOk();
        $data = json_decode($response->getContent(), true);
        $data = $data['data'];
        $this->assertIsArray($data);
    }

    public function testCountByStatus()
    {
        $url = '/api/contract/status-count';
        $response = $this->get($url, [
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjYzM2Y2NzAzMTA3NmNkODdhYmMxYjQ3ZmU1ZjFlMmU4OTUzM2QwYjJmODE1YWRkNmQ2OTg0MWYwOTI5ZWQxZTc4ZTcyMTg2Yjk5OWZjYzBlIn0.eyJhdWQiOiIyIiwianRpIjoiNjMzZjY3MDMxMDc2Y2Q4N2FiYzFiNDdmZTVmMWUyZTg5NTMzZDBiMmY4MTVhZGQ2ZDY5ODQxZjA5MjllZDFlNzhlNzIxODZiOTk5ZmNjMGUiLCJpYXQiOjE1NjA1NzEyNTgsIm5iZiI6MTU2MDU3MTI1OCwiZXhwIjoxNTkyMTkzNjU4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.LYgmKA-3TSAX7HdibtbBBavuiS1YxeZJWePlWRBQyHNcy-Int1upTZth0Nxbr60Y2bhhCWndH_G8mMI5hLtoJ8YrIULYBIkzGgMeROG01Kt7_kfP6d4dmAWdMWMXkkyI5PvMBSQUmodMxgTQR5lDYRDbsxbdNQFFTwt6eDpxD78yvhSWSV5LL0X4ZQtAxfA0sbvC-_EQ_5saB2dzMl7d5MkizxkgKKAvc_E70NunTXCtGasRnZ7OJpWeYvPZD1jenskF3ngDQQy_H6_bz_X1Zgcqj-V35e8SmP5kEr6gK-SJL0VohhxoMHqDWhvycPKDkmeNT3s3V6ICCR1Y6x1EBBGJYekYS6G7GDeHlZXhB5qsKv-EWzlutuMtS9dGS5QW1wriyWjOuizn87n2sbbsOm4b9Vt1Znwtldk40VXZK84Zu19tiOQjSpjjwpuSwcvcFOwxE6nh9vfQtU5-3ojGZ1ZlQ51OzWbw-FiqBsyJHW9eLgsEplghCb4YV2qpjN7yy2Dyp1GZELSe0bnnzShVfspVENDbqCky3ua9UrjFeULe7irpOKsHQ3f2OC1DCDHgMn4XtznNNi1_RsvD2iWjad_uqwg4dz4Bk7BWdaEK_e6HSeI_eeUXGO85Y1Lv5wt7b_ZAg7g8XO4XXL_sP7opJ-nYgL8r7p8n0gV-_jIge7M'
        ]);
        $response->assertOk();
        $data = json_decode($response->getContent(), true);
        $data = $data['data'];
        $this->assertIsArray($data);
    }
}
