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
                'icon' => 'fa fa-list',
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
                'icon' => 'fa fa-users',
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
                'icon' => 'fa fa-database',
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
                'icon' => 'fa fa-cog',
                'listorder' => 0,
                'items' => 6,
            ),
            4 => 
            array (
                'id' => 7,
                'pid' => 0,
                'name' => '前台首页',
                'route' => '',
                'link' => '/',
                'icon' => 'fa fa-home',
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
                'icon' => 'fa fa-desktop',
                'listorder' => 98,
                'items' => 0,
            ),
            6 => 
            array (
                'id' => 9,
                'pid' => 6,
                'name' => '广告位管理',
                'route' => 'admin.ad-place.index',
                'link' => '',
                'icon' => '',
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
                'icon' => '',
                'listorder' => 99,
                'items' => 0,
            ),
            8 => 
            array (
                'id' => 14,
                'pid' => 0,
                'name' => '文章管理',
                'route' => 'admin.article.index',
                'link' => '',
                'icon' => 'fa fa-book',
                'listorder' => 94,
                'items' => 0,
            ),
            9 => 
            array (
                'id' => 16,
                'pid' => 6,
                'name' => '系统日志',
                'route' => 'log-viewer::dashboard',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            10 => 
            array (
                'id' => 17,
                'pid' => 0,
                'name' => '单页管理',
                'route' => 'admin.single-page.*',
                'link' => '',
                'icon' => 'fa fa-newspaper-o',
                'listorder' => 93,
                'items' => 1,
            ),
            11 => 
            array (
                'id' => 18,
                'pid' => 2,
                'name' => '权限管理',
                'route' => 'admin.role-access.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            12 => 
            array (
                'id' => 19,
                'pid' => 2,
                'name' => '用户列表',
                'route' => 'admin.manager.index',
                'link' => '',
                'icon' => '',
                'listorder' => 3,
                'items' => 0,
            ),
            13 => 
            array (
                'id' => 20,
                'pid' => 2,
                'name' => '角色管理',
                'route' => 'admin.role.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            14 => 
            array (
                'id' => 21,
                'pid' => 0,
                'name' => '用户管理',
                'route' => 'admin.user.*',
                'link' => '',
                'icon' => 'fa fa-users',
                'listorder' => 0,
                'items' => 0,
            ),
            15 => 
            array (
                'id' => 22,
                'pid' => 21,
                'name' => '用户列表',
                'route' => 'admin.user.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            16 => 
            array (
                'id' => 23,
                'pid' => 17,
                'name' => '单页列表',
                'route' => 'admin.single-page.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            17 => 
            array (
                'id' => 24,
                'pid' => 0,
                'name' => '合同管理',
                'route' => 'admin.contract.*',
                'link' => '',
                'icon' => 'fa fa-folder',
                'listorder' => 0,
                'items' => 1,
            ),
            18 => 
            array (
                'id' => 25,
                'pid' => 24,
                'name' => '合同列表',
                'route' => 'admin.contract.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            19 => 
            array (
                'id' => 26,
                'pid' => 0,
                'name' => '合同模板管理',
                'route' => 'admin.contract-template.*',
                'link' => '',
                'icon' => 'fa fa-folder-o',
                'listorder' => 0,
                'items' => 2,
            ),
            20 => 
            array (
                'id' => 27,
                'pid' => 26,
                'name' => '填空模板管理',
                'route' => 'admin.contract-tpl-fill.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
            21 => 
            array (
                'id' => 28,
                'pid' => 26,
                'name' => '通用模板管理',
                'route' => 'admin.contract-tpl-rule.index',
                'link' => '',
                'icon' => '',
                'listorder' => 0,
                'items' => 0,
            ),
        ));
        
        
    }
}