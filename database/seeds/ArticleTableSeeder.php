<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('article')->delete();
        \DB::table('article_content')->delete();

        factory(App\Models\Article::class, 50)->create()->each(function($a) {
            $a->content()->save(factory(App\Models\ArticleContent::class)->make());
        });
    }
}