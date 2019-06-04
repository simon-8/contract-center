<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '超级管理员',
                'access' => '1',
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'name' => '普通管理员',
                'access' => '2,40,43',
                'status' => 1,
            ),
        ));
        
        
    }
}