<!--如果在页面其他位置引入过jquery，此处引用可以删除-->
<script src="{{asset('vendor/markdown/js/jquery.min.js')}}"></script>

<script src="{{asset('vendor/markdown/js/editormd.min.js')}}"></script>
<script src="{{asset('vendor/markdown/lib/marked.min.js')}}"></script>
<script src="{{asset('vendor/markdown/lib/prettify.min.js')}}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.min.css" />
<script type="text/javascript">
    $(function () {
        @foreach($editors as $editor)
        editormd.markdownToHTML("{{$editor}}", {
            htmlDecode: "style,script,iframe",
            emoji: false,
            taskList: true,
            tex: false, // 默认不解析
            flowChart: false, // 默认不解析
            sequenceDiagram: false, // 默认不解析
            codeFold: true,
        });
        @endforeach
    });
</script>