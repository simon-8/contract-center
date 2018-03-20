<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user')->delete();
        
        \DB::table('user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'openid' => '123123123',
                'truename' => '刘师傅',
                'mobile' => '18655601231',
                'nickname' => 'simon',
                'avatar' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1521485594187&di=bf39230b86ba1b54406369a315ffdc88&imgtype=0&src=http%3A%2F%2Fc.hiphotos.baidu.com%2Fimage%2Fpic%2Fitem%2F4bed2e738bd4b31ccd851da88bd6277f9e2ff86c.jpg',
                'language' => 'zh',
                'city' => '年轻',
                'province' => '',
                'country' => '',
                'unionid' => '',
                'subscribed_at' => NULL,
                'created_at' => '2018-03-20 00:04:20',
                'updated_at' => '2018-03-22 00:04:23',
            ),
            1 => 
            array (
                'id' => 2,
                'openid' => '123254134',
                'truename' => '李师傅',
                'mobile' => '18678787887',
                'nickname' => 'li',
                'avatar' => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1521485594187&di=bf39230b86ba1b54406369a315ffdc88&imgtype=0&src=http%3A%2F%2Fc.hiphotos.baidu.com%2Fimage%2Fpic%2Fitem%2F4bed2e738bd4b31ccd851da88bd6277f9e2ff86c.jpg',
                'language' => 'zh',
                'city' => '年轻',
                'province' => '',
                'country' => '',
                'unionid' => '',
                'subscribed_at' => '2018-03-20 00:20:26',
                'created_at' => '2018-03-20 00:04:20',
                'updated_at' => '2018-03-22 00:04:23',
            ),
        ));
        
        
    }
}