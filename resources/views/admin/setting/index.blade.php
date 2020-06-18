@extends('layout.admin')
@section('navbar')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>
        首页 <span class="c-gray en">&gt;</span>
        系统设置 <span class="c-gray en">&gt;</span>
        基本设置
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
@endsection

@section('content')
    <div class="col-sm-12 col-md-6 animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>基本设置</h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('admin.setting.update') }}" method="POST" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">合同价格</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="data[contractPrice]" value="{{ $setting['contractPrice'] ?? 0 }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">律师见证价格</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="律师见证价格" name="data[contractLawyerConfirmPrice]" id="contractLawyerConfirmPrice" class="form-control" value="{{ $setting['contractLawyerConfirmPrice'] ?? 0 }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">合同有效期(年)</label>
                        <div class="col-sm-10">
                            <input type="number" placeholder="合同有效期(年)" name="data[contractExpiredYear]" id="contractExpiredYear" class="form-control" value="{{ $setting['contractExpiredYear'] ?? 0 }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">管理员手机</label>
                        <div class="col-sm-10">
                            <input type="number" placeholder="管理员手机号码" name="data[adminMobile]" id="adminMobile" class="form-control" value="{{ $setting['adminMobile'] ?? '' }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <button class="btn btn-white no-margins" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>
@endsection
