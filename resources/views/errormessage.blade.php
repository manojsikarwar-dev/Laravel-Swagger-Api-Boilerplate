@if ($message = Session::get('success'))
<div class="demo-spacing-0 pb-1">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-body">
            {!! $message !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="demo-spacing-0 pb-1">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-body">
            {!! $message !!}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if ($errors->any())
<div class="demo-spacing-0 pb-1">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-body">
           @foreach ($errors->all() as $error)<li>{{ $error }}  </li>@endforeach
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif