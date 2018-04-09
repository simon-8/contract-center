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
                'name' => '文章分类',
                'listorder' => 0,
                'created_at' => '2018-04-09 15:56:45',
                'updated_at' => '2018-04-09 15:56:45',
            ),
            1 => 
            array (
                'id' => 2,
                'pid' => 1,
                'name' => 'PHP',
                'listorder' => 0,
                'created_at' => '2018-04-09 15:57:05',
                'updated_at' => '2018-04-09 15:57:05',
            ),
            2 => 
            array (
                'id' => 3,
                'pid' => 1,
                'name' => 'Mysql',
                'listorder' => 0,
                'created_at' => '2018-04-09 15:59:15',
                'updated_at' => '2018-04-09 15:59:15',
            ),
            3 => 
            array (
                'id' => 4,
                'pid' => 1,
                'name' => 'Linux',
                'listorder' => 0,
                'created_at' => '2018-04-09 15:59:55',
                'updated_at' => '2018-04-09 15:59:55',
            ),
            4 => 
            array (
                'id' => 5,
                'pid' => 1,
                'name' => 'Windows',
                'listorder' => 0,
                'created_at' => '2018-04-09 16:01:17',
                'updated_at' => '2018-04-09 16:01:17',
            ),
        ));
        
        
    }
}