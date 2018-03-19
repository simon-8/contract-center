<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'item' => 'admin_email',
                'name' => '管理员邮箱',
                'value' => '网站标题',
            ),
            1 => 
            array (
                'item' => 'description',
                'name' => '网站简介',
                'value' => '网站简介网站简介网站简介网站简介网站简介网站简介',
            ),
            2 => 
            array (
                'item' => 'icp',
                'name' => '网站备案号',
                'value' => '皖ICP备12345678号',
            ),
            3 => 
            array (
                'item' => 'keywords',
                'name' => '网站关键词',
                'value' => '网站关键词网站关键词网站关键词网站关键词网站关键词网站关键词',
            ),
            4 => 
            array (
                'item' => 'wx_appid',
                'name' => '微信AppID',
                'value' => '12345678',
            ),
            5 => 
            array (
                'item' => 'powerby',
                'name' => '网站版权',
                'value' => 'Copyright © 2017 Simon  All Rights Reserved.',
            ),
            6 => 
            array (
                'item' => 'title',
                'name' => '网站标题',
                'value' => '网站标题',
            ),
        ));
        
        
    }
}