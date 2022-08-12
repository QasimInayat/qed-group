@extends('layouts.admin_scaffold')
@push('title')
{{$title}}
@endpush
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet"><style>
   .paginate_button{
   padding: 0px !important;
   }
</style>
@endpush
@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
       <div class="card">
          <div class="card-header">
             <h4 class="card-title">{{$title}}</h4>
          </div>
          <div class="card-content">
            {!! Form::model($question,['route' => ['admin.help-center.answer',$question->id]]) !!}
             <div class="row p-3">
                 <div class="col-md-12">
                     <label for="">Add Answer</label>
                    {!! Form::textarea('content', null, ['class' => 'tiny']) !!}
                 </div>

                <div class="col-md-12">
                    <div class="pull-right mt-4">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>
                {!! Form::close() !!}
             </div>
          </div>


       </div>
    </div>
 </div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>
{{-- <script src="https://cdn.tiny.cloud/1/6f1k77av7h8eudxgn4bffg5x56y8gn1ga66gq73lc2ml8vr3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script>
  tinymce.init({selector:'textarea.tiny',height:"800", plugins: "code"})
</script>
@endpush
