@extends('layouts.admin_scaffold')
@push('title')
Assign Package
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
             <h4 class="card-title">Assign Package</h4>
          </div>
          <div class="card-body">
             <p class="card-text">

             </p>
          </div>
          <div class="table-responsive p-2">
             <table class="table table-striped table-bordered table-hover" id="table">
                <thead>
                   <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>DOB</th>
                      <th>Hometown</th>
                      <th>Package</th>
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

 <div class="modal fade modal-primary text-start show" id="assignPackageModal" tabindex="-1" aria-labelledby="myModalLabel120"  aria-modal="true" role="dialog">
   <div class="modal-dialog ">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="myModalLabel120">Assign Package</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
        <form action="{{route('admin.payment.assignPackage')}}" method="POST">
            @csrf
            <div class="row">
                {!! Form::hidden('user_id', null, ['id' => 'pUser_id']) !!}
                <div class="col-md-12 mb-2">
                <label for="">Member Name</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'required','id' => 'pName', 'requried']) !!}
                </div>
                <div class="col-md-12 mb-2">
                <label for="">Package</label>
                {!! Form::select('package', getPackages(), null, ['class' => 'form-control', 'required', 'placeholder' => 'Select Package', 'id' => 'pPackage_id', 'requried', 'onChange' => 'getPackage($(this))']) !!}
                </div>
                <div class="col-md-12 mb-2">
                <label for="">Amount</label>
                {!! Form::number('amount', null, ['class' => 'form-control', 'required','id' => 'pAmount', 'requried', 'step'=>'any']) !!}
                </div>
                <div class="col-md-12">.
                <button type="submit" class="btn btn-primary btn-block">ASSIGN PACKAGE</button>
                </div>
            </div>
        </form>
       </div>

     </div>
   </div>
 </div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script><script>
   $(document).ready(function() {
       $('#table').DataTable({
           processing: true,
           serverSide: true,
           "iDisplayLength": 100,
           ajax: "{{ route('admin.payment.assignPackage') }}",
           columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
               {data: 'name', name: 'name'},
               {data: 'email', name: 'email'},
               {data: 'genderCapatalize', name: 'gender'},
               {data: 'dob', name: 'date_of_birth'},
               {data: 'hometown', name: 'hometown'},
               {data: 'getPackage', name: 'package_id'},
               {data: 'status', name: 'status'},
               {data: 'action', name: 'action'},
           ]
       });
   });

   function assignPackage(id,package,price,name){
       $("#pName").val(name);
       $("#pPackage_id").val(package);
       $("#pAmount").val(price);
       $("#pUser_id").val(id);
       $("#assignPackageModal").modal('show');
   }

   function getPackage(elm){
       var id  = elm.val();
       $.ajax({
           type : "GET",
           url  : "{{route('admin.payment.getPackage')}}",
           data : {
                'id' : id,
           },
           beforeSend : function(res){

           },
           success : function(res){
                if(res.success == true){
                    $("#pAmount").val(res.amount);
                }
                else{
                    $("#pAmount").val(0);
                }
           },
           error : function(res){

           }
       })
   }
</script>
@endpush
