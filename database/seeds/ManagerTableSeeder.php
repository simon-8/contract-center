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
                'password' => '$2y$10$W.uMt1NhYA3v4YnbNkYhiO9sl4zhUh.6FM4Ry7S1tFhPbtk7EOXOW',
                'truename' => '小李子',
                'email' => 'liu@simon8.com',
                'is_admin' => 0,
                'role' => '1',
                'avatar' => '/uploads/thumbs/201905/1558620843143.jpg',
                'lastip' => '192.168.10.1',
                'lasttime' => '2019-09-25 06:20:38',
                'remember_token' => NULL,
                'created_at' => '2019-05-23 22:13:17',
                'updated_at' => '2019-09-25 14:11:10',
            ),
        ));
        
        
    }
}