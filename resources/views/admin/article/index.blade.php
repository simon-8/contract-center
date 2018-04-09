@extends('layout.admin')
@section('content')
<div class="col-sm-12 animated fadeInRight">
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-content mailbox-content">
                <div class="file-manager">
                    <a class="btn btn-block btn-primary compose-mail" href="{{ route('admin.article.create') }}">发布文章</a>
                    <div class="space-25"></div>
                    <h5>文件夹</h5>
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li>
                            <a href="{{ route('admin.article.index') }}">
                                <i class="fa fa-inbox "></i> 已发布
                                <span class="label label-warning pull-right">{{ $status_num[1] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.article.index', ['status' => 0]) }}">
                                <i class="fa fa-file-text-o"></i> 草稿
                                <span class="label label-danger pull-right">{{ $status_num[0] }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.article.index', ['status' => 2]) }}">
                                <i class="fa fa-trash-o"></i> 垃圾箱
                                <span class="label label-danger pull-right">{{ $status_num[2] }}</span>
                            </a>
                        </li>
                    </ul>
                    <h5>分类</h5>
                    <ul class="category-list" style="padding: 0">
                        <li>
                            <a href="{{ route('admin.article.index') }}">
                                <i class="fa fa-circle {{ $catid ? 'text-navy' : 'text-danger' }}"></i> 全部
                            </a>
                        </li>
                        @if(!empty($categorys))
                        @foreach ($categorys as $category)
                        <li>
                            <a href="{{ route('admin.article.index', ['catid' => $category['id']]) }}">
                                <i class="fa fa-circle {{ $category['id'] == $catid ? 'text-danger' : 'text-navy' }}"></i> {{ $category['name'] }}
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>

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
                    <input type="text" class="form-control input-sm" name="keyword" placeholder="搜索文章标题" value="{{ $keyword }}">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">
                            搜索
                        </button>
                    </div>
                </div>
            </form>
            <h2>
            已发布
        </h2>
            <div class="mail-tools tooltip-demo m-t-md">
                {{--<div class="btn-group pull-right">--}}
                    {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>--}}
                    {{--<button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>--}}
                {{--</div>--}}
                <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="刷新邮件列表"><i class="fa fa-refresh"></i> 刷新</button>
                <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="改为待审核"><i class="fa fa-eye"></i>
                </button>
                <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-trash-o"></i>
                </button>

            </div>
        </div>
        <div class="mail-box">

            <table class="table table-hover table-mail">
                <tbody>
                @if(count($lists))
                    @foreach($lists as $v)
                        <tr class="">
                            <td class="check-mail"><input type="checkbox" class="i-checks"></td>
                            <td width="80"><a href="{{ route('admin.article.index', ['catid' => $v->category->id]) }}">{{ $v->category->name }}</a></td>
                            <td>
                                <i class="fa fa-file-image-o" onclick="preview('{{ $v['thumb'] }}', 220, 140)"></i>
                            </td>
                            <td class="mail-subject"><a href="">{{ $v['title'] }}</a></td>
                            {{--<td class=""><i class="fa fa-paperclip"></i></td>--}}
                            <td class="mail-date">{{ $v['created_at'] }}</td>
                            <td class="mail-date">{{ $v['updated_at'] }}</td>
                            <td class="text-right mail-date">
                                <a href="{{ route('admin.article.update', ['id' => $v['id']]) }}" class="btn btn-sm btn-info">编辑</a>
                                <a onclick="Delete({{ $v['id'] }});" class="btn btn-sm btn-danger">删除</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="unread">
                        <td>
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
<script>
    var deleteModal = '#deleteModal';

    function Delete(id , name)
    {
        name = name ? name : 'id';
        $(deleteModal).find('input[name='+name+']').val(id);
        $(deleteModal).modal('show');
    }
</script>
{{--delete--}}
@include('admin.modal.delete' , ['formurl' => route('admin.article.delete')])
@endsection('content')