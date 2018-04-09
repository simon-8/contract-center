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
        
        \DB::table('article')->insert(array (
            0 => 
            array (
                'id' => 1,
                'catid' => 2,
                'title' => '11111111',
                'introduce' => '111111',
                'thumb' => '/uploads/thumbs/201804/1523265237408.jpg',
                'username' => '',
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'status' => 1,
                'created_at' => '2018-04-09 16:46:25',
                'updated_at' => '2018-04-09 17:13:57',
            ),
            1 => 
            array (
                'id' => 2,
                'catid' => 2,
                'title' => '2222222222222',
                'introduce' => '222222222',
                'thumb' => '/uploads/thumbs/201804/1523265278856.jpg',
                'username' => '',
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'status' => 1,
                'created_at' => '2018-04-09 16:46:34',
                'updated_at' => '2018-04-09 17:14:38',
            ),
            2 => 
            array (
                'id' => 3,
                'catid' => 3,
                'title' => '33333333333',
                'introduce' => '',
                'thumb' => '',
                'username' => '',
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'status' => 1,
                'created_at' => '2018-04-09 17:18:23',
                'updated_at' => '2018-04-09 17:18:23',
            ),
        ));
        
        
    }
}