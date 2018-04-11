<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 0,
                'name' => '菜单管理',
                'prefix' => 'admin.menu',
                'route' => 'index',
                'ico' => 'fa fa-list',
                'listorder' => 97,
                'items' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => '管理员管理',
                'prefix' => 'admin.manager',
                'route' => 'index',
                'ico' => 'fa fa-users',
                'listorder' => 96,
                'items' => 0,
            ),
            2 => 
            array (
                'id' => 5,
                'pid' => 6,
                'name' => '数据管理',
                'prefix' => 'admin.database',
                'route' => 'index',
                'ico' => 'fa fa-database',
                'listorder' => 0,
                'items' => 0,
            ),
            3 => 
            array (
                'id' => 6,
                'pid' => 0,
                'name' => '系统设置',
                'prefix' => 'admin.setting',
                'route' => 'index',
                'ico' => 'fa fa-cog',
                'listorder' => 0,
                'items' => 5,
            ),
            4 => 
            array (
                'id' => 7,
                'pid' => 0,
                'name' => '前台首页',
                'prefix' => 'home.index',
                'route' => 'index',
                'ico' => 'fa fa-home',
                'listorder' => 99,
                'items' => 0,
            ),
            5 => 
            array (
                'id' => 8,
                'pid' => 0,
                'name' => '后台首页',
                'prefix' => 'admin',
                'route' => 'index',
                'ico' => 'fa fa-desktop',
                'listorder' => 98,
                'items' => 0,
            ),
            6 => 
            array (
                'id' => 9,
                'pid' => 6,
                'name' => '广告位管理',
                'prefix' => 'admin.ad',
                'route' => 'index',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            7 => 
            array (
                'id' => 12,
                'pid' => 6,
                'name' => '基本设置',
                'prefix' => 'admin.setting',
                'route' => 'index',
                'ico' => '',
                'listorder' => 99,
                'items' => 0,
            ),
            8 => 
            array (
                'id' => 13,
                'pid' => 0,
                'name' => '用户管理',
                'prefix' => 'admin.user',
                'route' => 'index',
                'ico' => 'fa fa-user',
                'listorder' => 93,
                'items' => 0,
            ),
            9 => 
            array (
                'id' => 14,
                'pid' => 0,
                'name' => '文章管理',
                'prefix' => 'admin.article',
                'route' => 'index',
                'ico' => 'fa fa-book',
                'listorder' => 94,
                'items' => 0,
            ),
            10 => 
            array (
                'id' => 15,
                'pid' => 6,
                'name' => '分类管理',
                'prefix' => 'admin.category',
                'route' => 'index',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            11 => 
            array (
                'id' => 16,
                'pid' => 6,
                'name' => '系统日志',
                'prefix' => '',
                'route' => '/admin/logs',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            12 => 
            array (
                'id' => 17,
                'pid' => 0,
                'name' => '单页管理',
                'prefix' => 'admin.single',
                'route' => 'index',
                'ico' => 'fa fa-newspaper-o',
                'listorder' => 93,
                'items' => 0,
            ),
        ));
        
        
    }
}