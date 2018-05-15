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
                'id' => 1,
                'pid' => 0,
                'name' => '所有权限',
                'method' => '',
                'path' => 'admin',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => '发布文章',
                'method' => '',
                'path' => 'admin.article.create',
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 0,
                'name' => '编辑文章',
                'method' => '',
                'path' => 'admin.article.update',
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 0,
                'name' => '删除文章',
                'method' => '',
                'path' => 'admin.article.delete',
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 0,
                'name' => '文章列表',
                'method' => '',
                'path' => 'admin.article',
            ),
        ));
        
        
    }
}