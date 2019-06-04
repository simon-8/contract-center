<?php

use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_permission')->delete();
        
        \DB::table('role_permission')->insert(array (
            0 => 
            array (
                'role_id' => '1',
                'access_id' => '1',
            ),
            1 => 
            array (
                'role_id' => '3',
                'access_id' => '2',
            ),
            2 => 
            array (
                'role_id' => '3',
                'access_id' => '40',
            ),
            3 => 
            array (
                'role_id' => '3',
                'access_id' => '43',
            ),
        ));
        
        
    }
}