<style>
    #clipArea {
        height: 300px;
    }
    #view {
        margin: 0 auto;
        width: 200px;
        height: 200px;
    }
</style>
<div id="clipArea"></div>

<div class="form-group">
    <label class="col-sm-6">
        <input type="file" id="upload_file" class="pull-left">
    </label>
    <div class="col-sm-6">
        <button id="clipBtn" class="btn btn-sm btn-success">截取</button>
    </div>
</div>

<div id="view" class="hidden"></div>

<script src="{{ skinPath() }}js/plugins/photoClip/hammer.min.js"></script>
<script src="{{ skinPath() }}js/plugins/photoClip/iscroll-zoom-min.js"></script>
<script src="{{ skinPath() }}js/plugins/photoClip/lrz.all.bundle.js"></script>
<script src="{{ skinPath() }}js/plugins/photoClip/PhotoClip.js"></script>

<script>
    var pc = new PhotoClip('#clipArea', {
        size: [{{ $w }}, {{ $h }}],
        outputSize: [{{ $w }}, {{ $h }}],
        //adaptive: ['60%', '80%'],
        file: '#upload_file',
        view: '#view',
        ok: '#clipBtn',
        //img: 'img/mm.jpg',
        outputQuality: 1,
        lrzOption: {
            quality: 1
        },
        loadStart: function() {
            console.log('开始读取照片');
        },
        loadComplete: function() {
            console.log('照片读取完成');
        },
        done: function(dataURL) {
            console.log(dataURL);
            {{ $c }}(dataURL,'{{ $i }}');
            layer.closeAll();
        },
        fail: function(msg) {
            alert(msg);
        }
    });
</script>
<style>
    #clipBtn{
        width:340px;
        margin:20px;
    }
    #upload_file{
        margin:20px;
    }
</style>
