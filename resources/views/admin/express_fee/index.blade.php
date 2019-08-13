@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>快递费用管理</h5>
        </div>
        <div class="ibox-content">
            @foreach ($lists as $k => $v)
            <div class="col-sm-6 col-lg-2">
                <input type="number" class="form-control" name="" value="{{ $v['amount'] }}">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
