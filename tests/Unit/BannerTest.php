<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    //public function testExample()
    //{
    //    $this->assertTrue(true);
    //}
    public function testIndex()
    {
        $url = '/api/banner/1';
        $response = $this->get($url);
        $response->assertOk();
        $data = json_decode($response->getContent(), true);
        $data = $data['data'];
        $this->assertArrayHasKey('id', array_shift($data));
    }
}
