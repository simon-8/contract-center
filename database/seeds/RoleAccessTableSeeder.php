<?php

use Illuminate\Database\Seeder;

class RoleAccessTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_access')->delete();
        
        \DB::table('role_access')->insert(array (
            0 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => '添加管理员',
                'method' => 'GET,POST,PUT',
                'path' => '/manager/*',
            ),
            1 => 
            array (
                'id' => 3,
                'pid' => 0,
                'name' => '发布文章',
                'method' => '',
                'path' => '/article',
            ),
        ));
        
        
    }
}