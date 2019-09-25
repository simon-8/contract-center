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
                'name' => '生成合同页banner',
                'width' => 600,
                'height' => 250,
                'status' => 1,
            ),
        ));
        
        
    }
}