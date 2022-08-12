@extends('layouts.admin_scaffold')
@push('title')
Payment Listing
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
             <h4 class="card-title">Payment Listing</h4>
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
                      <th>Charge Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Amount</th>
                      <th>Country</th>
                      <th>Package</th>
                      <th>Transaction at</th>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script><script>
   $(document).ready(function() {
       $('#table').DataTable({
           processing: true,
           serverSide: true,
           "iDisplayLength": 100,
           ajax: "{{ route('admin.payment.index') }}",
           columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
               {data: 'customer_id', name: 'customer_id'},
               {data: 'user.name', name: 'user.name'},
               {data: 'email', name: 'email'},
               {data: 'package_amount', name: 'amount'},
               {data: 'country', name: 'country'},
               {data: 'package', name: 'package'},
               {data: 'transaction_at', name: 'created_at'},
           ]
       });
   });
</script>
@endpush
