<?php

use Illuminate\Database\Seeder;

class RoleGroupTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_group')->delete();
        
        \DB::table('role_group')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '超级管理员',
                'access' => '1',
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '文章管理员',
                'access' => '2,3,4,5',
                'status' => 0,
            ),
        ));
        
        
    }
}