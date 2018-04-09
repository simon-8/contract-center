<?php

use Illuminate\Database\Seeder;

class CategorysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categorys')->delete();
        
        \DB::table('categorys')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pid' => 0,
                'name' => 'PHP',
                'listorder' => 0,
                'created_at' => '2018-04-09 14:15:53',
                'updated_at' => '2018-04-09 14:15:53',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 0,
                'name' => 'Mysql',
                'listorder' => 0,
                'created_at' => '2018-04-09 14:16:06',
                'updated_at' => '2018-04-09 14:16:06',
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 0,
                'name' => 'Linux',
                'listorder' => 0,
                'created_at' => '2018-04-09 14:17:28',
                'updated_at' => '2018-04-09 14:17:28',
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 0,
                'name' => 'Windows',
                'listorder' => 0,
                'created_at' => '2018-04-09 14:17:32',
                'updated_at' => '2018-04-09 14:17:32',
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 3,
                'name' => 'supervisor',
                'listorder' => 0,
                'created_at' => '2018-04-09 14:25:47',
                'updated_at' => '2018-04-09 14:25:47',
            ),
        ));
        
        
    }
}