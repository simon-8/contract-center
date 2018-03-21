<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>幸运大抽奖</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ skin_path('/') }}lottery/css/chou.css">
</head>
<body>
<div class="CoverImage FlexEmbed FlexEmbed--3by1" id="app">
    <div class="warsper">
        <div class="chouconten flex-juscenter-dir">
            <div class="tops flex-jusbetween">
                <div class="lefts flex-juscenter-dir bordeall">
                    <div class="canshus">
                        <img src="{{ skin_path('/') }}lottery/images/canshu.png">
                    </div>
                    <div class="tites">选择奖项</div>
                    <div class="ipts">
                        <div class="selects">
                            <span>--</span>
                            <span class="choicesa">@{{ giftName }}</span>
                            <span>--</span>
                        </div>
                        <div class="posiab animated fadeInDown">
                            <div class="seclitem">
                                <p class="havechoice"><span>--</span><span>请选择</span><span>--</span></p>
                                <div class="jiangxiang">
                                    @foreach ($activity->Gift as $gift)
                                    <p class="jiangname" @click="chooseGift" data-id="{{ $gift->id }}">{{ $gift->name }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tites">抽取人数</div>
                    <div class="nums flex-jusbetween">
                        <p class="decade"></p>
                        <input type="number" class="number" :value="giftNumber">
                        <p class="plus"></p>
                    </div>
                    <div class="chous">
                        <p class="beginchou" @click="doLottery"></p>
                    </div>
                    <div class="canyu">
                        参与人数<span>{{ $activity->actor }}</span>
                    </div>
                </div>
                <div class="rights bordeall">
                    <div class="right-top flex-jusstart">
                        <p class="pricename">奖品名称</p>
                        <div class="turnaround">
                            <img src="{{ skin_path('/') }}lottery/images/zhuan.gif">
                            <div class="propic">
                                <img src="{{ skin_path('/') }}lottery/images/BIicon.png">
                            </div>
                        </div>
                        <div class="nammobile">
                            <p class="shinetop"></p>
                            <div class="swiper_wrap">
                                <ul class="font_inner">
                                    @foreach ($activity->LotteryApply as $apply)
                                    <li>
                                        <div class="namesmo">
                                            <p>{{ $apply->truename }}</p><p>{{ $apply->mobile }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <p class="shinebottom"></p>
                        </div>
                    </div>
                    <div class="tits">
                        <img src="{{ skin_path('/') }}lottery/images/huojiang.png">
                    </div>
                    <div class="right-bottom flex-juscenter">
                        @foreach ($activity->Lottery as $lottery)
                        <p><span class="moumou">{{ $lottery->Apply->truename }}</span></p>
                        <p class="middles">{{ $lottery->Apply->mobile }}</p>
                        <p class="moumou">{{ $lottery->gname }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="bottoms flex-jusbetween">
                <div class="leftlogo mar20">
                    <img src="{{ skin_path('/') }}lottery/images/huoshu.png" alt="火树科技logo">
                </div>
                <div class="bingzhong bordeall border-radius mar20">
                    <div class="tupics flex-jusstart">
                        <img src="{{ skin_path('/') }}lottery/images/danbing.png">
                        <p>单病种控费</p>
                    </div>
                    <div class="anyfonts">
                        以地区医保政策为核心，通过数据中心搭建数据模型，实现对在院患者费用监控。形成以病种为核心，从病区、科室、医生组多个维度分析数据，构建以医院实际临床现状为主的临床路径。
                    </div>
                </div>
                <div class="bingzhong bordeall border-radius mar20">
                    <div class="tupics flex-jusstart">
                        <img src="{{ skin_path('/') }}lottery/images/yishu.png" alt="">
                        <p>医院数据中心（医数）</p>
                    </div>
                    <div class="anyfonts">
                        构建以患者为中心的医院数据应用平台，具有安全、透明、可及三大特点，解决医院长期以来数据利用率偏低的现状。加强医院数据的管控能力，为医教患管研多方面提供数据应用支撑。
                    </div>
                </div>
                <div class="bingzhong bordeall border-radius">
                    <div class="tupics flex-jusstart">
                        <img src="{{ skin_path('/') }}lottery/images/BIicon.png" alt="">
                        <p>BI决策分析</p>
                    </div>
                    <div class="anyfonts">
                        通过拖拽方式及可视化建模技术，摆脱传统数据分析的制约。业务人员可以基于过程逻辑，拖拽可视化控件实现数据的建模。同时通过权限的控制，能够实现数据分析工作下放到科室的目标。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
<script src="https://cdn.bootcss.com/vue-resource/1.5.0/vue-resource.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
<script src="{{ skin_path('/') }}lottery/js/index.js" type="text/javascript"></script>
<script type="text/javascript">
    var app = new Vue({
        el: '#app',
        data: {
            baseURL: '/',
            api: {
                doLottery: 'api/activity/dolottery'
            },
            giftName: '请选择',
            giftID: 0,
            giftNumber: 1,
            aid: '{{ $activity->id }}'
        },
        methods: {
            getAPI: function(name) {
                var api = this.api[name] ? this.api[name] : null;
                if (api === null) throw Error('API not Found!');
                if (arguments.length > 1) {
                    for (i = 1; i < arguments.length; i++) {
                        api = api.replace('{param}', arguments[i]);
                    }
                }
                return this.baseURL + api;
            },
            chooseGift: function(e) {
                var elm = e.target;
                this.giftName = elm.innerHTML;
                this.giftID = elm.getAttribute('data-id');
            },
            doLottery: function() {
                if (this.giftID < 1) {
                    layer.alert('请选择奖品');
                    return false;
                }
                var data = {
                    aid: this.aid,
                    giftID: this.giftID,
                    giftNumber: $('.number').val()
                };
                //var loading = layer.load();
                this.$http.post(this.getAPI('doLottery'), data).then(function(result) {
                    var data = result.data,
                        names = '',
                        gname = ''; // array
                    for (i in data) {
                        names += data[i].truename;
                        gname = data[i].gname;
                    }
                    layer.alert('恭喜 ' + names + ' 获得'+ gname, function(e) {
                        // todo
                        window.location.reload();
                        layer.close(e);
                    });
                }).catch(function(result) {
                    layer.alert(JSON.stringify(result), function(e) {
                        layer.close(e);
                    });
                });
            }
        },
        created: function() {

        },
        mounted: function() {

        }
    })
</script>
</html>