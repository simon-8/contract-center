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
                'role_id' => '3',
                'access_id' => '3',
            ),
            1 => 
            array (
                'role_id' => '3',
                'access_id' => '4',
            ),
            2 => 
            array (
                'role_id' => '3',
                'access_id' => '5',
            ),
            3 => 
            array (
                'role_id' => '3',
                'access_id' => '6',
            ),
            4 => 
            array (
                'role_id' => '3',
                'access_id' => '7',
            ),
            5 => 
            array (
                'role_id' => '3',
                'access_id' => '11',
            ),
            6 => 
            array (
                'role_id' => '3',
                'access_id' => '12',
            ),
            7 => 
            array (
                'role_id' => '3',
                'access_id' => '13',
            ),
            8 => 
            array (
                'role_id' => '3',
                'access_id' => '14',
            ),
            9 => 
            array (
                'role_id' => '3',
                'access_id' => '15',
            ),
            10 => 
            array (
                'role_id' => '3',
                'access_id' => '41',
            ),
            11 => 
            array (
                'role_id' => '3',
                'access_id' => '42',
            ),
            12 => 
            array (
                'role_id' => '3',
                'access_id' => '44',
            ),
            13 => 
            array (
                'role_id' => '3',
                'access_id' => '45',
            ),
            14 => 
            array (
                'role_id' => '3',
                'access_id' => '46',
            ),
            15 => 
            array (
                'role_id' => '3',
                'access_id' => '47',
            ),
            16 => 
            array (
                'role_id' => '3',
                'access_id' => '48',
            ),
            17 => 
            array (
                'role_id' => '1',
                'access_id' => '1',
            ),
        ));
        
        
    }
}