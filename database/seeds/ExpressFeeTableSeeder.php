<?php

use Illuminate\Database\Seeder;

class ExpressFeeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('express_fee')->delete();
        
        \DB::table('express_fee')->insert(array (
            0 => 
            array (
                'id' => 11,
                'name' => '北京市',
                'amount' => 0,
            ),
            1 => 
            array (
                'id' => 12,
                'name' => '天津市',
                'amount' => 0,
            ),
            2 => 
            array (
                'id' => 13,
                'name' => '河北省',
                'amount' => 0,
            ),
            3 => 
            array (
                'id' => 14,
                'name' => '山西省',
                'amount' => 0,
            ),
            4 => 
            array (
                'id' => 15,
                'name' => '内蒙古自治区',
                'amount' => 0,
            ),
            5 => 
            array (
                'id' => 21,
                'name' => '辽宁省',
                'amount' => 0,
            ),
            6 => 
            array (
                'id' => 22,
                'name' => '吉林省',
                'amount' => 0,
            ),
            7 => 
            array (
                'id' => 23,
                'name' => '黑龙江省',
                'amount' => 0,
            ),
            8 => 
            array (
                'id' => 31,
                'name' => '上海市',
                'amount' => 0,
            ),
            9 => 
            array (
                'id' => 32,
                'name' => '江苏省',
                'amount' => 0,
            ),
            10 => 
            array (
                'id' => 33,
                'name' => '浙江省',
                'amount' => 0,
            ),
            11 => 
            array (
                'id' => 34,
                'name' => '安徽省',
                'amount' => 0,
            ),
            12 => 
            array (
                'id' => 35,
                'name' => '福建省',
                'amount' => 0,
            ),
            13 => 
            array (
                'id' => 36,
                'name' => '江西省',
                'amount' => 0,
            ),
            14 => 
            array (
                'id' => 37,
                'name' => '山东省',
                'amount' => 0,
            ),
            15 => 
            array (
                'id' => 41,
                'name' => '河南省',
                'amount' => 0,
            ),
            16 => 
            array (
                'id' => 42,
                'name' => '湖北省',
                'amount' => 0,
            ),
            17 => 
            array (
                'id' => 43,
                'name' => '湖南省',
                'amount' => 0,
            ),
            18 => 
            array (
                'id' => 44,
                'name' => '广东省',
                'amount' => 0,
            ),
            19 => 
            array (
                'id' => 45,
                'name' => '广西壮族自治区',
                'amount' => 0,
            ),
            20 => 
            array (
                'id' => 46,
                'name' => '海南省',
                'amount' => 0,
            ),
            21 => 
            array (
                'id' => 50,
                'name' => '重庆市',
                'amount' => 0,
            ),
            22 => 
            array (
                'id' => 51,
                'name' => '四川省',
                'amount' => 0,
            ),
            23 => 
            array (
                'id' => 52,
                'name' => '贵州省',
                'amount' => 0,
            ),
            24 => 
            array (
                'id' => 53,
                'name' => '云南省',
                'amount' => 0,
            ),
            25 => 
            array (
                'id' => 54,
                'name' => '西藏自治区',
                'amount' => 0,
            ),
            26 => 
            array (
                'id' => 61,
                'name' => '陕西省',
                'amount' => 0,
            ),
            27 => 
            array (
                'id' => 62,
                'name' => '甘肃省',
                'amount' => 0,
            ),
            28 => 
            array (
                'id' => 63,
                'name' => '青海省',
                'amount' => 0,
            ),
            29 => 
            array (
                'id' => 64,
                'name' => '宁夏回族自治区',
                'amount' => 0,
            ),
            30 => 
            array (
                'id' => 65,
                'name' => '新疆维吾尔自治区',
                'amount' => 0,
            ),
            31 => 
            array (
                'id' => 66,
                'name' => '台湾',
                'amount' => 0,
            ),
            32 => 
            array (
                'id' => 67,
                'name' => '香港',
                'amount' => 0,
            ),
            33 => 
            array (
                'id' => 68,
                'name' => '澳门',
                'amount' => 0,
            ),
        ));
        
        
    }
}