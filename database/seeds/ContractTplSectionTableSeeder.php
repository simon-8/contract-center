<?php

use Illuminate\Database\Seeder;

class ContractTplSectionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contract_tpl_section')->delete();
        
        \DB::table('contract_tpl_section')->insert(array (
            0 => 
            array (
                'id' => 1,
                'catid' => 1,
                'players' => 2,
                'name' => '具体费用说明',
                'listorder' => 1,
                'created_at' => '2019-08-12 00:05:20',
                'updated_at' => '2019-08-14 20:42:44',
            ),
            1 => 
            array (
                'id' => 2,
                'catid' => 1,
                'players' => 2,
                'name' => '房屋基本情况',
                'listorder' => 20,
                'created_at' => '2019-08-12 00:07:45',
                'updated_at' => '2019-08-12 00:20:26',
            ),
            2 => 
            array (
                'id' => 4,
                'catid' => 1,
                'players' => 2,
                'name' => '租赁期限',
                'listorder' => 0,
                'created_at' => '2019-08-12 02:44:39',
                'updated_at' => '2019-08-12 02:44:39',
            ),
            3 => 
            array (
                'id' => 5,
                'catid' => 1,
                'players' => 3,
                'name' => '房屋基本状况',
                'listorder' => 1,
                'created_at' => '2019-08-12 02:45:52',
                'updated_at' => '2019-08-12 02:47:33',
            ),
            4 => 
            array (
                'id' => 7,
                'catid' => 2,
                'players' => 2,
                'name' => '借款金额期限',
                'listorder' => 0,
                'created_at' => '2019-08-20 22:53:57',
                'updated_at' => '2019-08-20 22:54:51',
            ),
            5 => 
            array (
                'id' => 8,
                'catid' => 2,
                'players' => 2,
                'name' => '借款用途',
                'listorder' => 0,
                'created_at' => '2019-08-20 22:55:12',
                'updated_at' => '2019-08-20 22:55:12',
            ),
            6 => 
            array (
                'id' => 9,
                'catid' => 1,
                'players' => 2,
                'name' => '借款担保',
                'listorder' => 0,
                'created_at' => '2019-08-20 22:55:28',
                'updated_at' => '2019-08-20 22:55:28',
            ),
            7 => 
            array (
                'id' => 10,
                'catid' => 1,
                'players' => 2,
                'name' => '房屋情况',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:21:53',
                'updated_at' => '2019-09-02 16:21:53',
            ),
            8 => 
            array (
                'id' => 11,
                'catid' => 1,
                'players' => 2,
                'name' => '情况说明',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:22:05',
                'updated_at' => '2019-09-02 16:22:05',
            ),
            9 => 
            array (
                'id' => 12,
                'catid' => 1,
                'players' => 2,
                'name' => '房屋说明',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:22:17',
                'updated_at' => '2019-09-02 16:22:17',
            ),
            10 => 
            array (
                'id' => 14,
                'catid' => 5,
                'players' => 2,
                'name' => '第一条    劳动合同期限',
                'listorder' => 20,
                'created_at' => '2019-09-06 11:05:09',
                'updated_at' => '2019-09-06 11:54:37',
            ),
            11 => 
            array (
                'id' => 15,
                'catid' => 5,
                'players' => 2,
                'name' => '第二条    工作内容及要求',
                'listorder' => 19,
                'created_at' => '2019-09-06 11:53:55',
                'updated_at' => '2019-09-06 11:55:10',
            ),
            12 => 
            array (
                'id' => 16,
                'catid' => 5,
                'players' => 2,
                'name' => '第三条    劳动保护和劳动条件',
                'listorder' => 18,
                'created_at' => '2019-09-06 11:58:16',
                'updated_at' => '2019-09-06 11:58:16',
            ),
            13 => 
            array (
                'id' => 17,
                'catid' => 5,
                'players' => 2,
                'name' => '第四条    工作时间和休息休假',
                'listorder' => 0,
                'created_at' => '2019-09-06 12:04:21',
                'updated_at' => '2019-09-06 12:04:21',
            ),
            14 => 
            array (
                'id' => 18,
                'catid' => 5,
                'players' => 2,
                'name' => '第五条    劳动报酬及支付方式与时间',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:03:49',
                'updated_at' => '2019-09-06 15:03:49',
            ),
            15 => 
            array (
                'id' => 19,
                'catid' => 5,
                'players' => 2,
                'name' => '第六条    社会保险和福利待遇',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:19:14',
                'updated_at' => '2019-09-06 15:19:14',
            ),
            16 => 
            array (
                'id' => 20,
                'catid' => 5,
                'players' => 2,
                'name' => '第七条    劳动纪律',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:21:08',
                'updated_at' => '2019-09-06 15:21:08',
            ),
            17 => 
            array (
                'id' => 21,
                'catid' => 5,
                'players' => 2,
                'name' => '第八条    劳动合同变更、解除、终止的 条件',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:23:13',
                'updated_at' => '2019-09-06 15:23:13',
            ),
            18 => 
            array (
                'id' => 22,
                'catid' => 5,
                'players' => 2,
                'name' => '第九条    违反劳动合同的责任',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:26:31',
                'updated_at' => '2019-09-06 15:26:31',
            ),
            19 => 
            array (
                'id' => 23,
                'catid' => 5,
                'players' => 2,
                'name' => '第十条    双方需要约定的其他事项',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:28:36',
                'updated_at' => '2019-09-06 15:28:36',
            ),
            20 => 
            array (
                'id' => 24,
                'catid' => 5,
                'players' => 2,
                'name' => '第十一条    其他',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:29:13',
                'updated_at' => '2019-09-06 15:29:13',
            ),
            21 => 
            array (
                'id' => 25,
                'catid' => 3,
                'players' => 2,
                'name' => '第一条  名称、品种、规格、质量',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:00:32',
                'updated_at' => '2019-09-09 17:00:32',
            ),
            22 => 
            array (
                'id' => 26,
                'catid' => 3,
                'players' => 2,
                'name' => '第二条  数量和计量单位、计量方法',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:15:52',
                'updated_at' => '2019-09-09 17:15:52',
            ),
            23 => 
            array (
                'id' => 27,
                'catid' => 3,
                'players' => 2,
                'name' => '第三条  包装方式和包装品的处理',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:19:38',
                'updated_at' => '2019-09-09 17:19:38',
            ),
            24 => 
            array (
                'id' => 28,
                'catid' => 3,
                'players' => 2,
                'name' => '第四条  交货方式',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:20:35',
                'updated_at' => '2019-09-09 17:20:35',
            ),
            25 => 
            array (
                'id' => 29,
                'catid' => 3,
                'players' => 2,
                'name' => '第五条  验收',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:27:26',
                'updated_at' => '2019-09-09 17:27:26',
            ),
            26 => 
            array (
                'id' => 30,
                'catid' => 3,
                'players' => 2,
                'name' => '第六条  损失风险',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:28:39',
                'updated_at' => '2019-09-09 17:28:39',
            ),
            27 => 
            array (
                'id' => 31,
                'catid' => 3,
                'players' => 2,
                'name' => '第七条  价格与货款支付',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:34:44',
                'updated_at' => '2019-09-09 17:34:44',
            ),
            28 => 
            array (
                'id' => 32,
                'catid' => 3,
                'players' => 2,
                'name' => '第八条  提出异议的时间和方法',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:37:40',
                'updated_at' => '2019-09-09 17:37:40',
            ),
            29 => 
            array (
                'id' => 33,
                'catid' => 3,
                'players' => 2,
                'name' => '第九条  违约责任',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:40:30',
                'updated_at' => '2019-09-09 17:40:30',
            ),
            30 => 
            array (
                'id' => 34,
                'catid' => 3,
                'players' => 2,
                'name' => '第十条  争议的处理',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:43:33',
                'updated_at' => '2019-09-09 17:43:33',
            ),
            31 => 
            array (
                'id' => 35,
                'catid' => 3,
                'players' => 2,
                'name' => '第十一条  其他',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:44:50',
                'updated_at' => '2019-09-09 17:44:50',
            ),
            32 => 
            array (
                'id' => 36,
                'catid' => 3,
                'players' => 2,
                'name' => '第十二条  本合同自双方或双方法定代表人或授权代表人签字并加盖公章之日起生效。',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:46:31',
                'updated_at' => '2019-09-09 17:46:31',
            ),
        ));
        
        
    }
}