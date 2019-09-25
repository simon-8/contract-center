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
                'thumb' => 'thumbs/201909/1567974638241.jpg',
                'url' => '',
                'title' => '1',
                'content' => '',
                'listorder' => 0,
                'created_at' => '2019-06-13 21:31:18',
                'updated_at' => '2019-09-09 04:30:38',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 1,
                'thumb' => 'thumbs/201906/1560432696992.jpg',
                'url' => '',
                'title' => '2',
                'content' => '',
                'listorder' => 0,
                'created_at' => '2019-06-13 21:31:36',
                'updated_at' => '2019-06-13 21:31:36',
            ),
        ));
        
        
    }
}