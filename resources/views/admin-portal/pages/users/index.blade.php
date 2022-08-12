@extends('layouts.admin_scaffold')
@section('title', $title)
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
@endpush
@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
       <div class="card">
          <div class="card-header">
             <h3 class="card-title">{{$heading}}</h3>
          </div>
          <div class="card-body">
            @if(isset($user))
            {!! Form::model($user, ['route' => ['users.update',$user->id]]) !!}
            @method('PUT')
            @else
                {!! Form::open(['route' => 'users.store', 'id' => 'form']) !!}
            @endif
             <div class="row ">
                <div class="col-md-6">
                    <label for="">Name*</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Full Name', 'required']) !!}
                </div>
                <div class="col-md-6">
                    <label for="">Email*</label>
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required']) !!}
                </div>

                <div class="col-md-6">
                    <label for="">Phone</label>
                    {!! Form::number('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Phone']) !!}
                </div>
                <div class="col-md-6">
                    <label for="">Password*</label>
                    <input type="password" name="psw" id="" class="form-control" @if(empty($user)) required @endif placeholder="********">
                    @isset($user)<span class="text-danger">Fill only when need to change password</span>@endisset
                </div>

                <div class="col-md-6">
                    <label for="">Role</label>
                    {!! Form::select('role_id', ['1' => 'Admin', '2' => 'Employee'], null, ['class' => 'form-control',  'required']) !!}
                </div>
                <div class="col-md-6">
                    <label for="">Status*</label>
                    {!! Form::select('is_active', activeInActive(), null, ['class' => 'form-control',  'required']) !!}
                </div>

                <div class="col-md-12 mt-1">
                    <button type="submit" class="btn btn-primary pull-right">{{$button}}</button>
                </div>
             </div>
             {!! Form::close() !!}
          </div>
          <hr>
          <div class="table-responsive p-2">
            <h4>{{$title}} Listing</h4>
            <table id="table" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th>Action</th>
                   </tr>
                </thead>
                <tbody>
                </tbody>
             </table>
          </div>
       </div>
    </div>
 </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js" integrity="sha512-FOhq9HThdn7ltbK8abmGn60A/EMtEzIzv1rvuh+DqzJtSGq8BRdEN0U+j0iKEIffiw/yEtVuladk6rsG4X6Uqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script>
     $("#form").validate({
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#table').DataTable({
      processing: true,
      serverSide: true,
      "iDisplayLength": 100,
      dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Export {{$title}}',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
      ],
      ajax: "{{ route('users.index') }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, width: '7%'},
        {data: 'name', name: 'name', width: '25%'},
        {data: 'email', name: 'email', width: '25%'},
        {data: 'phone', name: 'phone', width: '13%'},
        {data: 'role', name: 'role', width: '10%'},
        {data: 'isActive', name: 'isActive', width: '10%' },
        {data: 'action', name: 'action', width: '10%' },
      ]
    });

    function deleteEvent(elm){
        var link = elm.attr('data-link');
        var conf = confirm('Are you sure?');
        if(conf == true){
            window.location.href = link;
        }
    }
</script>
@endpush
