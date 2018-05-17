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
                'route' => 'admin.menu.index',
                'link' => '',
                'ico' => 'fa fa-list',
                'listorder' => 97,
                'items' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => '管理员管理',
                'route' => 'admin.manager.index',
                'link' => '',
                'ico' => 'fa fa-users',
                'listorder' => 96,
                'items' => 3,
            ),
            2 => 
            array (
                'id' => 5,
                'pid' => 6,
                'name' => '数据管理',
                'route' => 'admin.database.index',
                'link' => '',
                'ico' => 'fa fa-database',
                'listorder' => 0,
                'items' => 0,
            ),
            3 => 
            array (
                'id' => 6,
                'pid' => 0,
                'name' => '系统设置',
                'route' => 'admin.setting.index',
                'link' => '',
                'ico' => 'fa fa-cog',
                'listorder' => 0,
                'items' => 5,
            ),
            4 => 
            array (
                'id' => 7,
                'pid' => 0,
                'name' => '前台首页',
                'route' => '',
                'link' => '/',
                'ico' => 'fa fa-home',
                'listorder' => 99,
                'items' => 0,
            ),
            5 => 
            array (
                'id' => 8,
                'pid' => 0,
                'name' => '后台首页',
                'route' => 'admin.index.index',
                'link' => '',
                'ico' => 'fa fa-desktop',
                'listorder' => 98,
                'items' => 0,
            ),
            6 => 
            array (
                'id' => 9,
                'pid' => 6,
                'name' => '广告管理',
                'route' => 'admin.ad.index',
                'link' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            7 => 
            array (
                'id' => 12,
                'pid' => 6,
                'name' => '基本设置',
                'route' => 'admin.setting.index',
                'link' => '',
                'ico' => '',
                'listorder' => 99,
                'items' => 0,
            ),
            8 => 
            array (
                'id' => 13,
                'pid' => 0,
                'name' => '用户管理',
                'route' => 'admin.user.index',
                'link' => '',
                'ico' => 'fa fa-user',
                'listorder' => 93,
                'items' => 0,
            ),
            9 => 
            array (
                'id' => 14,
                'pid' => 0,
                'name' => '文章管理',
                'route' => 'admin.article.index',
                'link' => '',
                'ico' => 'fa fa-book',
                'listorder' => 94,
                'items' => 0,
            ),
            10 => 
            array (
                'id' => 15,
                'pid' => 6,
                'name' => '分类管理',
                'route' => 'admin.category.index',
                'link' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            11 => 
            array (
                'id' => 16,
                'pid' => 6,
                'name' => '系统日志',
                'route' => '',
                'link' => '/admin/logs',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            12 => 
            array (
                'id' => 17,
                'pid' => 0,
                'name' => '单页管理',
                'route' => 'admin.single.index',
                'link' => '',
                'ico' => 'fa fa-newspaper-o',
                'listorder' => 93,
                'items' => 0,
            ),
            13 => 
            array (
                'id' => 18,
                'pid' => 2,
                'name' => '权限管理',
                'route' => 'admin.roleaccess.index',
                'link' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            14 => 
            array (
                'id' => 19,
                'pid' => 2,
                'name' => '用户列表',
                'route' => 'admin.manager.index',
                'link' => '',
                'ico' => '',
                'listorder' => 3,
                'items' => 0,
            ),
            15 => 
            array (
                'id' => 20,
                'pid' => 2,
                'name' => '会员组管理',
                'route' => 'admin.roles.index',
                'link' => '',
                'ico' => '',
                'listorder' => 0,
                'items' => 0,
            ),
        ));
        
        
    }
}