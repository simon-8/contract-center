<div class="col-sm-12 animated fadeInRight">
@if(session('message'))
    <div class="alert alert-success alert-dismissable" id="MessageBox">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('message') }}
    </div>
    <script>
        if($('#MessageBox').length){
            setTimeout(function(){
                $('#MessageBox').hide(1000);
            },10000);
        }
    </script>
@endif
@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{  $error }}
        </div>
    @endforeach
@endif
</div>