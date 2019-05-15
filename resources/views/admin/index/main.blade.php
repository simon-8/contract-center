@extends('layout.admin')
@section('content')
    <div class="container">
        <div class="alert alert-success alert-dismissable" id="MessageBox">
            欢迎登录
        </div>
        <table class="table table-border table-bordered table-bg bg-white mt-20">
            <thead>
            <tr>
                <th colspan="2" scope="col">服务器信息</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($envs as $env)
                <tr>
                    <th width="30%">{{ $env['name'] }}</th>
                    <td><span>{{ $env['value'] }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection