
@if ($errors->any())
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="alert-body">
      {{$error}}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endforeach
@endif

{{-- @if(Session::has("success"))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="alert-body">
      {{Session::get('success')}}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(Session::has("error"))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="alert-body">
      {{Session::get('error')}}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}
