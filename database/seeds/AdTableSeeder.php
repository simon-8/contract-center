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
                'id' => 1,
                'pid' => 1,
                'thumb' => 'http://blog.cc/manage/img/profile_small.jpg',
                'url' => 'http://blog.cc/manage/img/profile_small.jpg',
                'title' => '123',
                'content' => '321',
                'listorder' => 0,
                'created_at' => '2018-03-21 00:18:39',
                'updated_at' => '2018-03-20 00:18:41',
            ),
        ));
        
        
    }
}