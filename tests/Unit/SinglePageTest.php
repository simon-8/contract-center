<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SinglePageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testIndex()
    {
        $url = '/api/single-page';
        $response = $this->get($url);
        $response->assertOk();
        $data = json_decode($response->getContent(), true);
        $data = $data['data'];
        $this->assertIsArray($data);
        $this->assertArrayHasKey('catid', $data[0]);
    }
}
