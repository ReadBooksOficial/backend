
@if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
        {{session('danger')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
