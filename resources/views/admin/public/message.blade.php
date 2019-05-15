@if(session('message'))
    <div class="col-sm-12 animated fadeInRight">
        <div class="alert alert-success alert-dismissable" id="MessageBox">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('message') }}
        </div>
        <script>
            if ($('#MessageBox').length) {
                setTimeout(function () {
                    $('#MessageBox').hide(1000);
                }, 10000);
            }
        </script>
    </div>
@endif

@if(count($errors) > 0)
    <div class="col-sm-12 animated fadeInRight">
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{  $error }}
            </div>
        @endforeach
    </div>
@endif
