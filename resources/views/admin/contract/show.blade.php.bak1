@extends('layout.admin')

@section('content')
    <div class="col-sm-12 animated fadeInRight">

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover bg-white text-center text-nowrap">
                <thead>
                <tr class="text-center">
                    <td style="width: 50px;">编号</td>
                    <td style="width: 60px;">分类</td>
                    <td style="width: 60px;">名称</td>
                    <td style="width: 100px;">甲方</td>
                    <td style="width: 100px;">乙方</td>
                    <td style="width: 100px;">居间人</td>
                    <td style="width: 60px;">甲方确认</td>
                    <td style="width: 60px;">乙方确认</td>
                    <td style="width: 60px;">状态</td>
                    <td style="width: 100px;">创建时间</td>
                    <td style="width: 100px;">更新时间</td>
                    <td style="width: 100px;">确认时间</td>
{{--                    <td style="width: 180px;">操作</td>--}}
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $contract->id }}</td>
{{--                    <td>{{ $contract->listorder }}</td>--}}
                    <td>
                        <span class="label label-primary">{{ $contract->getCatText() }}</span>
                    </td>
                    <td>{{ $contract->name }}</td>
                    <td>{{ $contract->jiafang ?: '/' }}</td>
                    <td>{{ $contract->yifang ?: '/' }}</td>
                    <td>{{ $contract->jujianren ?: '/' }}</td>
                    <td>{!! colorText($contract->confirm_first, '是', '否') !!}</td>
                    <td>{!! colorText($contract->confirm_second, '是', '否') !!}</td>
                    <td>
                        <span class="label label-success">{{ $contract->getStatusText()  }}</span>
                    </td>
                    <td>{{ $contract->created_at }}</td>
                    <td>{{ $contract->updated_at }}</td>
                    <td>{{ $contract->confirm_at }}</td>
{{--                    <td>--}}
{{--                        <a class="btn btn-sm btn-default"--}}
{{--                           href="{{ route('admin.contract.show', ['id' => $contract->id]) }}">查看</a>--}}
{{--                        <a class="btn btn-sm btn-info"--}}
{{--                           href="{{ route('admin.contract.edit', ['id' => $contract->id]) }}">编辑</a>--}}
{{--                        <button class="btn btn-sm btn-danger"--}}
{{--                                onclick="Delete('{{ editURL('admin.contract.destroy', $contract->id) }}')">删除--}}
{{--                        </button>--}}
{{--                    </td>--}}
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
