<?php

use Illuminate\Database\Seeder;

class GiftsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gifts')->delete();
        
        \DB::table('gifts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'aid' => 2,
                'name' => '我是奖品1',
                'introduce' => '',
                'thumb' => '/uploads/thumbs/201803/1521680374182.jpg',
                'level' => 3,
                'amount' => 1000,
                'sales' => 0,
                'status' => 1,
                'created_at' => '2018-03-22 08:58:31',
                'updated_at' => '2018-03-22 08:59:34',
            ),
        ));
        
        
    }
}