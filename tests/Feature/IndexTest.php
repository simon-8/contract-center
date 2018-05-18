<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testArticle()
    {
        // articles
        $response = $this->get('/api/article');
        $response->assertStatus(200)
                ->assertJsonStructure(['data']);

        // article detail
        $articles = json_decode($response->getContent(), true)['data'];
        $article = array_shift($articles);
        $response = $this->get('/api/article/'.$article['id']);
        $response->assertStatus(200)
                ->assertJsonStructure(['id', 'content']);

        $response = $this->get('/api/article/'. mt_rand(10000, 50000));
        $response->assertStatus(404);
    }

    public function testCategorys()
    {
        $response = $this->get('/api/category');
        $categorys = json_decode($response->getContent(), true);
        $category = array_shift($categorys);

        $response->assertStatus(200);
        $this->assertArrayHasKey('name', $category);
    }

    public function testBanners()
    {
        $response = $this->get('/api/banner');
        $banners = json_decode($response->getContent(), true);
        $banner = array_shift($banners);

        $response->assertStatus(200);
        $this->assertArrayHasKey('title', $banner);
    }
}
