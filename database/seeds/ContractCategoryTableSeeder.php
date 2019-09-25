<?php

use Illuminate\Database\Seeder;

class ContractCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contract_category')->delete();
        
        \DB::table('contract_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '房屋租赁',
                'players' => 2,
                'introduce' => '',
                'created_at' => '2019-08-11 11:41:21',
                'updated_at' => '2019-08-11 11:45:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '借贷结款三方',
                'players' => 3,
                'introduce' => '',
                'created_at' => '2019-08-11 11:41:21',
                'updated_at' => '2019-09-02 16:40:52',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '买卖合同',
                'players' => 2,
                'introduce' => '货物买卖合同。',
                'created_at' => '2019-08-23 11:16:06',
                'updated_at' => '2019-09-09 16:53:37',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => '劳动合同',
                'players' => 2,
                'introduce' => '',
                'created_at' => '2019-09-06 10:50:50',
                'updated_at' => '2019-09-06 10:50:50',
            ),
        ));
        
        
    }
}