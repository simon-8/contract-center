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
                'id' => 1,
                'name' => '11111',
                'start_time' => 1521579905,
                'end_time' => 1521568982,
                'actor' => 0,
                'max_actor' => 0,
                'status' => 1,
                'created_at' => '2018-03-18 22:40:33',
                'updated_at' => '2018-03-18 22:44:42',
            ),
        ));
        
        
    }
}