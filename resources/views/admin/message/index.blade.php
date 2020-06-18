@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-content mailbox-content">
                <div class="file-manager">
                    <a class="btn btn-block btn-primary compose-mail" href="{{ route('admin.message.create') }}">发布站内信</a>
                    <div class="space-25"></div>
                    <h5>信件状态</h5>
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li>
                            <a href="{{ route('admin.message.index') }}"
                               @if(!isset($data['is_read']))class="alert-success"@endif>
                                <i class="fa fa-inbox"></i> 全部
                                {{--                                <span class="label label-warning pull-right">{{ $status_num[1] }}</span>--}}

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.message.index', ['is_read' => 1]) }}"
                               @if(isset($data['is_read']) && $data['is_read'] == 1)class="alert-success"@endif>
                                <i class="fa fa-inbox "></i> 已读
{{--                                <span class="label label-warning pull-right">{{ $status_num[1] }}</span>--}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.message.index', ['is_read' => 0]) }}"
                                @if(isset($data['is_read']) && $data['is_read'] == 0)class="alert-success"@endif>
                                <i class="fa fa-file-text-o"></i> 未读
{{--                                <span class="label label-danger pull-right">{{ $status_num[0] }}</span>--}}
                            </a>

                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9 animated fadeInRight">
        <div class="mail-box-header">

            <form method="get" action="?" class="pull-right mail-search">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" name="title" placeholder="搜索站内信标题" value="{{ $data['title'] ?? '' }}">
                    <input type="hidden" name="status" value="{{ $data['is_read'] ?? '' }}">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">
                            搜索
                        </button>
                    </div>
                </div>
            </form>
            <h2>
            {{ isset($data['is_read']) && $data['is_read'] !== '' ? ($data['is_read'] ? '已读' : '未读' ) : '全部' }}
        </h2>
            <div class="mail-tools tooltip-demo m-t-md"></div>
        </div>
        <div class="mail-box">
            <table class="table table-striped table-hover bg-white text-center text-nowrap">
                <tbody>
                <tr>
                    <td width="50">编号</td>
                    {{--<td width="80">缩略图</td>--}}
                    <td width="80">发送人</td>
                    <td width="80">接收人</td>
                    <td width="200">标题</td>
                    <td width="400">内容</td>
                    <td width="80">已读</td>
                    <td width="200">创建时间</td>
                    <td width="200">更新时间</td>
                    <td width="180">操作</td>
                </tr>
                @if($lists->count())
                    @foreach($lists as $v)
                        <tr class="">
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->fromUser->truename }}</td>
                            <td>{{ $v->toUser->truename ?: $v->toUser->nickname }}</td>
                            <td>{{$v->title}}</td>
                            <td>{{\Str::limit(strip_tags($v->content), 20, '...')}}</td>
                            <td>{!! colorText($v->is_read, '已读', '未读') !!}</td>
                            <td>{{ $v['created_at'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a href="{{ editURL('admin.message.edit', $v['id']) }}" class="btn btn-sm btn-info">编辑</a>
                                <a onclick="Delete('{{ editURL('admin.message.destroy', $v['id']) }}');" class="btn btn-sm btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="unread">
                        <td colspan="9" style="padding: 50px; text-align: center;">
                            暂无数据
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>
            @if($lists->count())
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
{{--delete--}}
@include('admin.modal.delete')

@endsection
