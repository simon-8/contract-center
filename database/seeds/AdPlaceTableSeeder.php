<?php

use Illuminate\Database\Seeder;

class AdPlaceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ad_place')->delete();
        
        \DB::table('ad_place')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '首页banner图',
                'width' => 640,
                'height' => 350,
                'status' => 1,
            ),
        ));
        
        
    }
}