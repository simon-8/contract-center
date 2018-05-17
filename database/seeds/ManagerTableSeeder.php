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
                'role' => '1',
                'avatar' => '/manage/img/profile_small.jpg',
                'lastip' => '',
                'lasttime' => '2018-05-17 13:59:50',
                'remember_token' => NULL,
                'created_at' => '2018-03-18 14:17:46',
                'updated_at' => '2018-05-17 13:59:50',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'simon',
                'password' => '$2y$10$8ADWbhGmWoNTbPgnFztbaO3U9ApugP1eZ5coe9Ku01526LXM0fg5i',
                'truename' => 'Simon',
                'email' => 'liu@simon8.com',
                'is_admin' => 1,
                'role' => '2',
                'avatar' => '/manage/img/profile_small.jpg',
                'lastip' => '',
                'lasttime' => '2018-05-17 13:59:59',
                'remember_token' => NULL,
                'created_at' => '2018-03-20 20:40:49',
                'updated_at' => '2018-05-17 13:59:59',
            ),
        ));
        
        
    }
}