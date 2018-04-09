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
                            {{--{{ seditor($content , 'content','markdown' ,'rows=10') }}--}}
                            {{ seditor(isset($content) ? $content['content'] : old('content') , 'content') }}
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
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
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
                                    <input type="radio" name="status" value="1">开启
                                </label>
                                <label>
                                    <input type="radio" name="status" value="0" checked>关闭
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

        });
    </script>
@endsection('content')