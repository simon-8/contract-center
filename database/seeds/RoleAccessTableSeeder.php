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
            48 => 
            array (
                'id' => 49,
                'name' => '合同管理',
                'route' => 'admin.contract.*',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => '合同列表',
                'route' => 'admin.contract.index',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => '添加合同',
                'route' => 'admin.contract.create',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => '编辑合同',
                'route' => 'admin.contract.edit',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => '删除合同',
                'route' => 'admin.contract.destroy',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => '合同详情',
                'route' => 'admin.contract.show',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => '合同类型',
                'route' => 'admin.contract-category.*',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => '类型列表',
                'route' => 'admin.contract-category.index',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => '添加类型',
                'route' => 'admin.contract-category.create',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => '编辑类型',
                'route' => 'admin.contract-category.edit',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => '删除类型',
                'route' => 'admin.contract-category.destroy',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => '类型详情',
                'route' => 'admin.contract-category.show',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => '合同模板管理',
                'route' => 'admin.contract-tpl.*',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => '合同模板列表',
                'route' => 'admin.contract-tpl.index',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => '合同模板添加',
                'route' => 'admin.contract-tpl.create',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => '合同模板编辑',
                'route' => 'admin.contract-tpl.edit',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => '合同模板删除',
                'route' => 'admin.contract-tpl.destroy',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => '合同模板详情',
                'route' => 'admin.contract-tpl.show',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => '模板模块管理',
                'route' => 'admin.contract-tpl-section.*',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => '模板模块列表',
                'route' => 'admin.contract-tpl-section.index',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => '模板模块添加',
                'route' => 'admin.contract-tpl-section.create',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => '模板模块编辑',
                'route' => 'admin.contract-tpl-section.edit',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => '模板模块删除',
                'route' => 'admin.contract-tpl-section.destroy',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => '模板模块详情',
                'route' => 'admin.contract-tpl-section.show',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => '快递费用管理',
                'route' => 'admin.express-fee.index',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => '快递费用更新',
                'route' => 'admin.express-fee.store',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => '运营信息',
                'route' => 'admin.operation.*',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => '订单管理',
                'route' => 'admin.operation.order',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => '律师见证',
                'route' => 'admin.order-lawyer-confirm.index',
            ),
        ));
        
        
    }
}