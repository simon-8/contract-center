<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activity')->delete();
        
        \DB::table('activity')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => '我是活动1',
                'start_time' => 1521680248,
                'end_time' => 1522425600,
                'actor' => 0,
                'max_actor' => 0,
                'status' => 1,
                'created_at' => '2018-03-22 08:57:35',
                'updated_at' => '2018-03-22 08:57:35',
            ),
        ));
        
        
    }
}