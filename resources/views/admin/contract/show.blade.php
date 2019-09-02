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
            margin: 0 auto;
            /*border: 1px solid red;*/
        }
        .container .main .sections {
            text-indent: 2em;
            padding: 5px 0;
        }
        .container .main .section {
            padding: 5px 0;
        }
        .container .main .section p {
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
                {{ __('contract.number', ['id' => $contract->id]) }}
            </div>
        </div>

        <div class="sections">
            <div class="section" style="margin-bottom: 20px;">
                <p>
                    甲方:  <span class="fill-value">{{ $contract->jiafang }}</span>
                </p>
                <p>
                    乙方:  <span class="fill-value">{{ $contract->yifang }}</span>
                </p>
                @if($contract->players == $contract::PLAYERS_THREE)
                    <p>
                        居间人:  <span class="fill-value">{{ $contract->jujianren }}</span>
                    </p>
                @endif
            </div>
            @foreach ($sections as $k => $section)
                <div class="section">
                    <h4>{{ $k+1 }}. {{ $section['name'] }}</h4>
                    @foreach ($section['contract_tpl'] as $tpl)
                        <p>
                            @foreach ($tpl['formdata'] as $formKey => $formItem)
                                @if (is_array($formItem))
                                    <span class="fill-value">
                                    @if (empty($fill[$section['id']][$tpl['id']][$formKey]))
                                            &nbsp;/&nbsp;
                                        @else
                                            {{ $fill[$section['id']][$tpl['id']][$formKey] }}
                                        @endif
                                    </span>
                                @else
                                    {{ str_replace('&nbsp;', ' ', $formItem) }}
                                @endif
                            @endforeach
                        </p>
                    @endforeach
                </div>
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
            <p>乙方签章：<span class="fill-value">{{ $contract->userSecond->mobile ?? '/' }}</span></p>
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
