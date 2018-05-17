@extends('layout.admin')
@section('content')

<div class="col-sm-12 animated fadeInDown">

    <div class="middle-box text-center">
        <div class="alert alert-danger">
            <h2 class="font-bold">您没有权限使用此功能...</h2>
        </div>

        <div class="error-desc">
             <br>请联系您的系统管理员获取使用权限。 <br>
        </div>
    </div>
</div>

@endsection('content')