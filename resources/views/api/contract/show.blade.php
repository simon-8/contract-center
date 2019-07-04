@inject('contractTplFill', 'App\Models\ContractTplFill')
@inject('contractTplRule', 'App\Models\ContractTplRule')
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
        .container {
            width: 794px;
            /*border: 1px solid red;*/
        }
        .container .main p {
            text-indent: 2em;
            padding: 5px 0;
        }
        .container .main .rules {
            margin: 30px 0 0 0;
        }
        .fill-value {
            text-decoration: underline;
        }
        .footer {
            margin: 100px 0 0 0;
        }
        .footer .left, .footer .right {
            float: left;
            width:50%;
        }
        .footer .left p, .footer .right p {
            text-indent: 2em;
            padding: 5px 0;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="main">
        <p class="text-center"><strong>{{ $contract->name }}</strong><br></p>

        <div class="fills">
            @foreach($contractTplFill->ofCatid([0, $contract->catid])->get() as $k => $v)
                <p>
                    {{ $v->content }}: <span class="fill-value">{{ $contract->content['fills'][$v->formname] ?: '/' }}</span>
                </p>
            @endforeach
        </div>

        <div class="rules">
            @php
                $i = 1;
            @endphp
            @foreach($contractTplRule->ofCatid([0, $contract->catid])->get() as $k => $v)
                @if (in_array($v->id, $contract->content['rules']))
                    <p>
                        {{ $i++ }}. {{ $v->content }}
                    </p>
                @endif
            @endforeach
        </div>
    </div>

    <div class="footer">
        <div class="left">
            <p>甲方签章：</p>
            <p>电话：<span class="fill-value">{{ $contract->user->mobile }}</span></p>
            <p>
                {{ date('Y', strtotime($contract->confirm_at)) }} 年
                {{ date('m', strtotime($contract->confirm_at)) }} 月
                {{ date('d', strtotime($contract->confirm_at)) }} 日
            </p>
        </div>
        <div class="right">
            <p>乙方签章：</p>
            <p>电话：<span class="fill-value">{{ $contract->target->mobile }}</span></p>
            <p>
                {{ date('Y', strtotime($contract->confirm_at)) }} 年
                {{ date('m', strtotime($contract->confirm_at)) }} 月
                {{ date('d', strtotime($contract->confirm_at)) }} 日
            </p>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
</div>
</body>
</body>
</html>