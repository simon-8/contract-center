<?php

use Illuminate\Database\Seeder;

class ContractTplFillsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contract_tpl_fills')->delete();
        
        \DB::table('contract_tpl_fills')->insert(array (
            0 => 
            array (
                'id' => 1,
                'catid' => 0,
                'formname' => 'jiafang',
                'content' => '甲方',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:44:54',
                'updated_at' => '2019-06-24 13:44:54',
            ),
            1 => 
            array (
                'id' => 2,
                'catid' => 0,
                'formname' => 'yifang',
                'content' => '乙方',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:45:02',
                'updated_at' => '2019-06-24 13:45:02',
            ),
            2 => 
            array (
                'id' => 3,
                'catid' => 2,
                'formname' => 'jujianren',
                'content' => '居间人',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:45:10',
                'updated_at' => '2019-06-24 13:45:46',
            ),
            3 => 
            array (
                'id' => 4,
                'catid' => 0,
                'formname' => 'weizhi',
                'content' => '位置',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:46:09',
                'updated_at' => '2019-06-24 13:46:09',
            ),
            4 => 
            array (
                'id' => 5,
                'catid' => 0,
                'formname' => 'mianji',
                'content' => '面积',
                'listorder' => 0,
                'created_at' => '2019-06-24 13:46:14',
                'updated_at' => '2019-06-24 13:46:14',
            ),
        ));
        
        
    }
}