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
                'username' => 'simon',
                'password' => '$2y$10$W.uMt1NhYA3v4YnbNkYhiO9sl4zhUh.6FM4Ry7S1tFhPbtk7EOXOW',
                'truename' => 'liushifu',
                'email' => 'liu@simon8.com',
                'is_admin' => 0,
                'role' => '1',
                'avatar' => '/uploads/thumbs/201905/1558620843143.jpg',
                'lastip' => '',
                'lasttime' => '2019-05-28 14:15:32',
                'remember_token' => NULL,
                'created_at' => '2019-05-23 22:13:17',
                'updated_at' => '2019-05-28 22:15:31',
            ),
        ));
        
        
    }
}