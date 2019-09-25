<?php

use Illuminate\Database\Seeder;

class SinglePageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('single_page')->delete();
        
        \DB::table('single_page')->insert(array (
            0 => 
            array (
                'id' => 1,
                'catid' => 0,
                'title' => '关于我们',
                'thumb' => 'http://blog.cc/admin/images/nopic.png',
            'content' => '<p><img src="/uploads/images/201908/21/1566351654394913.jpeg" title="1566351654394913.jpeg" alt="dbb44aed2e738bd497ac4b447090d7d3267ff9d3.jpeg"/></p><p>今年4月，湖南省的一个展览会上展出了北斗卫星导航系统的模型。</p><p>网易科技讯8月20日消息，据《日本经济新闻》报道，中国北斗卫星导航系统在规模上已经超过美国的全球定位系统(Global Positioning System，简称GPS)，这一转变对于高科技产业可能会产生巨大影响。</p><p>美国长期以来一直是全球卫星定位系统的领导者。相比之下，中国在该领域直到近些年才进入人们的视野，在2000年才发射了第一颗定位卫星。</p><p>基于卫星的定位系统是构建各种定位服务的基础——从智能手机游戏到紧急通知系统，一切都利用了位置数据。这些系统还支持飞机和船只导航，同时让大型农业和采矿机械的远程操作得以实现极高的精确度。</p><p>据欧洲全球导航卫星系统局估计，到2020年，设备和位置数据服务市场规模将达到1800亿欧元(约合1900亿美元)，在使用的接收器将达到80亿个，因而卫星将成为一个国家工业竞争力的重要组成部分。</p><p><br/></p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-06-04 15:47:19',
                'updated_at' => '2019-08-21 09:41:34',
            ),
            1 => 
            array (
                'id' => 2,
                'catid' => 0,
                'title' => '使用指导 - 图片指导',
                'thumb' => 'http://blog.cc/admin/images/nopic.png',
                'content' => '<h1></h1><h1 style="text-align: left;">云证合同使用说明书</h1><p style="text-align: left;">云证合同是一款方便用户线上签订合同的微信小程序，为用户提供租赁、借贷等多种合同类型。并且为会员用户定制专属合同文本，一键进入自己的专属合同。</p><p style="text-align: left;"><strong><br/></strong></p><p style="text-align: left;"><strong>使用步骤：</strong></p><p style="text-align: left;"><strong>第一步</strong> &nbsp;微信小程序搜索“云证合同”进入小程序首页，点击右下角“个人中心”完成实名认证。</p><p style="text-align: left;">根据需求选择个人认证或者公司认证。</p><p style="text-align:center"><img src="/uploads/images/201909/05/1567649555502317.jpg" title="1567649555502317.jpg" alt="1567649555502317.jpg" width="100" height="150"/></p><p><br/></p><p><br/></p><p><img src="/uploads/images/201909/05/1567649859889508.jpg" title="1567649859889508.jpg" alt="2.jpg" width="393" height="282"/></p><p><br/></p><p><strong>第二步</strong> &nbsp;完成实名认证后返回首页，点击“创建合同”，根据需求选择合适的合同类型，按照实际情况填写合同必填内容。</p><p>点击“切换”可以更换另一种文本。填写完毕点击最下方“预览”查看合同文本，需要再次修改合同点击下方“返回”；合同无误点击“保存”。</p><p><br/></p><p><br/></p><p><img src="/uploads/images/201909/05/1567650146428405.jpg" title="1567650146428405.jpg" alt="3.jpg" width="285" height="411"/></p><p><img src="/uploads/images/201909/05/1567650441128413.jpg" title="1567650441128413.jpg" alt="4.jpg" width="269" height="529"/></p><p><img src="/uploads/images/201909/05/1567650610596790.jpg" title="1567650610596790.jpg" alt="5.jpg" width="266" height="536"/></p><p><br/></p><p><br/></p><p><strong>第三步 </strong>&nbsp;保存合同后，点击“资料”可以上传有关合同的图片、视频资料。没有上传资料可以跳过。点击“查看”或者“确认”可以查看合同内容，需要修改合同点击“编辑”，确认合同无误后点击“确认”。</p><p><img src="/uploads/images/201909/05/1567650937554524.jpg" title="1567650937554524.jpg" alt="6.jpg" width="285" height="614"/></p><p><img src="/uploads/images/201909/05/1567651114600057.jpg" title="1567651114600057.jpg" alt="7.jpg" width="286" height="456"/></p><p><br/></p><p><img src="/uploads/images/201909/05/1567651280170996.jpg" title="1567651280170996.jpg" alt="8.jpg" width="279" height="436"/></p><p><br/></p><p><br/></p><p><strong>第四步</strong> &nbsp;点击“确认”进入合同界面，点击最下方“发送”，将合同发送给另一方当事人。返回上一页面，待对方确认支付费用后签名。也可以待对方确认后己方支付费用后签名。签名保存后填写手机验证码。</p><p><img src="/uploads/images/201909/05/1567651435388395.jpg" title="1567651435388395.jpg" alt="9.jpg" width="284" height="567"/></p><p><img src="/uploads/images/201909/05/1567651581508969.jpg" title="1567651581508969.jpg" alt="10.jpg" width="275" height="389"/></p><p><img src="/uploads/images/201909/05/1567651784758037.jpg" title="1567651784758037.jpg" alt="11.jpg" width="273" height="442"/></p><p><strong>第五步</strong> &nbsp;收到对方发送的合同后，点击“编辑”对合同进行填写或修改，然后点击“确认”并支付签名认证费，可以确认后待对方支付费用后签名。签名保存后填写手机验证码 。</p><p>&nbsp;</p><p><strong>第六步</strong> &nbsp;合同签订完毕后可以点击“PDF”，导出合同文本进行纸质打印。</p><p><img src="/uploads/images/201909/05/1567652010502172.jpg" title="1567652010502172.jpg" alt="1567652010502172.jpg" width="295" height="500"/></p><p><br/></p><p><img src="/uploads/images/201909/05/1567652106774277.jpg" title="1567652106774277.jpg" alt="1567652106774277.jpg" width="364" height="591"/></p><p><strong>第七步</strong>：双方签完合同后需要律师见证服务，可以点击“律师见证”，点击“收货地址”，点击左下方“+”输入收货人信息后保存，点击“立即申请”。</p><p><img src="/uploads/images/201909/05/1567652247682292.jpg" title="1567652247682292.jpg" alt="1567652247682292.jpg" width="328" height="520"/></p><p><br/></p><p><br/></p><p><img src="/uploads/images/201909/05/1567652307317512.jpg" title="1567652307317512.jpg" alt="1567652307317512.jpg" width="362" height="520"/></p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-07-08 15:54:06',
                'updated_at' => '2019-09-06 17:10:25',
            ),
            2 => 
            array (
                'id' => 3,
                'catid' => 0,
                'title' => '使用指导 - 视频指导',
                'thumb' => 'http://blog.cc/admin/images/nopic.png',
                'content' => '<p><video class="edui-upload-video  vjs-default-skin video-js" controls="" preload="none" width="420" height="280" src="/uploads/videos/201907/12/1562909945624880.mp4" data-setup="{}"></video></p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-07-08 16:51:40',
                'updated_at' => '2019-07-12 13:39:10',
            ),
            3 => 
            array (
                'id' => 4,
                'catid' => 0,
                'title' => '律师见证说明',
                'thumb' => 'https://contract.simon8.com/admin/images/nopic.png',
                'content' => '<p>律师见证:是指律师事务所接受当事人的委托或申请，指派具有律师资格或法律职业资格，并有律师执业证书的律师， 以律师事务所和见证律师的名义，就有关的法律行为或法律事实的真实性谨慎审查证明的一种律师非诉讼业务活动。<br/></p><h3>目的作用</h3><p>一、见证某一法律行为或法律事实的真实性；</p><p>二、见证某一法律行为或法律事实的合法性。</p><p>从法律属性上看，在我国律师见证仍属于“私证”，依法必须查证属实，才能作为认定事实的根据，不同于公证的证明力，公证书一般可直接作为证据使用。</p><p><a></a><a></a><a></a><a></a></p><h3>法律原则</h3><p>第一、律师见证应首先严格审查核实当事人的主体资格；</p><p>见证律师在对合同各方当事人的主体身份进行调查和认证时，应主动去查明当事人的真实身份，仅以当事人自行提供的材料作为认定主体资格的依据远远不够，还要查明自然人或法人的真实身份，其权利能力和行为能力；代理人的代理资格、代理权限；当事人的资信状况、履约能力以及合同履行的可行性。对企业来说，应当调查企业的工商登记、税务登记、外贸许可、特许经营、产品标准、专利商标等等，对相关的证据和材料，还应当到有关部门进行必要的调查核实。</p><p>第二、律师见证还应勤勉尽责、严格审查核实见证事项的真实性；</p><p>从律师见证的目的看，见证不仅仅是对行为的见证，如，律师只对合同签字及盖章行为的真实性做见证，并不对双方合同的内容做见证，这样，律师做为法律服务职业的专有属性就不能得到体现，律师见证也就失去了应有的法律意义！律师见证之所以不同于普通公民的作证，主要体现在见证律师负有对见证事项合法性审查的义务。</p><p>第三、律师见证的法律文书既要符合法定的实质要件；也要符合法定的形式要件;</p><p>如，进行合同见证要查明当事人提交材料的真实性，确定意思表示要真实、明确，无欺诈、胁迫、乘人之危和重大误解的情形。</p><p>第四、律师见证应坚持回避原则，不宜以律师执业身份为自己的亲友作见证；</p><p>第五、律师见证应坚持自愿、公平、直接和客观的原则；</p><p>第六、律师对法定的强制公证事项不得见证；</p><p>第七、律师见证业务程序要完备，见证书内容要符合要求。</p><p>第八、律师见证必须坚持在法律事实或法律行为发生时亲眼所见的原则。对于已经发生或者将要发生的事情，律师都不能见证，这是律师见证在时间上和空间上区别于公证的限制。</p><p><br/></p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-07-11 10:25:58',
                'updated_at' => '2019-09-06 16:17:39',
            ),
            4 => 
            array (
                'id' => 5,
                'catid' => 0,
                'title' => '服务协议',
                'thumb' => '',
                'content' => '<p>服务协议服务协议服务协议服务协议服务协议服务协议服务协议服务协议</p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-09-06 08:50:30',
                'updated_at' => '2019-09-06 08:50:30',
            ),
            5 => 
            array (
                'id' => 6,
                'catid' => 0,
                'title' => '使用说明',
                'thumb' => 'https://contract.simon8.com/admin/images/nopic.png',
                'content' => '<p style="white-space: normal;">云证合同是一款方便用户线上签订合同的微信小程序，为用户提供租赁、借贷等多种合同类型。并且为会员用户定制专属合同文本，一键进入自己的专属合同。</p><p><br/></p>',
                'adminid' => 0,
                'comment' => 0,
                'zan' => 0,
                'hits' => 0,
                'is_md' => 0,
                'status' => 1,
                'created_at' => '2019-09-06 17:03:13',
                'updated_at' => '2019-09-10 10:55:19',
            ),
        ));
        
        
    }
}