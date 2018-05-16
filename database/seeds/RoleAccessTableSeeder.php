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
                'name' => '所有权限',
                'route' => 'admin',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '文章发布',
                'route' => 'admin.article.create',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '文章编辑',
                'route' => 'admin.article.update',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '文章删除',
                'route' => 'admin.article.delete',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '文章列表',
                'route' => 'admin.article.index',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => '权限管理',
                'route' => 'admin.roleaccess',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => '会员组管理',
                'route' => 'admin.rolegroup',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => '单页列表',
                'route' => 'admin.single.index',
            ),
            8 => 
            array (
                'id' => 11,
                'name' => '单页发布',
                'route' => 'admin.single.create',
            ),
            9 => 
            array (
                'id' => 12,
                'name' => '单页编辑',
                'route' => 'admin.single.update',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => '单页删除',
                'route' => 'admin.single.delete',
            ),
            11 => 
            array (
                'id' => 14,
                'name' => '管理员管理',
                'route' => 'admin.manager',
            ),
            12 => 
            array (
                'id' => 15,
                'name' => '基本设置',
                'route' => 'admin.setting.index',
            ),
            13 => 
            array (
                'id' => 16,
                'name' => '数据管理',
                'route' => 'admin.database',
            ),
            14 => 
            array (
                'id' => 17,
                'name' => '广告管理',
                'route' => 'admin.ad',
            ),
            15 => 
            array (
                'id' => 18,
                'name' => '分类管理',
                'route' => 'admin.category',
            ),
            16 => 
            array (
                'id' => 19,
                'name' => '系统日志',
                'route' => 'log-viewer',
            ),
        ));
        
        
    }
}