@extends('layouts.admin_scaffold')
@section('content')
    <div class="row match-height">
<!-- Medal Card -->
<div class="col-xl-12 col-md-12 col-12">
<div class="card card-congratulation-medal">
<div class="card-body">
<h5>Congratulations 🎉 {{auth()->user()->name}}</h5>
<p class="card-text font-small-3">You have won gold medal</p>
<h3 class="mb-75 mt-2 pt-50">
<a href="#">$48.9k</a>
</h3>
<button type="button" class="btn btn-primary waves-effect waves-float waves-light">View Sales</button>
<img src="{{asset('app-assets/images/illustration/badge.svg')}}" class="congratulation-medal" alt="Medal Pic">
</div>
</div>
</div>
<!--/ Medal Card -->
</div>
@endsection
