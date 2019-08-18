{{--@inject('contractTplFill', 'App\Models\ContractTplFill')--}}
{{--@inject('contractTplRule', 'App\Models\ContractTplRule')--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title></title>

    <style>
        * {
            padding: 0;
            margin: 0;
        }
        .clearfix {
            clear: both;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .container {
            width: 794px;
            /*border: 1px solid red;*/
        }
        .container .main p {
            text-indent: 2em;
            padding: 5px 0;
        }
        .container .main .head .title {
            font-size: 22px;
        }
        .container .main .head div {
            padding: 5px 0;
        }
        .container .main .rules {
            margin: 15px 0 0 0;
        }
        .container .main .agree {
            margin: 15px 0 0 0;
        }
        .fill-value {
            text-decoration: underline;
        }
        .footer {
            margin: 100px 0 0 0;
            width: 100%;
            display: flex;
            flex-wrap: warp;
            justify-content: center;
            overflow: hidden;
        }
        .footer div p {
            text-indent: 2em;
            padding: 5px 0;
        }
        .col-4 {
            float: left;
            width: 33.33%;
        }
        .col-6 {
            float: left;
            width: 50%;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="main">
        <div class="head">
            <div class="title text-center">
                {{ $contract->getCatText() }}
            </div>
            <div class="name text-right">
                {{ $contract->name }}
            </div>
        </div>

        <div class="sections">
            @foreach ($sections as $k => $section)
                <h6>{{ $k+1 }}. {{ $section['name'] }}</h6>
                @foreach ($section['contract_tpl'] as $tpl)
                <p>
                    @foreach ($tpl['formdata'] as $formKey => $formItem)
                        @if (is_array($formItem))
                            <span class="fill-value">
                                {{ $fill[$section['id']][$tpl['id']][$formKey] ?? ''}}
                            </span>
                        @else
                            {{ str_replace('&nbsp;', ' ', $formItem) }}
                        @endif
                    @endforeach
                </p>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="footer">
        <div class="@if($contract->players == $contract::PLAYERS_TWO) col-6 @else col-4 @endif">
            <p>甲方签章：</p>
            <p>电话：<span class="fill-value">{{ $contract->userFirst->mobile ?? '/' }}</span></p>
            <p>
                {{ date('Y', strtotime($contract->confirm_at)) }} 年
                {{ date('m', strtotime($contract->confirm_at)) }} 月
                {{ date('d', strtotime($contract->confirm_at)) }} 日
            </p>
        </div>
        <div class="@if($contract->players == $contract::PLAYERS_TWO) col-6 @else col-4 @endif">
            <p>乙方签章：</p>
            <p>电话：<span class="fill-value">{{ $contract->userSecond->mobile ?? '/' }}</span></p>
            <p>
                {{ date('Y', strtotime($contract->confirm_at)) }} 年
                {{ date('m', strtotime($contract->confirm_at)) }} 月
                {{ date('d', strtotime($contract->confirm_at)) }} 日
            </p>
        </div>
        @if($contract->players == $contract::PLAYERS_THREE)
        <div class="col-4">
            <p>居间人签章：</p>
            <p>电话：<span class="fill-value">{{ $contract->userThree->mobile ?? '/' }}</span></p>
            <p>
                {{ date('Y', strtotime($contract->confirm_at)) }} 年
                {{ date('m', strtotime($contract->confirm_at)) }} 月
                {{ date('d', strtotime($contract->confirm_at)) }} 日
            </p>
        </div>
        @endif
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
</body>
</html>
