<?php

use Illuminate\Database\Seeder;

class ContractTplTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contract_tpl')->delete();
        
        \DB::table('contract_tpl')->insert(array (
            0 => 
            array (
                'id' => 1,
                'section_id' => 2,
                'catid' => 1,
                'players' => 2,
            'content' => '<p>甲方房屋(以下简称该房屋)坐落于@填空@; 位于第@填空@层，</p>',
            'formdata' => '["\\u7532\\u65b9\\u623f\\u5c4b(\\u4ee5\\u4e0b\\u7b80\\u79f0\\u8be5\\u623f\\u5c4b)\\u5750\\u843d\\u4e8e",{"type":"input"},"; \\u4f4d\\u4e8e\\u7b2c",{"type":"input"},"\\u5c42\\uff0c"]',
                'listorder' => 0,
                'created_at' => '2019-08-12 00:59:00',
                'updated_at' => '2019-08-14 20:43:26',
            ),
            1 => 
            array (
                'id' => 4,
                'section_id' => 1,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>月租金____填空____元,&nbsp;水费____填空____元/吨,&nbsp;电费____填空____元/度,&nbsp;物业费____填空____元/年,&nbsp;已缴清。</p>',
                'formdata' => '["\\u6708\\u79df\\u91d1",{"type":"input"},"\\u5143,&nbsp;\\u6c34\\u8d39",{"type":"input"},"\\u5143\\/\\u5428,&nbsp;\\u7535\\u8d39",{"type":"input"},"\\u5143\\/\\u5ea6,&nbsp;\\u7269\\u4e1a\\u8d39",{"type":"input"},"\\u5143\\/\\u5e74,&nbsp;\\u5df2\\u7f34\\u6e05\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-08-12 01:03:21',
                'updated_at' => '2019-09-16 17:12:35',
            ),
            2 => 
            array (
                'id' => 6,
                'section_id' => 4,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>租期为__填空__年,&nbsp;不满__填空__按__填空__计算</p>',
                'formdata' => '["\\u79df\\u671f\\u4e3a",{"type":"input"},"\\u5e74,&nbsp;\\u4e0d\\u6ee1",{"type":"input"},"\\u6309",{"type":"input"},"\\u8ba1\\u7b97"]',
                'listorder' => 0,
                'created_at' => '2019-08-18 09:23:36',
                'updated_at' => '2019-08-18 09:23:36',
            ),
            3 => 
            array (
                'id' => 7,
                'section_id' => 7,
                'catid' => 2,
                'players' => 2,
            'content' => '<p><span style="color: rgb(51, 51, 51); font-family: tahoma, 微软雅黑; text-indent: 32px;">借款期限__填空__年，自__填空__起(以甲方实际出借款项之日起算，乙方应另行出具收条)至__填空__止。</span></p>',
            'formdata' => '["\\u501f\\u6b3e\\u671f\\u9650",{"type":"input"},"\\u5e74\\uff0c\\u81ea",{"type":"input"},"\\u8d77(\\u4ee5\\u7532\\u65b9\\u5b9e\\u9645\\u51fa\\u501f\\u6b3e\\u9879\\u4e4b\\u65e5\\u8d77\\u7b97\\uff0c\\u4e59\\u65b9\\u5e94\\u53e6\\u884c\\u51fa\\u5177\\u6536\\u6761)\\u81f3",{"type":"input"},"\\u6b62\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-08-20 23:00:43',
                'updated_at' => '2019-08-20 23:00:43',
            ),
            4 => 
            array (
                'id' => 8,
                'section_id' => 2,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>坐落于__填空__，属于__填空__层</p>',
                'formdata' => '["\\u5750\\u843d\\u4e8e",{"type":"input"},"\\uff0c\\u5c5e\\u4e8e",{"type":"input"},"\\u5c42"]',
                'listorder' => 0,
                'created_at' => '2019-08-23 11:19:12',
                'updated_at' => '2019-08-23 11:19:12',
            ),
            5 => 
            array (
                'id' => 9,
                'section_id' => 2,
                'catid' => 1,
                'players' => 2,
                'content' => '<ol class=" list-paddingleft-2" style="list-style-type: decimal;"><li><p>房屋位置____填空____</p></li><li><p>面积大小____填空____<br/></p></li></ol>',
                'formdata' => '["\\u623f\\u5c4b\\u4f4d\\u7f6e",{"type":"input"},"\\n\\u9762\\u79ef\\u5927\\u5c0f",{"type":"input"},"\\n"]',
                'listorder' => 0,
                'created_at' => '2019-08-23 11:23:41',
                'updated_at' => '2019-09-11 15:13:32',
            ),
            6 => 
            array (
                'id' => 10,
                'section_id' => 10,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>房屋位置____填空____，层高____填空____，</p>',
                'formdata' => '["\\u623f\\u5c4b\\u4f4d\\u7f6e",{"type":"input"},"\\uff0c\\u5c42\\u9ad8",{"type":"input"},"\\uff0c"]',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:22:53',
                'updated_at' => '2019-09-02 16:22:53',
            ),
            7 => 
            array (
                'id' => 11,
                'section_id' => 11,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>房屋位置____填空____，层高____填空____，</p>',
                'formdata' => '["\\u623f\\u5c4b\\u4f4d\\u7f6e",{"type":"input"},"\\uff0c\\u5c42\\u9ad8",{"type":"input"},"\\uff0c"]',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:23:10',
                'updated_at' => '2019-09-02 16:23:10',
            ),
            8 => 
            array (
                'id' => 12,
                'section_id' => 12,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>房屋位置____填空____，层高____填空____。</p>',
                'formdata' => '["\\u623f\\u5c4b\\u4f4d\\u7f6e",{"type":"input"},"\\uff0c\\u5c42\\u9ad8",{"type":"input"},"\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-02 16:23:26',
                'updated_at' => '2019-09-16 17:18:43',
            ),
            9 => 
            array (
                'id' => 13,
                'section_id' => 14,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>本合同为有固定期限的劳动合同。合同期从____填空____起至____填空____止。&nbsp;</p><p>本合同约定试用期的，试用期自____填空____至____填空____。</p>',
                'formdata' => '["\\u672c\\u5408\\u540c\\u4e3a\\u6709\\u56fa\\u5b9a\\u671f\\u9650\\u7684\\u52b3\\u52a8\\u5408\\u540c\\u3002\\u5408\\u540c\\u671f\\u4ece",{"type":"input"},"\\u8d77\\u81f3",{"type":"input"},"\\u6b62\\u3002&nbsp;\\n\\u672c\\u5408\\u540c\\u7ea6\\u5b9a\\u8bd5\\u7528\\u671f\\u7684\\uff0c\\u8bd5\\u7528\\u671f\\u81ea",{"type":"input"},"\\u81f3",{"type":"input"},"\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 11:18:23',
                'updated_at' => '2019-09-12 16:45:05',
            ),
            10 => 
            array (
                'id' => 14,
                'section_id' => 14,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>本合同为无固定期限的劳动合同。合同期从____填空____年____填空____月____填空____日起至____填空____时止（法定或约定的终止合同的条件出现）。本合同约定试用期的，试用期自____填空____年____填空____月____填空____日至____填空____年____填空____月____填空____日。&nbsp;<br/></p>',
                'formdata' => '["\\u672c\\u5408\\u540c\\u4e3a\\u65e0\\u56fa\\u5b9a\\u671f\\u9650\\u7684\\u52b3\\u52a8\\u5408\\u540c\\u3002\\u5408\\u540c\\u671f\\u4ece",{"type":"input"},"\\u5e74",{"type":"input"},"\\u6708",{"type":"input"},"\\u65e5\\u8d77\\u81f3",{"type":"input"},"\\u65f6\\u6b62\\uff08\\u6cd5\\u5b9a\\u6216\\u7ea6\\u5b9a\\u7684\\u7ec8\\u6b62\\u5408\\u540c\\u7684\\u6761\\u4ef6\\u51fa\\u73b0\\uff09\\u3002\\u672c\\u5408\\u540c\\u7ea6\\u5b9a\\u8bd5\\u7528\\u671f\\u7684\\uff0c\\u8bd5\\u7528\\u671f\\u81ea",{"type":"input"},"\\u5e74",{"type":"input"},"\\u6708",{"type":"input"},"\\u65e5\\u81f3",{"type":"input"},"\\u5e74",{"type":"input"},"\\u6708",{"type":"input"},"\\u65e5\\u3002&nbsp;"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 11:40:52',
                'updated_at' => '2019-09-06 15:06:34',
            ),
            11 => 
            array (
                'id' => 15,
                'section_id' => 14,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>本合同为以完成一定工作为期限的劳动合同。合同期从__填空__之日至____填空____之日。</p>',
                'formdata' => '["\\u672c\\u5408\\u540c\\u4e3a\\u4ee5\\u5b8c\\u6210\\u4e00\\u5b9a\\u5de5\\u4f5c\\u4e3a\\u671f\\u9650\\u7684\\u52b3\\u52a8\\u5408\\u540c\\u3002\\u5408\\u540c\\u671f\\u4ece__\\u586b\\u7a7a__\\u4e4b\\u65e5\\u81f3",{"type":"input"},"\\u4e4b\\u65e5\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 11:43:38',
                'updated_at' => '2019-09-06 15:06:24',
            ),
            12 => 
            array (
                'id' => 16,
                'section_id' => 15,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>乙方从事____填空____工作。&nbsp;乙方须根据甲方规定的岗位工作职责和要求，按时、按质、按量完成本职工作。&nbsp;</p>',
                'formdata' => '["\\u4e59\\u65b9\\u4ece\\u4e8b",{"type":"input"},"\\u5de5\\u4f5c\\u3002&nbsp;\\u4e59\\u65b9\\u987b\\u6839\\u636e\\u7532\\u65b9\\u89c4\\u5b9a\\u7684\\u5c97\\u4f4d\\u5de5\\u4f5c\\u804c\\u8d23\\u548c\\u8981\\u6c42\\uff0c\\u6309\\u65f6\\u3001\\u6309\\u8d28\\u3001\\u6309\\u91cf\\u5b8c\\u6210\\u672c\\u804c\\u5de5\\u4f5c\\u3002&nbsp;"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 11:57:22',
                'updated_at' => '2019-09-06 12:00:29',
            ),
            13 => 
            array (
                'id' => 17,
                'section_id' => 16,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>甲乙双方都必须严格执行国家有关安全生产、劳动保护、职业卫生等规定。甲方应为乙方的生产工作提供符合规定的劳动保护设施、劳动防护用品及其他劳动保护条件。乙方应严格遵守各项安全操作规程。甲方必须自觉执行国家有关女职工劳动保护和未成年工特殊保护规定。&nbsp;</p>',
                'formdata' => '["\\u7532\\u4e59\\u53cc\\u65b9\\u90fd\\u5fc5\\u987b\\u4e25\\u683c\\u6267\\u884c\\u56fd\\u5bb6\\u6709\\u5173\\u5b89\\u5168\\u751f\\u4ea7\\u3001\\u52b3\\u52a8\\u4fdd\\u62a4\\u3001\\u804c\\u4e1a\\u536b\\u751f\\u7b49\\u89c4\\u5b9a\\u3002\\u7532\\u65b9\\u5e94\\u4e3a\\u4e59\\u65b9\\u7684\\u751f\\u4ea7\\u5de5\\u4f5c\\u63d0\\u4f9b\\u7b26\\u5408\\u89c4\\u5b9a\\u7684\\u52b3\\u52a8\\u4fdd\\u62a4\\u8bbe\\u65bd\\u3001\\u52b3\\u52a8\\u9632\\u62a4\\u7528\\u54c1\\u53ca\\u5176\\u4ed6\\u52b3\\u52a8\\u4fdd\\u62a4\\u6761\\u4ef6\\u3002\\u4e59\\u65b9\\u5e94\\u4e25\\u683c\\u9075\\u5b88\\u5404\\u9879\\u5b89\\u5168\\u64cd\\u4f5c\\u89c4\\u7a0b\\u3002\\u7532\\u65b9\\u5fc5\\u987b\\u81ea\\u89c9\\u6267\\u884c\\u56fd\\u5bb6\\u6709\\u5173\\u5973\\u804c\\u5de5\\u52b3\\u52a8\\u4fdd\\u62a4\\u548c\\u672a\\u6210\\u5e74\\u5de5\\u7279\\u6b8a\\u4fdd\\u62a4\\u89c4\\u5b9a\\u3002&nbsp;"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 11:59:51',
                'updated_at' => '2019-09-06 14:53:03',
            ),
            14 => 
            array (
                'id' => 18,
                'section_id' => 17,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、甲方实行标准工时制。乙方每日工作8小时，每周工作40小时，休息两天。</p><p>2、甲方由于生产经营需要而延长乙方工作时间的，应按《劳动法》第四十一条的规定执行。</p>',
                'formdata' => '["1\\u3001\\u7532\\u65b9\\u5b9e\\u884c\\u6807\\u51c6\\u5de5\\u65f6\\u5236\\u3002\\u4e59\\u65b9\\u6bcf\\u65e5\\u5de5\\u4f5c8\\u5c0f\\u65f6\\uff0c\\u6bcf\\u5468\\u5de5\\u4f5c40\\u5c0f\\u65f6\\uff0c\\u4f11\\u606f\\u4e24\\u5929\\u3002\\n2\\u3001\\u7532\\u65b9\\u7531\\u4e8e\\u751f\\u4ea7\\u7ecf\\u8425\\u9700\\u8981\\u800c\\u5ef6\\u957f\\u4e59\\u65b9\\u5de5\\u4f5c\\u65f6\\u95f4\\u7684\\uff0c\\u5e94\\u6309\\u300a\\u52b3\\u52a8\\u6cd5\\u300b\\u7b2c\\u56db\\u5341\\u4e00\\u6761\\u7684\\u89c4\\u5b9a\\u6267\\u884c\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 12:06:47',
                'updated_at' => '2019-09-12 16:46:33',
            ),
            15 => 
            array (
                'id' => 19,
                'section_id' => 17,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、甲方经劳动保障行政部门审批，根据生产特点实行____填空____工作制。</p><p>2、甲方由于生产经营需要而延长乙方工作时间的，应按《劳动法》第四十一条的规定执行。</p>',
                'formdata' => '["1\\u3001\\u7532\\u65b9\\u7ecf\\u52b3\\u52a8\\u4fdd\\u969c\\u884c\\u653f\\u90e8\\u95e8\\u5ba1\\u6279\\uff0c\\u6839\\u636e\\u751f\\u4ea7\\u7279\\u70b9\\u5b9e\\u884c",{"type":"input"},"\\u5de5\\u4f5c\\u5236\\u3002\\n2\\u3001\\u7532\\u65b9\\u7531\\u4e8e\\u751f\\u4ea7\\u7ecf\\u8425\\u9700\\u8981\\u800c\\u5ef6\\u957f\\u4e59\\u65b9\\u5de5\\u4f5c\\u65f6\\u95f4\\u7684\\uff0c\\u5e94\\u6309\\u300a\\u52b3\\u52a8\\u6cd5\\u300b\\u7b2c\\u56db\\u5341\\u4e00\\u6761\\u7684\\u89c4\\u5b9a\\u6267\\u884c\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 14:51:47',
                'updated_at' => '2019-09-12 16:46:21',
            ),
            16 => 
            array (
                'id' => 20,
                'section_id' => 18,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、乙方试用期间的月工资为____填空____元。&nbsp;</p><p>2、乙方相对应的岗位（工种）的月工资为____填空____元。乙方工资的增减，奖金、津贴、补贴、加班加点工资的发放，以及特殊情况下的工资支付等，均按相关法律法规及甲方依法制定的规章制度执行。&nbsp;</p><p>3、甲方的工资发放日为每月____填空____日。甲方不得无故拖欠。&nbsp;</p><p>4、甲方支付给乙方的月工资不得低于当地政府规定的最低工资。</p><p><br/></p>',
                'formdata' => '["1\\u3001\\u4e59\\u65b9\\u8bd5\\u7528\\u671f\\u95f4\\u7684\\u6708\\u5de5\\u8d44\\u4e3a",{"type":"input"},"\\u5143\\u3002&nbsp;\\n2\\u3001\\u4e59\\u65b9\\u76f8\\u5bf9\\u5e94\\u7684\\u5c97\\u4f4d\\uff08\\u5de5\\u79cd\\uff09\\u7684\\u6708\\u5de5\\u8d44\\u4e3a",{"type":"input"},"\\u5143\\u3002\\u4e59\\u65b9\\u5de5\\u8d44\\u7684\\u589e\\u51cf\\uff0c\\u5956\\u91d1\\u3001\\u6d25\\u8d34\\u3001\\u8865\\u8d34\\u3001\\u52a0\\u73ed\\u52a0\\u70b9\\u5de5\\u8d44\\u7684\\u53d1\\u653e\\uff0c\\u4ee5\\u53ca\\u7279\\u6b8a\\u60c5\\u51b5\\u4e0b\\u7684\\u5de5\\u8d44\\u652f\\u4ed8\\u7b49\\uff0c\\u5747\\u6309\\u76f8\\u5173\\u6cd5\\u5f8b\\u6cd5\\u89c4\\u53ca\\u7532\\u65b9\\u4f9d\\u6cd5\\u5236\\u5b9a\\u7684\\u89c4\\u7ae0\\u5236\\u5ea6\\u6267\\u884c\\u3002&nbsp;\\n3\\u3001\\u7532\\u65b9\\u7684\\u5de5\\u8d44\\u53d1\\u653e\\u65e5\\u4e3a\\u6bcf\\u6708",{"type":"input"},"\\u65e5\\u3002\\u7532\\u65b9\\u4e0d\\u5f97\\u65e0\\u6545\\u62d6\\u6b20\\u3002&nbsp;\\n4\\u3001\\u7532\\u65b9\\u652f\\u4ed8\\u7ed9\\u4e59\\u65b9\\u7684\\u6708\\u5de5\\u8d44\\u4e0d\\u5f97\\u4f4e\\u4e8e\\u5f53\\u5730\\u653f\\u5e9c\\u89c4\\u5b9a\\u7684\\u6700\\u4f4e\\u5de5\\u8d44\\u3002\\n\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:05:53',
                'updated_at' => '2019-09-12 16:46:53',
            ),
            17 => 
            array (
                'id' => 21,
                'section_id' => 19,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、甲、乙双方必须依法参加社会保险，按月缴纳社会保险费。乙方缴纳部分，由甲方在其工资中代为扣缴。&nbsp;</p><p>2、乙方的公休假、年休假、探亲假、婚丧假、女工孕期、产期、哺乳期待遇以及解除（终止）劳动合同时乙方经济补偿金（生活补助费）、医疗补助费的发放等，均按国家有关法律、法规、政策以及甲方依法制定的规定执行。&nbsp;</p><p>3、乙方患职业病或因工负伤的待遇，因工或因病死亡的丧葬费、一次性抚恤费、供养直系亲属生活困难补助费等均按国家有关法律、法规、规章、政策执行。&nbsp;</p><p>4、乙方患病或负伤的医疗期及其待遇、乙方供养直系亲属的医疗待遇等均按国家有关法律、法规、规章、政策和甲方依法制定的规定执行。&nbsp;</p>',
                'formdata' => '["1\\u3001\\u7532\\u3001\\u4e59\\u53cc\\u65b9\\u5fc5\\u987b\\u4f9d\\u6cd5\\u53c2\\u52a0\\u793e\\u4f1a\\u4fdd\\u9669\\uff0c\\u6309\\u6708\\u7f34\\u7eb3\\u793e\\u4f1a\\u4fdd\\u9669\\u8d39\\u3002\\u4e59\\u65b9\\u7f34\\u7eb3\\u90e8\\u5206\\uff0c\\u7531\\u7532\\u65b9\\u5728\\u5176\\u5de5\\u8d44\\u4e2d\\u4ee3\\u4e3a\\u6263\\u7f34\\u3002&nbsp;\\n2\\u3001\\u4e59\\u65b9\\u7684\\u516c\\u4f11\\u5047\\u3001\\u5e74\\u4f11\\u5047\\u3001\\u63a2\\u4eb2\\u5047\\u3001\\u5a5a\\u4e27\\u5047\\u3001\\u5973\\u5de5\\u5b55\\u671f\\u3001\\u4ea7\\u671f\\u3001\\u54fa\\u4e73\\u671f\\u5f85\\u9047\\u4ee5\\u53ca\\u89e3\\u9664\\uff08\\u7ec8\\u6b62\\uff09\\u52b3\\u52a8\\u5408\\u540c\\u65f6\\u4e59\\u65b9\\u7ecf\\u6d4e\\u8865\\u507f\\u91d1\\uff08\\u751f\\u6d3b\\u8865\\u52a9\\u8d39\\uff09\\u3001\\u533b\\u7597\\u8865\\u52a9\\u8d39\\u7684\\u53d1\\u653e\\u7b49\\uff0c\\u5747\\u6309\\u56fd\\u5bb6\\u6709\\u5173\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u3001\\u653f\\u7b56\\u4ee5\\u53ca\\u7532\\u65b9\\u4f9d\\u6cd5\\u5236\\u5b9a\\u7684\\u89c4\\u5b9a\\u6267\\u884c\\u3002&nbsp;\\n3\\u3001\\u4e59\\u65b9\\u60a3\\u804c\\u4e1a\\u75c5\\u6216\\u56e0\\u5de5\\u8d1f\\u4f24\\u7684\\u5f85\\u9047\\uff0c\\u56e0\\u5de5\\u6216\\u56e0\\u75c5\\u6b7b\\u4ea1\\u7684\\u4e27\\u846c\\u8d39\\u3001\\u4e00\\u6b21\\u6027\\u629a\\u6064\\u8d39\\u3001\\u4f9b\\u517b\\u76f4\\u7cfb\\u4eb2\\u5c5e\\u751f\\u6d3b\\u56f0\\u96be\\u8865\\u52a9\\u8d39\\u7b49\\u5747\\u6309\\u56fd\\u5bb6\\u6709\\u5173\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u3001\\u89c4\\u7ae0\\u3001\\u653f\\u7b56\\u6267\\u884c\\u3002&nbsp;\\n4\\u3001\\u4e59\\u65b9\\u60a3\\u75c5\\u6216\\u8d1f\\u4f24\\u7684\\u533b\\u7597\\u671f\\u53ca\\u5176\\u5f85\\u9047\\u3001\\u4e59\\u65b9\\u4f9b\\u517b\\u76f4\\u7cfb\\u4eb2\\u5c5e\\u7684\\u533b\\u7597\\u5f85\\u9047\\u7b49\\u5747\\u6309\\u56fd\\u5bb6\\u6709\\u5173\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u3001\\u89c4\\u7ae0\\u3001\\u653f\\u7b56\\u548c\\u7532\\u65b9\\u4f9d\\u6cd5\\u5236\\u5b9a\\u7684\\u89c4\\u5b9a\\u6267\\u884c\\u3002&nbsp;\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:20:34',
                'updated_at' => '2019-09-12 16:48:57',
            ),
            18 => 
            array (
                'id' => 22,
                'section_id' => 20,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>甲方双方应严格遵守国家的法律、法规、规章和政策。乙方必须遵守甲方依法制定的规章制度和劳动纪律。</p>',
                'formdata' => '["\\u7532\\u65b9\\u53cc\\u65b9\\u5e94\\u4e25\\u683c\\u9075\\u5b88\\u56fd\\u5bb6\\u7684\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u3001\\u89c4\\u7ae0\\u548c\\u653f\\u7b56\\u3002\\u4e59\\u65b9\\u5fc5\\u987b\\u9075\\u5b88\\u7532\\u65b9\\u4f9d\\u6cd5\\u5236\\u5b9a\\u7684\\u89c4\\u7ae0\\u5236\\u5ea6\\u548c\\u52b3\\u52a8\\u7eaa\\u5f8b\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:22:29',
                'updated_at' => '2019-09-06 15:22:29',
            ),
            19 => 
            array (
                'id' => 23,
                'section_id' => 21,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、具有下列情形之一，经甲乙双方协商一致，可以变更本合同的相关内容：&nbsp;</p><p>（1）本合同订立时所依据的客观情况发生重大变化，致使本合同无法履行的；&nbsp;</p><p>（2）乙方不能胜任原工作岗位的。&nbsp;</p><p>2、乙方具有下列情形之一的，甲方可以随时解除本合同：&nbsp;</p><p>（1）在试用期间被证明不符合录用条件的；&nbsp;</p><p>（2）严重违反劳动纪律或者甲方依法制定的规章制度的；&nbsp;</p><p>（3）严重失职、营私舞弊，对甲方利益造成重大损害的；&nbsp;</p><p>（4）被依法追究刑事责任的。&nbsp;</p><p>3、具有下列情形之一的，甲方可以解除本合同，但应当提前三十日以书面形式通知乙方：&nbsp;</p><p>（1）劳动者患病或者非因工负伤，医疗期满后，不能从事原工作也不能从事由甲方另行安排的工作的；&nbsp;</p><p>（2）劳动者不能胜任劳动合同约定的工作，经过培训或者调整工作岗位，仍不能胜任工作的；&nbsp;</p><p>（3）劳动合同订立时所依据的客观情况发生重大变化，致使原劳动合同无法履行，经当事人协商不能就变更劳动合同达成协议的。&nbsp;</p><p>4、甲方濒临破产进行法定整顿期间或者生产经营状况发生严重困难，达到政府规定的严重困难企业标准，确需裁减人员的，应当提前三十日向工会或者全体职工说明情况，听取工会或者职工意见，并以书面形式向劳动行政部门报告后，可以解除本合同。&nbsp;</p><p>5、乙方具有下列情形之一的，甲方不得依据本条第3、4款的规定解除本合同：&nbsp;</p><p>（1）患职业病或者因工（公）负伤被确认丧失或者部分丧失劳动能力的；&nbsp;</p><p>（2）患病或者负伤，在规定的医疗期内的；&nbsp;</p><p>（3）女职工在孕期、产期、哺乳期内的；&nbsp;</p><p>（4）法律、法规规定的其他情形。&nbsp;</p><p>6、具有下列情形之一的，乙方可以随时通知甲方解除本合同：&nbsp;</p><p>（1）在试用期内的；&nbsp;</p><p>（2）甲方以暴力、威胁或者非法限制人身自由的手段强迫劳动的；&nbsp;</p><p>（3）甲方未按劳动合同约定支付劳动报酬或者提供劳动条件的；&nbsp;</p><p>（4）拒不支付劳动者延长工作时间工资报酬的；&nbsp;</p><p>（5）低于当地最低工资标准或者集体合同约定的工资标准支付劳动者工资的；&nbsp;</p><p>（6）甲方未依法缴纳社会保险费的；&nbsp;</p><p>（7）法律、法规规定的其他情形。&nbsp;</p><p>7、除本条第6款规定的情形外，乙方解除本合同应当提前三十日以书面形式通知甲方。&nbsp;</p><p>8、经甲乙双方协商一致，本合同可以解除。&nbsp;</p><p>9、本合同期满或者甲乙双方约定的终止条件出现，应当即行终止。由于生产（工作）需要，经双方协商一致，可以续订劳动合同。&nbsp;</p>',
                'formdata' => '["1\\u3001\\u5177\\u6709\\u4e0b\\u5217\\u60c5\\u5f62\\u4e4b\\u4e00\\uff0c\\u7ecf\\u7532\\u4e59\\u53cc\\u65b9\\u534f\\u5546\\u4e00\\u81f4\\uff0c\\u53ef\\u4ee5\\u53d8\\u66f4\\u672c\\u5408\\u540c\\u7684\\u76f8\\u5173\\u5185\\u5bb9\\uff1a&nbsp;\\n\\uff081\\uff09\\u672c\\u5408\\u540c\\u8ba2\\u7acb\\u65f6\\u6240\\u4f9d\\u636e\\u7684\\u5ba2\\u89c2\\u60c5\\u51b5\\u53d1\\u751f\\u91cd\\u5927\\u53d8\\u5316\\uff0c\\u81f4\\u4f7f\\u672c\\u5408\\u540c\\u65e0\\u6cd5\\u5c65\\u884c\\u7684\\uff1b&nbsp;\\n\\uff082\\uff09\\u4e59\\u65b9\\u4e0d\\u80fd\\u80dc\\u4efb\\u539f\\u5de5\\u4f5c\\u5c97\\u4f4d\\u7684\\u3002&nbsp;\\n2\\u3001\\u4e59\\u65b9\\u5177\\u6709\\u4e0b\\u5217\\u60c5\\u5f62\\u4e4b\\u4e00\\u7684\\uff0c\\u7532\\u65b9\\u53ef\\u4ee5\\u968f\\u65f6\\u89e3\\u9664\\u672c\\u5408\\u540c\\uff1a&nbsp;\\n\\uff081\\uff09\\u5728\\u8bd5\\u7528\\u671f\\u95f4\\u88ab\\u8bc1\\u660e\\u4e0d\\u7b26\\u5408\\u5f55\\u7528\\u6761\\u4ef6\\u7684\\uff1b&nbsp;\\n\\uff082\\uff09\\u4e25\\u91cd\\u8fdd\\u53cd\\u52b3\\u52a8\\u7eaa\\u5f8b\\u6216\\u8005\\u7532\\u65b9\\u4f9d\\u6cd5\\u5236\\u5b9a\\u7684\\u89c4\\u7ae0\\u5236\\u5ea6\\u7684\\uff1b&nbsp;\\n\\uff083\\uff09\\u4e25\\u91cd\\u5931\\u804c\\u3001\\u8425\\u79c1\\u821e\\u5f0a\\uff0c\\u5bf9\\u7532\\u65b9\\u5229\\u76ca\\u9020\\u6210\\u91cd\\u5927\\u635f\\u5bb3\\u7684\\uff1b&nbsp;\\n\\uff084\\uff09\\u88ab\\u4f9d\\u6cd5\\u8ffd\\u7a76\\u5211\\u4e8b\\u8d23\\u4efb\\u7684\\u3002&nbsp;\\n3\\u3001\\u5177\\u6709\\u4e0b\\u5217\\u60c5\\u5f62\\u4e4b\\u4e00\\u7684\\uff0c\\u7532\\u65b9\\u53ef\\u4ee5\\u89e3\\u9664\\u672c\\u5408\\u540c\\uff0c\\u4f46\\u5e94\\u5f53\\u63d0\\u524d\\u4e09\\u5341\\u65e5\\u4ee5\\u4e66\\u9762\\u5f62\\u5f0f\\u901a\\u77e5\\u4e59\\u65b9\\uff1a&nbsp;\\n\\uff081\\uff09\\u52b3\\u52a8\\u8005\\u60a3\\u75c5\\u6216\\u8005\\u975e\\u56e0\\u5de5\\u8d1f\\u4f24\\uff0c\\u533b\\u7597\\u671f\\u6ee1\\u540e\\uff0c\\u4e0d\\u80fd\\u4ece\\u4e8b\\u539f\\u5de5\\u4f5c\\u4e5f\\u4e0d\\u80fd\\u4ece\\u4e8b\\u7531\\u7532\\u65b9\\u53e6\\u884c\\u5b89\\u6392\\u7684\\u5de5\\u4f5c\\u7684\\uff1b&nbsp;\\n\\uff082\\uff09\\u52b3\\u52a8\\u8005\\u4e0d\\u80fd\\u80dc\\u4efb\\u52b3\\u52a8\\u5408\\u540c\\u7ea6\\u5b9a\\u7684\\u5de5\\u4f5c\\uff0c\\u7ecf\\u8fc7\\u57f9\\u8bad\\u6216\\u8005\\u8c03\\u6574\\u5de5\\u4f5c\\u5c97\\u4f4d\\uff0c\\u4ecd\\u4e0d\\u80fd\\u80dc\\u4efb\\u5de5\\u4f5c\\u7684\\uff1b&nbsp;\\n\\uff083\\uff09\\u52b3\\u52a8\\u5408\\u540c\\u8ba2\\u7acb\\u65f6\\u6240\\u4f9d\\u636e\\u7684\\u5ba2\\u89c2\\u60c5\\u51b5\\u53d1\\u751f\\u91cd\\u5927\\u53d8\\u5316\\uff0c\\u81f4\\u4f7f\\u539f\\u52b3\\u52a8\\u5408\\u540c\\u65e0\\u6cd5\\u5c65\\u884c\\uff0c\\u7ecf\\u5f53\\u4e8b\\u4eba\\u534f\\u5546\\u4e0d\\u80fd\\u5c31\\u53d8\\u66f4\\u52b3\\u52a8\\u5408\\u540c\\u8fbe\\u6210\\u534f\\u8bae\\u7684\\u3002&nbsp;\\n4\\u3001\\u7532\\u65b9\\u6fd2\\u4e34\\u7834\\u4ea7\\u8fdb\\u884c\\u6cd5\\u5b9a\\u6574\\u987f\\u671f\\u95f4\\u6216\\u8005\\u751f\\u4ea7\\u7ecf\\u8425\\u72b6\\u51b5\\u53d1\\u751f\\u4e25\\u91cd\\u56f0\\u96be\\uff0c\\u8fbe\\u5230\\u653f\\u5e9c\\u89c4\\u5b9a\\u7684\\u4e25\\u91cd\\u56f0\\u96be\\u4f01\\u4e1a\\u6807\\u51c6\\uff0c\\u786e\\u9700\\u88c1\\u51cf\\u4eba\\u5458\\u7684\\uff0c\\u5e94\\u5f53\\u63d0\\u524d\\u4e09\\u5341\\u65e5\\u5411\\u5de5\\u4f1a\\u6216\\u8005\\u5168\\u4f53\\u804c\\u5de5\\u8bf4\\u660e\\u60c5\\u51b5\\uff0c\\u542c\\u53d6\\u5de5\\u4f1a\\u6216\\u8005\\u804c\\u5de5\\u610f\\u89c1\\uff0c\\u5e76\\u4ee5\\u4e66\\u9762\\u5f62\\u5f0f\\u5411\\u52b3\\u52a8\\u884c\\u653f\\u90e8\\u95e8\\u62a5\\u544a\\u540e\\uff0c\\u53ef\\u4ee5\\u89e3\\u9664\\u672c\\u5408\\u540c\\u3002&nbsp;\\n5\\u3001\\u4e59\\u65b9\\u5177\\u6709\\u4e0b\\u5217\\u60c5\\u5f62\\u4e4b\\u4e00\\u7684\\uff0c\\u7532\\u65b9\\u4e0d\\u5f97\\u4f9d\\u636e\\u672c\\u6761\\u7b2c3\\u30014\\u6b3e\\u7684\\u89c4\\u5b9a\\u89e3\\u9664\\u672c\\u5408\\u540c\\uff1a&nbsp;\\n\\uff081\\uff09\\u60a3\\u804c\\u4e1a\\u75c5\\u6216\\u8005\\u56e0\\u5de5\\uff08\\u516c\\uff09\\u8d1f\\u4f24\\u88ab\\u786e\\u8ba4\\u4e27\\u5931\\u6216\\u8005\\u90e8\\u5206\\u4e27\\u5931\\u52b3\\u52a8\\u80fd\\u529b\\u7684\\uff1b&nbsp;\\n\\uff082\\uff09\\u60a3\\u75c5\\u6216\\u8005\\u8d1f\\u4f24\\uff0c\\u5728\\u89c4\\u5b9a\\u7684\\u533b\\u7597\\u671f\\u5185\\u7684\\uff1b&nbsp;\\n\\uff083\\uff09\\u5973\\u804c\\u5de5\\u5728\\u5b55\\u671f\\u3001\\u4ea7\\u671f\\u3001\\u54fa\\u4e73\\u671f\\u5185\\u7684\\uff1b&nbsp;\\n\\uff084\\uff09\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u89c4\\u5b9a\\u7684\\u5176\\u4ed6\\u60c5\\u5f62\\u3002&nbsp;\\n6\\u3001\\u5177\\u6709\\u4e0b\\u5217\\u60c5\\u5f62\\u4e4b\\u4e00\\u7684\\uff0c\\u4e59\\u65b9\\u53ef\\u4ee5\\u968f\\u65f6\\u901a\\u77e5\\u7532\\u65b9\\u89e3\\u9664\\u672c\\u5408\\u540c\\uff1a&nbsp;\\n\\uff081\\uff09\\u5728\\u8bd5\\u7528\\u671f\\u5185\\u7684\\uff1b&nbsp;\\n\\uff082\\uff09\\u7532\\u65b9\\u4ee5\\u66b4\\u529b\\u3001\\u5a01\\u80c1\\u6216\\u8005\\u975e\\u6cd5\\u9650\\u5236\\u4eba\\u8eab\\u81ea\\u7531\\u7684\\u624b\\u6bb5\\u5f3a\\u8feb\\u52b3\\u52a8\\u7684\\uff1b&nbsp;\\n\\uff083\\uff09\\u7532\\u65b9\\u672a\\u6309\\u52b3\\u52a8\\u5408\\u540c\\u7ea6\\u5b9a\\u652f\\u4ed8\\u52b3\\u52a8\\u62a5\\u916c\\u6216\\u8005\\u63d0\\u4f9b\\u52b3\\u52a8\\u6761\\u4ef6\\u7684\\uff1b&nbsp;\\n\\uff084\\uff09\\u62d2\\u4e0d\\u652f\\u4ed8\\u52b3\\u52a8\\u8005\\u5ef6\\u957f\\u5de5\\u4f5c\\u65f6\\u95f4\\u5de5\\u8d44\\u62a5\\u916c\\u7684\\uff1b&nbsp;\\n\\uff085\\uff09\\u4f4e\\u4e8e\\u5f53\\u5730\\u6700\\u4f4e\\u5de5\\u8d44\\u6807\\u51c6\\u6216\\u8005\\u96c6\\u4f53\\u5408\\u540c\\u7ea6\\u5b9a\\u7684\\u5de5\\u8d44\\u6807\\u51c6\\u652f\\u4ed8\\u52b3\\u52a8\\u8005\\u5de5\\u8d44\\u7684\\uff1b&nbsp;\\n\\uff086\\uff09\\u7532\\u65b9\\u672a\\u4f9d\\u6cd5\\u7f34\\u7eb3\\u793e\\u4f1a\\u4fdd\\u9669\\u8d39\\u7684\\uff1b&nbsp;\\n\\uff087\\uff09\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u89c4\\u5b9a\\u7684\\u5176\\u4ed6\\u60c5\\u5f62\\u3002&nbsp;\\n7\\u3001\\u9664\\u672c\\u6761\\u7b2c6\\u6b3e\\u89c4\\u5b9a\\u7684\\u60c5\\u5f62\\u5916\\uff0c\\u4e59\\u65b9\\u89e3\\u9664\\u672c\\u5408\\u540c\\u5e94\\u5f53\\u63d0\\u524d\\u4e09\\u5341\\u65e5\\u4ee5\\u4e66\\u9762\\u5f62\\u5f0f\\u901a\\u77e5\\u7532\\u65b9\\u3002&nbsp;\\n8\\u3001\\u7ecf\\u7532\\u4e59\\u53cc\\u65b9\\u534f\\u5546\\u4e00\\u81f4\\uff0c\\u672c\\u5408\\u540c\\u53ef\\u4ee5\\u89e3\\u9664\\u3002&nbsp;\\n9\\u3001\\u672c\\u5408\\u540c\\u671f\\u6ee1\\u6216\\u8005\\u7532\\u4e59\\u53cc\\u65b9\\u7ea6\\u5b9a\\u7684\\u7ec8\\u6b62\\u6761\\u4ef6\\u51fa\\u73b0\\uff0c\\u5e94\\u5f53\\u5373\\u884c\\u7ec8\\u6b62\\u3002\\u7531\\u4e8e\\u751f\\u4ea7\\uff08\\u5de5\\u4f5c\\uff09\\u9700\\u8981\\uff0c\\u7ecf\\u53cc\\u65b9\\u534f\\u5546\\u4e00\\u81f4\\uff0c\\u53ef\\u4ee5\\u7eed\\u8ba2\\u52b3\\u52a8\\u5408\\u540c\\u3002&nbsp;\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:24:22',
                'updated_at' => '2019-09-12 16:49:44',
            ),
            20 => 
            array (
                'id' => 24,
                'section_id' => 22,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1．甲乙任何一方违反本合同，给对方造成经济损失的，应当根据后果和责任大小，向对方支付赔偿金。&nbsp;2．乙方在合同期内，由甲方出资进行职业技术培训，当乙方在甲方未满约定服务年限解除合同时，甲方可按实际支付的培训费包括培训期间的工资）计收赔偿金，其标准为每服务一年递减实际支付的培训费总额的____填空____％。&nbsp;3．乙方违反本合同中保守商业秘密和技术秘密的约定，对甲方造成损失的，应当依法承担赔偿责任。&nbsp;4．因不可抗力造成本合同不能履行的，可以不承担法律责任。&nbsp;</p>',
                'formdata' => '["1\\uff0e\\u7532\\u4e59\\u4efb\\u4f55\\u4e00\\u65b9\\u8fdd\\u53cd\\u672c\\u5408\\u540c\\uff0c\\u7ed9\\u5bf9\\u65b9\\u9020\\u6210\\u7ecf\\u6d4e\\u635f\\u5931\\u7684\\uff0c\\u5e94\\u5f53\\u6839\\u636e\\u540e\\u679c\\u548c\\u8d23\\u4efb\\u5927\\u5c0f\\uff0c\\u5411\\u5bf9\\u65b9\\u652f\\u4ed8\\u8d54\\u507f\\u91d1\\u3002&nbsp;2\\uff0e\\u4e59\\u65b9\\u5728\\u5408\\u540c\\u671f\\u5185\\uff0c\\u7531\\u7532\\u65b9\\u51fa\\u8d44\\u8fdb\\u884c\\u804c\\u4e1a\\u6280\\u672f\\u57f9\\u8bad\\uff0c\\u5f53\\u4e59\\u65b9\\u5728\\u7532\\u65b9\\u672a\\u6ee1\\u7ea6\\u5b9a\\u670d\\u52a1\\u5e74\\u9650\\u89e3\\u9664\\u5408\\u540c\\u65f6\\uff0c\\u7532\\u65b9\\u53ef\\u6309\\u5b9e\\u9645\\u652f\\u4ed8\\u7684\\u57f9\\u8bad\\u8d39\\u5305\\u62ec\\u57f9\\u8bad\\u671f\\u95f4\\u7684\\u5de5\\u8d44\\uff09\\u8ba1\\u6536\\u8d54\\u507f\\u91d1\\uff0c\\u5176\\u6807\\u51c6\\u4e3a\\u6bcf\\u670d\\u52a1\\u4e00\\u5e74\\u9012\\u51cf\\u5b9e\\u9645\\u652f\\u4ed8\\u7684\\u57f9\\u8bad\\u8d39\\u603b\\u989d\\u7684",{"type":"input"},"\\uff05\\u3002&nbsp;3\\uff0e\\u4e59\\u65b9\\u8fdd\\u53cd\\u672c\\u5408\\u540c\\u4e2d\\u4fdd\\u5b88\\u5546\\u4e1a\\u79d8\\u5bc6\\u548c\\u6280\\u672f\\u79d8\\u5bc6\\u7684\\u7ea6\\u5b9a\\uff0c\\u5bf9\\u7532\\u65b9\\u9020\\u6210\\u635f\\u5931\\u7684\\uff0c\\u5e94\\u5f53\\u4f9d\\u6cd5\\u627f\\u62c5\\u8d54\\u507f\\u8d23\\u4efb\\u3002&nbsp;4\\uff0e\\u56e0\\u4e0d\\u53ef\\u6297\\u529b\\u9020\\u6210\\u672c\\u5408\\u540c\\u4e0d\\u80fd\\u5c65\\u884c\\u7684\\uff0c\\u53ef\\u4ee5\\u4e0d\\u627f\\u62c5\\u6cd5\\u5f8b\\u8d23\\u4efb\\u3002&nbsp;"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:27:31',
                'updated_at' => '2019-09-09 15:35:07',
            ),
            21 => 
            array (
                'id' => 25,
                'section_id' => 24,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>1、本合同在履行中发生争议，任何一方均可向企业劳动争议调解委员会申请调解，也可向劳动争议仲裁委员会申请仲裁。&nbsp;</p><p>2、本合同未尽事项，按国家有关法律法规执行。&nbsp;</p><p>3、本合同条款如与今后国家下达的法律法规相抵触时，以国家新的法律法规为准。&nbsp;</p><p>4、本合同依法订立，即具有法律效力，双方必须严格履行。&nbsp;</p><p>5、本合同一式两份，甲乙双方各执一份。&nbsp;</p>',
                'formdata' => '["1\\u3001\\u672c\\u5408\\u540c\\u5728\\u5c65\\u884c\\u4e2d\\u53d1\\u751f\\u4e89\\u8bae\\uff0c\\u4efb\\u4f55\\u4e00\\u65b9\\u5747\\u53ef\\u5411\\u4f01\\u4e1a\\u52b3\\u52a8\\u4e89\\u8bae\\u8c03\\u89e3\\u59d4\\u5458\\u4f1a\\u7533\\u8bf7\\u8c03\\u89e3\\uff0c\\u4e5f\\u53ef\\u5411\\u52b3\\u52a8\\u4e89\\u8bae\\u4ef2\\u88c1\\u59d4\\u5458\\u4f1a\\u7533\\u8bf7\\u4ef2\\u88c1\\u3002&nbsp;\\n2\\u3001\\u672c\\u5408\\u540c\\u672a\\u5c3d\\u4e8b\\u9879\\uff0c\\u6309\\u56fd\\u5bb6\\u6709\\u5173\\u6cd5\\u5f8b\\u6cd5\\u89c4\\u6267\\u884c\\u3002&nbsp;\\n3\\u3001\\u672c\\u5408\\u540c\\u6761\\u6b3e\\u5982\\u4e0e\\u4eca\\u540e\\u56fd\\u5bb6\\u4e0b\\u8fbe\\u7684\\u6cd5\\u5f8b\\u6cd5\\u89c4\\u76f8\\u62b5\\u89e6\\u65f6\\uff0c\\u4ee5\\u56fd\\u5bb6\\u65b0\\u7684\\u6cd5\\u5f8b\\u6cd5\\u89c4\\u4e3a\\u51c6\\u3002&nbsp;\\n4\\u3001\\u672c\\u5408\\u540c\\u4f9d\\u6cd5\\u8ba2\\u7acb\\uff0c\\u5373\\u5177\\u6709\\u6cd5\\u5f8b\\u6548\\u529b\\uff0c\\u53cc\\u65b9\\u5fc5\\u987b\\u4e25\\u683c\\u5c65\\u884c\\u3002&nbsp;\\n5\\u3001\\u672c\\u5408\\u540c\\u4e00\\u5f0f\\u4e24\\u4efd\\uff0c\\u7532\\u4e59\\u53cc\\u65b9\\u5404\\u6267\\u4e00\\u4efd\\u3002&nbsp;\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-06 15:31:27',
                'updated_at' => '2019-09-12 16:50:09',
            ),
            22 => 
            array (
                'id' => 26,
                'section_id' => 23,
                'catid' => 5,
                'players' => 2,
                'content' => '<p>____填空____。</p>',
                'formdata' => '["",{"type":"input"},"\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 15:30:33',
                'updated_at' => '2019-09-09 15:35:34',
            ),
            23 => 
            array (
                'id' => 27,
                'section_id' => 25,
                'catid' => 3,
                'players' => 2,
            'content' => '<p>1、名称：____填空____</p><p>2、品种：____填空____</p><p>3、规格：____填空____</p><p>4、质量：按照____填空____标准执行(须注明按国家标准或部颁或企业具体标准，如标准代号、编号和标准名称等)。</p>',
            'formdata' => '["1\\u3001\\u540d\\u79f0\\uff1a",{"type":"input"},"\\n2\\u3001\\u54c1\\u79cd\\uff1a",{"type":"input"},"\\n3\\u3001\\u89c4\\u683c\\uff1a",{"type":"input"},"\\n4\\u3001\\u8d28\\u91cf\\uff1a\\u6309\\u7167",{"type":"input"},"\\u6807\\u51c6\\u6267\\u884c(\\u987b\\u6ce8\\u660e\\u6309\\u56fd\\u5bb6\\u6807\\u51c6\\u6216\\u90e8\\u9881\\u6216\\u4f01\\u4e1a\\u5177\\u4f53\\u6807\\u51c6\\uff0c\\u5982\\u6807\\u51c6\\u4ee3\\u53f7\\u3001\\u7f16\\u53f7\\u548c\\u6807\\u51c6\\u540d\\u79f0\\u7b49)\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:07:09',
                'updated_at' => '2019-09-11 15:28:15',
            ),
            24 => 
            array (
                'id' => 28,
                'section_id' => 25,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>按照样本，____填空____。样本作为合同的附件（应注明样本封存及保管方式）。</p>',
                'formdata' => '["\\u6309\\u7167\\u6837\\u672c\\uff0c",{"type":"input"},"\\u3002\\u6837\\u672c\\u4f5c\\u4e3a\\u5408\\u540c\\u7684\\u9644\\u4ef6\\uff08\\u5e94\\u6ce8\\u660e\\u6837\\u672c\\u5c01\\u5b58\\u53ca\\u4fdd\\u7ba1\\u65b9\\u5f0f\\uff09\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:09:56',
                'updated_at' => '2019-09-09 17:09:56',
            ),
            25 => 
            array (
                'id' => 29,
                'section_id' => 25,
                'catid' => 3,
                'players' => 2,
            'content' => '<p>按双方商定要求执行，具体为：____填空____ (应具体约定产品质量要求)。</p>',
            'formdata' => '["\\u6309\\u53cc\\u65b9\\u5546\\u5b9a\\u8981\\u6c42\\u6267\\u884c\\uff0c\\u5177\\u4f53\\u4e3a\\uff1a",{"type":"input"}," (\\u5e94\\u5177\\u4f53\\u7ea6\\u5b9a\\u4ea7\\u54c1\\u8d28\\u91cf\\u8981\\u6c42)\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:10:43',
                'updated_at' => '2019-09-09 17:10:43',
            ),
            26 => 
            array (
                'id' => 30,
                'section_id' => 26,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>1、数量：____填空____</p><p>2、计量单位和方法：____填空____</p><p>3、交货数量的正负尾差、合理磅值、在途自然增减规定及计算方法：____填空____</p>',
                'formdata' => '["1\\u3001\\u6570\\u91cf\\uff1a",{"type":"input"},"\\n2\\u3001\\u8ba1\\u91cf\\u5355\\u4f4d\\u548c\\u65b9\\u6cd5\\uff1a",{"type":"input"},"\\n3\\u3001\\u4ea4\\u8d27\\u6570\\u91cf\\u7684\\u6b63\\u8d1f\\u5c3e\\u5dee\\u3001\\u5408\\u7406\\u78c5\\u503c\\u3001\\u5728\\u9014\\u81ea\\u7136\\u589e\\u51cf\\u89c4\\u5b9a\\u53ca\\u8ba1\\u7b97\\u65b9\\u6cd5\\uff1a",{"type":"input"},"\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:18:31',
                'updated_at' => '2019-09-11 15:26:11',
            ),
            27 => 
            array (
                'id' => 31,
                'section_id' => 27,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>____填空____。</p><p><br/></p>',
                'formdata' => '["",{"type":"input"},"\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:19:59',
                'updated_at' => '2019-09-09 17:19:59',
            ),
            28 => 
            array (
                'id' => 32,
                'section_id' => 28,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>1、交货时间：____填空____。</p><p>2、交货地点：____填空____。</p><p>3、运输方式：____填空____。</p><p>4、保险：____填空____。</p><p>5、与买卖相关的单证的转移：____填空____</p>',
                'formdata' => '["1\\u3001\\u4ea4\\u8d27\\u65f6\\u95f4\\uff1a",{"type":"input"},"\\u3002\\n2\\u3001\\u4ea4\\u8d27\\u5730\\u70b9\\uff1a",{"type":"input"},"\\u3002\\n3\\u3001\\u8fd0\\u8f93\\u65b9\\u5f0f\\uff1a",{"type":"input"},"\\u3002\\n4\\u3001\\u4fdd\\u9669\\uff1a",{"type":"input"},"\\u3002\\n5\\u3001\\u4e0e\\u4e70\\u5356\\u76f8\\u5173\\u7684\\u5355\\u8bc1\\u7684\\u8f6c\\u79fb\\uff1a",{"type":"input"},"\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:26:23',
                'updated_at' => '2019-09-11 15:26:25',
            ),
            29 => 
            array (
                'id' => 33,
                'section_id' => 29,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>验收时间：____填空____。</p>',
                'formdata' => '["\\u9a8c\\u6536\\u65f6\\u95f4\\uff1a",{"type":"input"},"\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:28:00',
                'updated_at' => '2019-09-09 17:28:00',
            ),
            30 => 
            array (
                'id' => 34,
                'section_id' => 30,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>货物在送达交货地点前的损失风险由____填空____承担，其后的损失风险由____填空____承担。</p>',
                'formdata' => '["\\u8d27\\u7269\\u5728\\u9001\\u8fbe\\u4ea4\\u8d27\\u5730\\u70b9\\u524d\\u7684\\u635f\\u5931\\u98ce\\u9669\\u7531",{"type":"input"},"\\u627f\\u62c5\\uff0c\\u5176\\u540e\\u7684\\u635f\\u5931\\u98ce\\u9669\\u7531",{"type":"input"},"\\u627f\\u62c5\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:33:26',
                'updated_at' => '2019-09-09 17:33:26',
            ),
            31 => 
            array (
                'id' => 35,
                'section_id' => 31,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>1、单价：____填空____。</p><p>2、总价：____填空____。</p><p>3、货款支付时间：____填空____。</p><p>4、货款的支付方式：____填空____。</p><p><br/></p>',
                'formdata' => '["1\\u3001\\u5355\\u4ef7\\uff1a",{"type":"input"},"\\u3002\\n2\\u3001\\u603b\\u4ef7\\uff1a",{"type":"input"},"\\u3002\\n3\\u3001\\u8d27\\u6b3e\\u652f\\u4ed8\\u65f6\\u95f4\\uff1a",{"type":"input"},"\\u3002\\n4\\u3001\\u8d27\\u6b3e\\u7684\\u652f\\u4ed8\\u65b9\\u5f0f\\uff1a",{"type":"input"},"\\u3002\\n\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:37:10',
                'updated_at' => '2019-09-11 15:26:32',
            ),
            32 => 
            array (
                'id' => 36,
                'section_id' => 32,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>1、乙方在验收中如发现货物的品种、型号、规格、花色和质量不合规定或约定，应在妥善保管货物的同时，自收到货物后 ____填空____日内向甲方提出书面的异议；乙方未及时提出异议的，视为货物合乎规定。</p><p><br/></p><p>2、乙方因使用、保管、保养不善等自身原因造成产品质量下降的，不得提出异议。</p><p><br/></p>',
                'formdata' => '["1\\u3001\\u4e59\\u65b9\\u5728\\u9a8c\\u6536\\u4e2d\\u5982\\u53d1\\u73b0\\u8d27\\u7269\\u7684\\u54c1\\u79cd\\u3001\\u578b\\u53f7\\u3001\\u89c4\\u683c\\u3001\\u82b1\\u8272\\u548c\\u8d28\\u91cf\\u4e0d\\u5408\\u89c4\\u5b9a\\u6216\\u7ea6\\u5b9a\\uff0c\\u5e94\\u5728\\u59a5\\u5584\\u4fdd\\u7ba1\\u8d27\\u7269\\u7684\\u540c\\u65f6\\uff0c\\u81ea\\u6536\\u5230\\u8d27\\u7269\\u540e ",{"type":"input"},"\\u65e5\\u5185\\u5411\\u7532\\u65b9\\u63d0\\u51fa\\u4e66\\u9762\\u7684\\u5f02\\u8bae\\uff1b\\u4e59\\u65b9\\u672a\\u53ca\\u65f6\\u63d0\\u51fa\\u5f02\\u8bae\\u7684\\uff0c\\u89c6\\u4e3a\\u8d27\\u7269\\u5408\\u4e4e\\u89c4\\u5b9a\\u3002\\n\\n2\\u3001\\u4e59\\u65b9\\u56e0\\u4f7f\\u7528\\u3001\\u4fdd\\u7ba1\\u3001\\u4fdd\\u517b\\u4e0d\\u5584\\u7b49\\u81ea\\u8eab\\u539f\\u56e0\\u9020\\u6210\\u4ea7\\u54c1\\u8d28\\u91cf\\u4e0b\\u964d\\u7684\\uff0c\\u4e0d\\u5f97\\u63d0\\u51fa\\u5f02\\u8bae\\u3002\\n\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:39:28',
                'updated_at' => '2019-09-11 15:26:42',
            ),
            33 => 
            array (
                'id' => 37,
                'section_id' => 33,
                'catid' => 3,
                'players' => 2,
            'content' => '<p>1、甲方违约责任</p><p><br/></p><p>（1）甲方不能交货的，则乙方有权解除合同，并有权要求甲方返还已支付的款项，乙方自愿放弃主张定金责任。</p><p><br/></p><p>（2）甲方所交货物的品种、型号、规格、花色、质量不符合约定的，乙方如同意利用货物，应按质论价；如乙方不能利用的，应依据具体情况，由甲方负责调换、修理、所产生的费用由甲方支付。</p><p><br/></p><p>2、乙方违约责任<br/></p><p><br/></p><p>（1）乙方若自提货物未按甲方通知的日期或合同约定的日期提货的，应以实际逾期提货天数，每日按货物总额的____填空____ %向甲方支付违约金。</p><p><br/></p><p>（2）乙方逾期付款的，应按逾期付款金额每日 ____填空____%计算，向甲方支付违约金或一次性支付违约金 。</p><p><br/></p><p>（3）甲方为维权而支出的所有费用(包含但不限于律师费、诉讼费用、交通费等)均由乙方承担。</p><p><br/></p>',
            'formdata' => '["1\\u3001\\u7532\\u65b9\\u8fdd\\u7ea6\\u8d23\\u4efb\\n\\n\\uff081\\uff09\\u7532\\u65b9\\u4e0d\\u80fd\\u4ea4\\u8d27\\u7684\\uff0c\\u5219\\u4e59\\u65b9\\u6709\\u6743\\u89e3\\u9664\\u5408\\u540c\\uff0c\\u5e76\\u6709\\u6743\\u8981\\u6c42\\u7532\\u65b9\\u8fd4\\u8fd8\\u5df2\\u652f\\u4ed8\\u7684\\u6b3e\\u9879\\uff0c\\u4e59\\u65b9\\u81ea\\u613f\\u653e\\u5f03\\u4e3b\\u5f20\\u5b9a\\u91d1\\u8d23\\u4efb\\u3002\\n\\n\\uff082\\uff09\\u7532\\u65b9\\u6240\\u4ea4\\u8d27\\u7269\\u7684\\u54c1\\u79cd\\u3001\\u578b\\u53f7\\u3001\\u89c4\\u683c\\u3001\\u82b1\\u8272\\u3001\\u8d28\\u91cf\\u4e0d\\u7b26\\u5408\\u7ea6\\u5b9a\\u7684\\uff0c\\u4e59\\u65b9\\u5982\\u540c\\u610f\\u5229\\u7528\\u8d27\\u7269\\uff0c\\u5e94\\u6309\\u8d28\\u8bba\\u4ef7\\uff1b\\u5982\\u4e59\\u65b9\\u4e0d\\u80fd\\u5229\\u7528\\u7684\\uff0c\\u5e94\\u4f9d\\u636e\\u5177\\u4f53\\u60c5\\u51b5\\uff0c\\u7531\\u7532\\u65b9\\u8d1f\\u8d23\\u8c03\\u6362\\u3001\\u4fee\\u7406\\u3001\\u6240\\u4ea7\\u751f\\u7684\\u8d39\\u7528\\u7531\\u7532\\u65b9\\u652f\\u4ed8\\u3002\\n\\n2\\u3001\\u4e59\\u65b9\\u8fdd\\u7ea6\\u8d23\\u4efb\\n\\n\\uff081\\uff09\\u4e59\\u65b9\\u82e5\\u81ea\\u63d0\\u8d27\\u7269\\u672a\\u6309\\u7532\\u65b9\\u901a\\u77e5\\u7684\\u65e5\\u671f\\u6216\\u5408\\u540c\\u7ea6\\u5b9a\\u7684\\u65e5\\u671f\\u63d0\\u8d27\\u7684\\uff0c\\u5e94\\u4ee5\\u5b9e\\u9645\\u903e\\u671f\\u63d0\\u8d27\\u5929\\u6570\\uff0c\\u6bcf\\u65e5\\u6309\\u8d27\\u7269\\u603b\\u989d\\u7684",{"type":"input"}," %\\u5411\\u7532\\u65b9\\u652f\\u4ed8\\u8fdd\\u7ea6\\u91d1\\u3002\\n\\n\\uff082\\uff09\\u4e59\\u65b9\\u903e\\u671f\\u4ed8\\u6b3e\\u7684\\uff0c\\u5e94\\u6309\\u903e\\u671f\\u4ed8\\u6b3e\\u91d1\\u989d\\u6bcf\\u65e5 ",{"type":"input"},"%\\u8ba1\\u7b97\\uff0c\\u5411\\u7532\\u65b9\\u652f\\u4ed8\\u8fdd\\u7ea6\\u91d1\\u6216\\u4e00\\u6b21\\u6027\\u652f\\u4ed8\\u8fdd\\u7ea6\\u91d1 \\u3002\\n\\n\\uff083\\uff09\\u7532\\u65b9\\u4e3a\\u7ef4\\u6743\\u800c\\u652f\\u51fa\\u7684\\u6240\\u6709\\u8d39\\u7528(\\u5305\\u542b\\u4f46\\u4e0d\\u9650\\u4e8e\\u5f8b\\u5e08\\u8d39\\u3001\\u8bc9\\u8bbc\\u8d39\\u7528\\u3001\\u4ea4\\u901a\\u8d39\\u7b49)\\u5747\\u7531\\u4e59\\u65b9\\u627f\\u62c5\\u3002\\n\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:42:39',
                'updated_at' => '2019-09-11 15:26:49',
            ),
            34 => 
            array (
                'id' => 38,
                'section_id' => 34,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>本合同在履行过程中发生争议，由双方当事人协商解决，协商不成的由____填空____所在地人民法院处理。</p>',
                'formdata' => '["\\u672c\\u5408\\u540c\\u5728\\u5c65\\u884c\\u8fc7\\u7a0b\\u4e2d\\u53d1\\u751f\\u4e89\\u8bae\\uff0c\\u7531\\u53cc\\u65b9\\u5f53\\u4e8b\\u4eba\\u534f\\u5546\\u89e3\\u51b3\\uff0c\\u534f\\u5546\\u4e0d\\u6210\\u7684\\u7531",{"type":"input"},"\\u6240\\u5728\\u5730\\u4eba\\u6c11\\u6cd5\\u9662\\u5904\\u7406\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:44:27',
                'updated_at' => '2019-09-09 17:44:27',
            ),
            35 => 
            array (
                'id' => 39,
                'section_id' => 35,
                'catid' => 3,
                'players' => 2,
                'content' => '<p>本合同未尽事宜，依照有关法律、法规执行，甲乙双方也可达成补充协议。补充协议具有同等的法律效力。</p><p><br/></p>',
                'formdata' => '["\\u672c\\u5408\\u540c\\u672a\\u5c3d\\u4e8b\\u5b9c\\uff0c\\u4f9d\\u7167\\u6709\\u5173\\u6cd5\\u5f8b\\u3001\\u6cd5\\u89c4\\u6267\\u884c\\uff0c\\u7532\\u4e59\\u53cc\\u65b9\\u4e5f\\u53ef\\u8fbe\\u6210\\u8865\\u5145\\u534f\\u8bae\\u3002\\u8865\\u5145\\u534f\\u8bae\\u5177\\u6709\\u540c\\u7b49\\u7684\\u6cd5\\u5f8b\\u6548\\u529b\\u3002"]',
                'listorder' => 0,
                'created_at' => '2019-09-09 17:45:40',
                'updated_at' => '2019-09-09 17:45:40',
            ),
            36 => 
            array (
                'id' => 40,
                'section_id' => 1,
                'catid' => 1,
                'players' => 2,
                'content' => '<p>日租金____填空____元, 水费____填空____元/吨, 电费____填空____元/度, 物业费____填空____元/年, 已缴清。</p>',
                'formdata' => '["\\u65e5\\u79df\\u91d1",{"type":"input"},"\\u5143, \\u6c34\\u8d39",{"type":"input"},"\\u5143\\/\\u5428, \\u7535\\u8d39",{"type":"input"},"\\u5143\\/\\u5ea6, \\u7269\\u4e1a\\u8d39",{"type":"input"},"\\u5143\\/\\u5e74, \\u5df2\\u7f34\\u6e05\\u3002\\n"]',
                'listorder' => 0,
                'created_at' => '2019-09-16 17:16:45',
                'updated_at' => '2019-09-16 17:16:45',
            ),
        ));
        
        
    }
}