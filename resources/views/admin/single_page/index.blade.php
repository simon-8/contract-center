@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-content mailbox-content">
                <div class="file-manager">
                    <a class="btn btn-block btn-primary compose-mail" href="{{ route('single-page.create') }}">发布单页</a>
                    <div class="space-25"></div>
                    <h5>文件夹</h5>
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li>
                            <a href="{{ route('single-page.index') }}">
                                <i class="fa fa-inbox "></i> 已发布
                                <span class="label label-warning pull-right">{{ $status_num[1] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('single-page.index', ['status' => 0]) }}">
                                <i class="fa fa-file-text-o"></i> 已关闭
                                <span class="label label-danger pull-right">{{ $status_num[0] }}</span>
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ route('single-page.index', ['status' => 2]) }}">--}}
                                {{--<i class="fa fa-trash-o"></i> 垃圾箱--}}
                                {{--<span class="label label-danger pull-right">{{ $status_num[2] }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                    {{--<h5>分类</h5>--}}
                    {{--<ul class="category-list" style="padding: 0">--}}
                        {{--<li>--}}
                            {{--<a href="{{ route('single-page.index') }}">--}}
                                {{--<i class="fa fa-circle {{ $catid ? 'text-navy' : 'text-danger' }}"></i> 全部--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@if(!empty($categorys))--}}
                        {{--@foreach ($categorys as $category)--}}
                        {{--<li>--}}
                            {{--<a href="{{ route('single-page.index', ['catid' => $category['id']]) }}">--}}
                                {{--<i class="fa fa-circle {{ $category['id'] == $catid ? 'text-danger' : 'text-navy' }}"></i> {{ $category['name'] }}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</ul>--}}

                    @if(!empty($tags))
                    <h5 class="tag-title">标签</h5>
                    <ul class="tag-list" style="padding: 0">
                        @foreach($tags as $v)
                            <li><a href=""><i class="fa fa-tag"></i> {{ $v->name }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9 animated fadeInRight">
        <div class="mail-box-header">

            <form method="get" action="?" class="pull-right mail-search">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" name="keyword" placeholder="搜索单页标题" value="{{ $data['keyword'] ?? '' }}">
                    <input type="hidden" name="status" value="{{ $data['status'] ?? '' }}">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">
                            搜索
                        </button>
                    </div>
                </div>
            </form>
            <h2>
            {{ isset($data['status']) && $data['status'] !== '' ? ($data['status'] ? '已发布' : '已关闭' ) : '已发布' }}
        </h2>
            <div class="mail-tools tooltip-demo m-t-md">
                {{--<div class="btn-group pull-right">--}}
                    {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>--}}
                    {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>--}}
                {{--</div>--}}
                {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="刷新邮件列表"><i class="fa fa-refresh"></i> 刷新</button>--}}
                {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="改为待审核"><i class="fa fa-eye"></i></button>--}}
                {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-trash-o"></i></button>--}}
            </div>
        </div>
        <div class="mail-box">
            <table class="table table-striped table-hover bg-white text-center text-nowrap">
                <tbody>
                <tr>
                    <td width="50">编号</td>
                    {{--<td width="80">缩略图</td>--}}
                    <td width="400">标题</td>
                    <td width="80">状态</td>
                    <td width="200">创建时间</td>
                    <td width="200">更新时间</td>
                    <td width="180">操作</td>
                </tr>
                @if(count($lists))
                    @foreach($lists as $v)
                        <tr class="">
                            <td>{{ $v['id'] }}</td>
                            {{--<td>--}}
                                {{--@if($v->thumb)--}}
                                    {{--<a href="javascript:;" onclick="preview('{{ $v->thumb }}', 640, 340)"><i class="fa fa-file-image-o"></i></a>--}}
                                {{--@else--}}
                                    {{--无--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            <td><a href="{{ editURL('single-page.edit', $v['id']) }}">{{ $v['title'] }}</a></td>
                            <td>{!! colorText($v->status, '正常', '关闭') !!}</td>
                            <td>{{ $v['created_at'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a href="{{ editURL('single-page.edit', $v['id']) }}" class="btn btn-sm btn-info">编辑</a>
                                @if ($v['id'] > 8)
                                    <a onclick="Delete('{{ editURL('single-page.destroy', $v['id']) }}');" class="btn btn-sm btn-danger">删除</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="unread">
                        <td colspan="6">
                            暂无数据
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>
            @if(count($lists))
                <div class="text-center">
                    {!! $lists->render() !!}
                </div>
            @endif
        </div>
    </div>
</div>
{{--delete--}}
@include('admin.modal.delete')
@endsection('content')