<?php

use Illuminate\Database\Seeder;

class AdTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ad')->delete();
        
        \DB::table('ad')->insert(array (
            0 => 
            array (
                'id' => 2,
                'pid' => 1,
                'thumb' => '/uploads/thumbs/201803/1521680276888.jpg',
                'url' => '',
                'title' => '广告图1',
                'content' => '',
                'listorder' => 0,
                'created_at' => '2018-03-22 08:57:56',
                'updated_at' => '2018-03-22 08:57:56',
            ),
            1 => 
            array (
                'id' => 3,
                'pid' => 1,
                'thumb' => '/uploads/thumbs/201803/1521680290575.jpg',
                'url' => '',
                'title' => '广告图2',
                'content' => '',
                'listorder' => 0,
                'created_at' => '2018-03-22 08:58:10',
                'updated_at' => '2018-03-22 08:58:10',
            ),
        ));
        
        
    }
}