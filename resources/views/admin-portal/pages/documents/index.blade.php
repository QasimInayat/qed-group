@extends('layouts.admin_scaffold')
@section('title', $title)
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .dropzone{
      background: white;
      border-radius: 5px;
      border: 2px dashed #7367f0;
      border-image: none;
      margin-left: auto;
      margin-right: auto;
    }
    .dropzone .dz-message{
      margin-top: 50px;
      font-size: 1.5rem;
      color :
    }
    .dropzone .dz-message::before{
      font-size: 45px;
    }
</style>
@endpush
@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
       <div class="card">
        <div class="card-header">
            <h3 class="card-title">Documents</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th>Rest. Code</th>
                          <th>Ref#</th>
                          <th>Doc. Type</th>
                          <th>Box#</th>
                          <th>Box Qty.</th>
                          <th>Year</th>
                          <th>Month</th>
                          <th>Total Docs.</th>
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
 </div>

 <div class="modal fade text-start" id="backdrop" tabindex="-1" aria-labelledby="myModalLabel4" data-bs-backdrop="false"  >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Box#<span id="boxNumber"></span> | Ref#<span id="refNumber"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row border" id="attachements">
                    

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js" integrity="sha512-FOhq9HThdn7ltbK8abmGn60A/EMtEzIzv1rvuh+DqzJtSGq8BRdEN0U+j0iKEIffiw/yEtVuladk6rsG4X6Uqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script>
    function documentAttachements(elm){
        
        var boxNumber = elm.attr('box-number');
        var refNumber = elm.attr('ref-number');
        var id = elm.attr('data-id');

        $("#boxNumber").html(boxNumber);
        $("#refNumber").html(refNumber);

        $.ajax({
            type : "GET",
            url  : "{{url('documents')}}"+"/"+id,
            success : function(res){
                $("#attachements").html(res);
            },
            error  : function(res){

            }
        });
        $("#backdrop").modal('show');

    }
  

    $('#table').DataTable({
      processing: true,
      serverSide: true,
      "iDisplayLength": 10,
      dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Export {{$title}}',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            }
      ],
      columnDefs: [
        {"className": "dt-center", "targets": [6,7,8,9]}
      ],
      ajax: "{{ route('documentType',$type) }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false, width: '3%'},
        {data: 'code', name: 'restaurants.code', width: '15%'},
        {data: 'ref_number', name: 'ref_number', width: '12%' },
        {data: 'name', name: 'document_types.name', width: '16%' },
        {data: 'box_number', name: 'box_number', width: '13%' },
        {data: 'box_quantity', name: 'box_quantity', width: '10%' },
        {data: 'year', name: 'year', width: '5%' },
        {data: 'month', name: 'month', width: '5%' },
        {data: 'noOfDocuments', name: 'noOfDocuments', width: '15%' },
        {data: 'action', name: 'action', width: '5%' },

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
