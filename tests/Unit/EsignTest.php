<?php

namespace Tests\Unit;

use App\Services\EsignService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EsignTest extends TestCase
{
    public function testIndex(EsignService $service)
    {
        $url = $service->getFaceUrl('A61B017D62AD4D0AB76AB29C85D3D2A8');
        $url = '/api/banner/1';
        $response = $this->get($url);
        $response->assertOk();
        $data = json_decode($response->getContent(), true);
        $data = $data['data'];
        $this->assertArrayHasKey('id', array_shift($data));
    }
}
