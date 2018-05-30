@extends('layout.admin')

@section('content')

    <div class="ibox float-e-margins">
        <form method="post" class="form-horizontal" action="{{ isset($id) ? route('admin.article.update') : route('admin.article.create') }}" id="sform">
            {!! csrf_field() !!}
            <div class="col-sm-12 col-md-8">
                <div class="ibox-title">
                    @if(isset($id))
                        <h5>编辑文章</h5>
                        <input type="hidden" name="id" value="{{ $id }}">
                    @else
                        <h5>添加文章</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">文章标题</label>
                        <div class="col-sm-11">
                            <input id="name" type="text" class="form-control" name="title" value="{{ isset($title) ? $title : old('title') }}">
                            <span class="help-block m-b-none"></span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">简介</label>
                        <div class="col-sm-11">
                            <input id="introduce" type="text" class="form-control" name="introduce" value="{{ isset($introduce) ? $introduce : old('introduce') }}"/>
                            <span class="help-block m-b-none">简单说明</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label">内容</label>
                        <div class="col-sm-11">
                            {!! seditor(old('content') ? old('content') : (isset($content) ? $content['content'] : '') , 'content') !!}
                            <span class="help-block m-b-none">文章内容</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存内容</button>
                            <a class="btn btn-white" href="{{ route('admin.article.index') }}">返回</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="ibox-title">
                    <h5>其他设置</h5>
                </div>
                <div class="ibox-content">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类</label>
                        <div class="col-sm-10">
                            <select name="catid" class="form-control">
                                @if(!empty($categorys))
                                    @foreach ($categorys as $category)
                                        <option value="{{ $category['id'] }}" {{ !empty($catid) && $catid == $category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">标签</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                {{--<input type="hidden" name="tags" value="">--}}
                                {{--<input type="hidden" name="tagInput" id="tag-input" value="">--}}
                                {{--<input type="text" id="tag" class="form-control" value="">--}}
                                {{--<span class="input-group-btn">--}}
                                    {{--<button type="button" class="btn btn-primary" id="tag-add">添加</button>--}}
                                {{--</span>--}}
                            </div>
                            {{--<div class="input-group">--}}
                                {{--<span class="help-block m-b-none">多个标签请用英文逗号（,）分开</span>--}}
                            {{--</div>--}}
                            <div class="input-group mt tag-list" id="tag-list">
                                @if (!empty($tags))
                                    @foreach ($tags as $tag)
                                        <a href="javascript:" class="label label-info">
                                            <input type="hidden" name="tags[]" value="{{ $tag['id'] }}">
                                            {{ $tag['name'] }}
                                        </a>
                                    @endforeach
                                @endif
                                {{--<foreach name="tag_lists" item="t">--}}
                                    {{--<a href="javascript:" class="label label-info">AAA</a>--}}
                                {{--</foreach>--}}
                            </div>
                            <div class="input-group">
                                <a id="tag-choice">从常用标签库里选择</a>
                            </div>
                            <div class="form-group tag-list" id="tagcloud" style="border: none;">

                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">缩略图</label>
                        <div class="col-sm-10">
                            <img src="{{ imgurl(isset($thumb) ? $thumb : old('thumb')) }}" id="pthumb" class="bg-warning" style="width: 220px; height: 140px;">
                            <input type="hidden" id="thumb" name="thumb" value="{{ empty($thumb) ? old('thumb') : $thumb }}">
                            <button class="btn btn-lg" type="button" onclick="Sthumb('thumb', 220, 140);" style="height: 140px; margin-bottom: 0;">上传</button>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <div class="i-checks radio">
                                <label>
                                    <input type="radio" name="status" value="1" {{ !empty($status) && $status ? 'checked' : '' }}>开启
                                </label>
                                <label>
                                    <input type="radio" name="status" value="0"  {{ empty($status) ? 'checked' : '' }}>关闭
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                </div>
            </div>
        </form>
    </div>

    <script>
        $(function(){
            @if((isset($status) && $status))
            $('[name=status][value={{ $status }}]').attr('checked', true);
            @endif

            @if(old('status'))
            $('[name=status][value={{ $status }}]').attr('checked', true);
            @endif

            // show
            $('#tag-choice').click(function () {
                $.post(AJPath, {ac: 'tags'}, function (data) {
                    let tag = '';
                    $.each(data, function (k, t) {
                        tag += '<a href="javascript:" class="label label-info" data-id='+t.id+'>' + t.name + '</a>';
                    });
                    $('#tagcloud').html(tag);
                }, 'json');
            });
            // add
            //$('#tag-add').click(function () {
            //    let $tag = $('#tag'),
            //        $tagInput = $('#tag-input'),
            //        $tagList = $('#tag-list'),
            //        t = $tag.val(),
            //        is_save = 0;
            //    if (t.length) {
            //        $tagList.find('a').each(function () {
            //            if (t === $(this).text()) is_save = 1;
            //        });
            //        if (is_save) {
            //            layer.alert('您已经添加过此标签', {icon: 2});
            //            return;
            //        }
            //        let tag = '<a href="javascript:" class="label label-info">' + t + '<input type="hidden" name="tags[]" value="' + t + '"/></a>';
            //        $tag.val('');
            //        let v = $tagInput.val();
            //        $tagInput.val(v + t + ',');
            //        $tagList.append(tag);
            //    }
            //});
            // remove
            $('#tag-list').on('click', '.label', function () {
                let $tagCloud = $('#tagcloud'),
                    t = $(this).text().trim();
                $tagCloud.find('a').each(function () {
                    if (t === $(this).text().trim()) {
                        $(this).removeClass('label-warning').addClass('label-info');
                    }
                });
                $(this).remove();
                return false;
            });

            // choose
            $('#tagcloud').on('click', '.label', function () {
                let $tag = $('#tag'),
                    $tagList = $('#tag-list'),
                    t = $(this).text().trim(),
                    id = $(this).attr('data-id'),
                    is_save = 0;

                $(this).removeClass('label-info').addClass('label-warning');

                $tagList.find('a').each(function () {
                    if (t === $(this).text().trim()) is_save = 1;
                });
                if (is_save) {
                    layer.alert('您已经添加过此标签', {icon: 2});
                    return;
                }
                $tag.val('');
                let tag = '<a href="javascript:" class="label label-info">' + t + '<input type="hidden" name="tags[]" value="' + id + '"/></a>';
                $tagList.append(tag);
            });
        });
    </script>
    <style>
        .tag-list{
            border-radius: 3px;
            border: 1px solid #eee;
            margin: 10px 0 !important;
            padding: 5px;
        }
        .tag-list .label {
            margin: 2px 3px;
            font-size: 15px;
            display: inline-block;
            padding: 5px 10px;
        }
    </style>
@endsection('content')