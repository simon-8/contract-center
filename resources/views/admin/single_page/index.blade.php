@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-content mailbox-content">
                <div class="file-manager">
                    <a class="btn btn-block btn-primary compose-mail" href="{{ route('admin.single-page.create') }}">发布单页</a>
                    <div class="space-25"></div>
                    <h5>文件夹</h5>
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li>
                            <a href="{{ route('admin.single-page.index') }}">
                                <i class="fa fa-inbox "></i> 已发布
                                <span class="label label-warning pull-right">{{ $status_num[1] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.single-page.index', ['status' => 0]) }}">
                                <i class="fa fa-file-text-o"></i> 已关闭
                                <span class="label label-danger pull-right">{{ $status_num[0] }}</span>
                            </a>
                        </li>
                    </ul>
                    <h5>分类</h5>
                    <ul class="category-list" style="padding: 0">
                        <li>
                            <a href="{{ route('admin.single-page.index') }}">
                                <i class="fa fa-circle {{ !isset($data['catid']) ? 'text-danger' : 'text-navy' }}"></i> 全部
                            </a>
                        </li>
                        @if(!empty($categorys))
                        @foreach ($categorys as $cid => $catname)
                        <li>
                            <a href="{{ route('admin.single-page.index', ['catid' => $cid]) }}">
                                <i class="fa fa-circle {{ isset($data['catid']) && $data['catid'] == $cid ? 'text-danger' : 'text-navy' }}"></i> {{ $catname }}
                            </a>
                        </li>
                        @endforeach
                        @endif
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
            <div class="mail-tools tooltip-demo m-t-md"></div>
        </div>
        <div class="mail-box">
            <table class="table table-striped table-hover bg-white text-center text-nowrap">
                <tbody>
                <tr>
                    <td width="50">编号</td>
                    {{--<td width="80">缩略图</td>--}}
                    <td width="50">排序</td>
                    <td width="200">分类名称</td>
                    <td width="400">标题</td>
                    <td width="80">状态</td>
                    <td width="200">创建时间</td>
                    <td width="200">更新时间</td>
                    <td width="180">操作</td>
                </tr>
                @if($lists->count())
                    @foreach($lists as $v)
                        <tr class="">
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $v['listorder'] }}</td>
                            <td>{{ $v['cat_text'] }}</td>
                            <td><a href="{{ editURL('admin.single-page.edit', $v['id']) }}">{{ $v['title'] }}</a></td>
                            <td>{!! colorText($v->status, $v->status_text, $v->status_text) !!}</td>
                            <td>{{ $v['created_at'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a href="{{ editURL('admin.single-page.edit', $v['id']) }}" class="btn btn-sm btn-info">编辑</a>
                                <a onclick="Delete('{{ editURL('admin.single-page.destroy', $v['id']) }}');" class="btn btn-sm btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="unread">
                        <td colspan="7">
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
