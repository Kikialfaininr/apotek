@if (Session::has('sukses'))
<div class="col-md-6">
    <div id="alert" class="alert alert-success" style="width:300px; right:36px; top:60px; cursor:auto; opacity:1; position:fixed; z-index: 1060;">
        <span class="fa fa-check"></span> <strong>Sukses</strong>
        <button type="button" class="btn-close btn-close-white" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 0; right: 0;"></button>
        <hr class="messege-inner-seperator">
        <p>{{Session::get('sukses')}}</p>
    </div>
</div>
@elseif (Session::has('gagal'))
<div class="col-md-6">
    <div id="alert" class="alert alert-danger" style="width:300px; right:36px; top:60px; cursor:auto; opacity:1; position:fixed; z-index: 1060;">
        <span class="fa fa-times"></span> <strong>Gagal</strong>
        <button type="button" class="btn-close btn-close-white" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 0; right: 0;"></button>
        <hr class="messege-inner-seperator">
        <p>{{Session::get('gagal')}}</p>
    </div>
</div>
@endif

