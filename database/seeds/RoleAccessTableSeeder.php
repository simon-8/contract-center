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
                'route' => '*',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '广告管理',
                'route' => 'admin.ad.*',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '广告列表',
                'route' => 'admin.ad.index',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '添加广告',
                'route' => 'admin.ad.create',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '编辑广告',
                'route' => 'admin.ad.edit',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '删除广告',
                'route' => 'admin.ad.destroy',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '广告详情',
                'route' => 'admin.ad.show',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '数据管理',
                'route' => 'admin.database.index',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '系统日志',
                'route' => 'log-viewer::dashboard',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '广告位管理',
                'route' => 'admin.ad-place.*',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => '广告位列表',
                'route' => 'admin.ad-place.index',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => '添加广告位',
                'route' => 'admin.ad-place.create',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => '编辑广告位',
                'route' => 'admin.ad-place.edit',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '删除广告位',
                'route' => 'admin.ad-place.destroy',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => '广告详情',
                'route' => 'admin.ad-place.show',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => '菜单管理',
                'route' => 'admin.menu.*',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => '菜单列表',
                'route' => 'admin.menu.index',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => '添加菜单',
                'route' => 'admin.menu.create',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => '编辑菜单',
                'route' => 'admin.menu.edit',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => '删除菜单',
                'route' => 'admin.menu.destroy',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => '菜单详情',
                'route' => 'admin.menu.show',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => '管理员管理',
                'route' => 'admin.manager.*',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => '管理员列表',
                'route' => 'admin.manager.index',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => '添加管理员',
                'route' => 'admin.manager.create',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => '编辑管理员',
                'route' => 'admin.manager.edit',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => '删除管理员',
                'route' => 'admin.manager.destroy',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => '管理员详情',
                'route' => 'admin.manager.show',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => '角色管理',
                'route' => 'admin.role.*',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => '角色列表',
                'route' => 'admin.role.index',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => '添加角色',
                'route' => 'admin.role.create',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => '编辑角色',
                'route' => 'admin.role.edit',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => '删除角色',
                'route' => 'admin.role.destroy',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => '角色详情',
                'route' => 'admin.role.show',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => '权限管理',
                'route' => 'admin.role-access.*',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => '权限列表',
                'route' => 'admin.role-access.index',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => '添加权限',
                'route' => 'admin.role-access.create',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => '编辑权限',
                'route' => 'admin.role-access.edit',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => '删除权限',
                'route' => 'admin.role-access.destroy',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => '权限详情',
                'route' => 'admin.role-access.show',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => '用户管理',
                'route' => 'admin.user.*',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => '用户列表',
                'route' => 'admin.user.index',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => '添加用户',
                'route' => 'admin.user.create',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => '单页管理',
                'route' => 'admin.single-page.*',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => '单页列表',
                'route' => 'admin.single-page.index',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => '添加单页',
                'route' => 'admin.single-page.create',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => '编辑单页',
                'route' => 'admin.single-page.edit',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => '删除单页',
                'route' => 'admin.single-page.destroy',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => '单页详情',
                'route' => 'admin.single-page.show',
            ),
        ));
        
        
    }
}