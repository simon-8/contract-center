<?php

use Illuminate\Database\Seeder;

class ContractTplRulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contract_tpl_rules')->delete();
        
        \DB::table('contract_tpl_rules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'catid' => 0,
                'content' => '租赁期间, 甲方有权收回出租房屋',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:58:25',
                'updated_at' => '2019-06-24 13:58:25',
            ),
            1 => 
            array (
                'id' => 2,
                'catid' => 0,
                'content' => '未经甲方同意, 房屋不得转让',
                'listorder' => 0,
                'created_at' => '2019-06-24 14:02:45',
                'updated_at' => '2019-06-24 14:02:45',
            ),
            2 => 
            array (
                'id' => 3,
                'catid' => 0,
                'content' => '违约处理..........',
                'listorder' => 0,
                'created_at' => '2019-06-24 14:03:07',
                'updated_at' => '2019-06-24 14:03:07',
            ),
            3 => 
            array (
                'id' => 4,
                'catid' => 0,
                'content' => '产权变更.............',
                'listorder' => 0,
                'created_at' => '2019-06-24 14:03:16',
                'updated_at' => '2019-06-24 14:03:16',
            ),
            4 => 
            array (
                'id' => 5,
                'catid' => 0,
                'content' => '免责条件..................',
                'listorder' => 0,
                'created_at' => '2019-06-24 14:03:25',
                'updated_at' => '2019-06-24 14:03:25',
            ),
        ));
        
        
    }
}