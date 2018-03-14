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
                'listorder' => 0,
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
                'listorder' => 0,
                'items' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 0,
                'name' => '文章管理',
                'prefix' => 'admin.article',
                'route' => 'index',
                'ico' => 'fa fa-book',
                'listorder' => 0,
                'items' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 0,
                'name' => '微信管理',
                'prefix' => 'admin.wechat',
                'route' => 'index',
                'ico' => 'fa fa-wechat',
                'listorder' => 0,
                'items' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 0,
                'name' => '数据管理',
                'prefix' => 'admin.database',
                'route' => 'index',
                'ico' => 'fa fa-database',
                'listorder' => 0,
                'items' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'pid' => 0,
                'name' => '系统设置',
                'prefix' => 'admin.setting',
                'route' => 'index',
                'ico' => 'fa fa-cog',
                'listorder' => 0,
                'items' => 1,
            ),
            6 => 
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
            7 => 
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
            8 => 
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
        ));
        
        
    }
}