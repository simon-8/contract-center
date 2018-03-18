<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('manager')->delete();
        
        \DB::table('manager')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$sx8o3fSn/u6zh1bK/m65lufmYHQo6RIlRpclxcOjB5YKrMJmUAnKK',
                'truename' => 'simon',
                'email' => 'liu@simon8.com',
                'is_admin' => 1,
                'role' => '',
                'lastip' => '',
                'lasttime' => '2018-03-18 06:17:46',
                'remember_token' => NULL,
                'created_at' => '2018-03-18 14:17:46',
                'updated_at' => '2018-03-18 14:17:46',
            ),
        ));
        
        
    }
}