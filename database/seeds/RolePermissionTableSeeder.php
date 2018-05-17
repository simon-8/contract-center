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
                'role_id' => '2',
                'access_id' => '2',
            ),
            2 => 
            array (
                'role_id' => '2',
                'access_id' => '3',
            ),
            3 => 
            array (
                'role_id' => '2',
                'access_id' => '4',
            ),
            4 => 
            array (
                'role_id' => '2',
                'access_id' => '5',
            ),
            5 => 
            array (
                'role_id' => '2',
                'access_id' => '10',
            ),
            6 => 
            array (
                'role_id' => '2',
                'access_id' => '11',
            ),
            7 => 
            array (
                'role_id' => '2',
                'access_id' => '12',
            ),
            8 => 
            array (
                'role_id' => '2',
                'access_id' => '13',
            ),
            9 => 
            array (
                'role_id' => '2',
                'access_id' => '16',
            ),
            10 => 
            array (
                'role_id' => '2',
                'access_id' => '18',
            ),
            11 => 
            array (
                'role_id' => '2',
                'access_id' => '20',
            ),
        ));
        
        
    }
}