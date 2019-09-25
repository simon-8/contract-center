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
                'amount' => 1,
            ),
            1 => 
            array (
                'id' => 12,
                'name' => '天津市',
                'amount' => 1,
            ),
            2 => 
            array (
                'id' => 13,
                'name' => '河北省',
                'amount' => 1,
            ),
            3 => 
            array (
                'id' => 14,
                'name' => '山西省',
                'amount' => 1,
            ),
            4 => 
            array (
                'id' => 15,
                'name' => '内蒙古自治区',
                'amount' => 1,
            ),
            5 => 
            array (
                'id' => 21,
                'name' => '辽宁省',
                'amount' => 1,
            ),
            6 => 
            array (
                'id' => 22,
                'name' => '吉林省',
                'amount' => 1,
            ),
            7 => 
            array (
                'id' => 23,
                'name' => '黑龙江省',
                'amount' => 1,
            ),
            8 => 
            array (
                'id' => 31,
                'name' => '上海市',
                'amount' => 1,
            ),
            9 => 
            array (
                'id' => 32,
                'name' => '江苏省',
                'amount' => 1,
            ),
            10 => 
            array (
                'id' => 33,
                'name' => '浙江省',
                'amount' => 1,
            ),
            11 => 
            array (
                'id' => 34,
                'name' => '安徽省',
                'amount' => 1,
            ),
            12 => 
            array (
                'id' => 35,
                'name' => '福建省',
                'amount' => 1,
            ),
            13 => 
            array (
                'id' => 36,
                'name' => '江西省',
                'amount' => 1,
            ),
            14 => 
            array (
                'id' => 37,
                'name' => '山东省',
                'amount' => 1,
            ),
            15 => 
            array (
                'id' => 41,
                'name' => '河南省',
                'amount' => 1,
            ),
            16 => 
            array (
                'id' => 42,
                'name' => '湖北省',
                'amount' => 1,
            ),
            17 => 
            array (
                'id' => 43,
                'name' => '湖南省',
                'amount' => 1,
            ),
            18 => 
            array (
                'id' => 44,
                'name' => '广东省',
                'amount' => 1,
            ),
            19 => 
            array (
                'id' => 45,
                'name' => '广西壮族自治区',
                'amount' => 1,
            ),
            20 => 
            array (
                'id' => 46,
                'name' => '海南省',
                'amount' => 1,
            ),
            21 => 
            array (
                'id' => 50,
                'name' => '重庆市',
                'amount' => 1,
            ),
            22 => 
            array (
                'id' => 51,
                'name' => '四川省',
                'amount' => 1,
            ),
            23 => 
            array (
                'id' => 52,
                'name' => '贵州省',
                'amount' => 1,
            ),
            24 => 
            array (
                'id' => 53,
                'name' => '云南省',
                'amount' => 1,
            ),
            25 => 
            array (
                'id' => 54,
                'name' => '西藏自治区',
                'amount' => 1,
            ),
            26 => 
            array (
                'id' => 61,
                'name' => '陕西省',
                'amount' => 1,
            ),
            27 => 
            array (
                'id' => 62,
                'name' => '甘肃省',
                'amount' => 1,
            ),
            28 => 
            array (
                'id' => 63,
                'name' => '青海省',
                'amount' => 1,
            ),
            29 => 
            array (
                'id' => 64,
                'name' => '宁夏回族自治区',
                'amount' => 1,
            ),
            30 => 
            array (
                'id' => 65,
                'name' => '新疆维吾尔自治区',
                'amount' => 1,
            ),
            31 => 
            array (
                'id' => 66,
                'name' => '台湾',
                'amount' => 1,
            ),
            32 => 
            array (
                'id' => 67,
                'name' => '香港',
                'amount' => 1,
            ),
            33 => 
            array (
                'id' => 68,
                'name' => '澳门',
                'amount' => 1,
            ),
        ));
        
        
    }
}