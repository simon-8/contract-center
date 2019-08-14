@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>快递费用管理</h5>
        </div>
        <div class="ibox-content">
            <form action="{{ route('admin.express-fee.store') }}" method="POST">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">更新</button>
            </div>
            <div class="row fee-box">
                {{ csrf_field() }}
                @foreach ($lists as $k => $v)
                    <div class="col-sm-6 col-lg-2">
                        <div class="input-group m-b">
                            <span class="input-group-addon">{{ $v->name }}</span>
                            <input type="number" class="form-control" min="0" name="fee[{{$v->id}}]" value="{{ $v->amount }}" autocomplete="off">
                        </div>
                    </div>
                @endforeach
            </div>
            </form>
        </div>
    </div>
</div>
<style>
    .fee-box .form-control {
        width: 80px;
    }
</style>
@endsection
