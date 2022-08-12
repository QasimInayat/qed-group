@extends('layouts.admin_scaffold')
@section('title', $title)
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>

</style>
@endpush
@section('content')
<div class="row" id="basic-table">
    <div class="col-12">
       <div class="card">
        <div class="card-header">
            <h3 class="card-title">Advance Filter</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 p-1 border">
                    <form action="{{route('advance.filter')}}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mt-1">
                                <h4>Box number</h4>
                            </div>
                            <div class="col-md-3">
                                <label for=""><small>Search Type</small></label>
                                {!! Form::select('box_number_type', ['LIKE' =>  'LIKE','=' => '='], request('box_number_type'), ['class' => 'form-control select 2']) !!}
                            </div>
                            <div class="col-md-5">
                                <label for=""><small>Box Number</small></label>
                                {!! Form::text('box_number', request('box_number'), ['class' => 'form-control','placeholder' => 'Box Number']) !!}
                            </div>

                            <div class="col-md-4 mt-1">
                                <h4>Department</h4>
                            </div>
                            <div class="col-md-3">
                                <label for=""><small>Search Type</small></label>
                                {!! Form::select('department_type', ['LIKE' =>  'LIKE','=' => '='], request('department_type'), ['class' => 'form-control select 2']) !!}

                            </div>
                            <div class="col-md-5">
                                <label for=""><small>Department</small></label>
                                {!! Form::text('department', request('department'), ['class' => 'form-control', 'placeholder' => 'Department']) !!}
                            </div>


                            <div class="col-md-4 mt-1">
                                <h4>Category</h4>
                            </div>
                            <div class="col-md-3">
                                <label for=""><small>Search Type</small></label>
                                {!! Form::select('category_type', ['LIKE' =>  'LIKE','=' => '='], request('category_type'), ['class' => 'form-control select 2']) !!}

                            </div>
                            <div class="col-md-5">
                                <label for=""><small>Category</small></label>
                                {!! Form::text('category', request('category'), ['class' => 'form-control','placeholder' => 'Category']) !!}
                            </div>


                            <div class="col-md-4 mt-1">
                                <h4>Reference Number</h4>
                            </div>
                            <div class="col-md-3">
                                <label for=""><small>Search Type</small></label>
                                {!! Form::select('ref_number_type', ['LIKE' =>  'LIKE','=' => '='], request('ref_number_type'), ['class' => 'form-control select 2']) !!}

                            </div>
                            <div class="col-md-5">
                                <label for=""><small>Reference Number</small></label>
                                {!! Form::text('ref_number', request('ref_number'), ['class' => 'form-control','placeholder' => 'Reference Number']) !!}
                            </div>


                            <div class="col-md-4 mt-1">
                                <h4>Date</h4>
                            </div>
                            <div class="col-md-4">
                                <label for=""><small>Start Date</small></label>
                                {!! Form::date('start_date', request('start_date'), ['class' => 'form-control']) !!}

                            </div>
                            <div class="col-md-4">
                                <label for=""><small>End Date</small></label>
                                {!! Form::date('end_date', request('end_date'), ['class' => 'form-control']) !!}
                            </div>


                            <div class="col-md-10 mt-2">
                                <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col-md-2 mt-2">
                                <a href="{{route('advance.filter')}}">
                                    <button type="button" class="btn btn-danger w-100"><i class="fa fa-times"></i></button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" width="100%" id="table">
                    <thead>
                        <tr>
                            <th width="6%">#</th>
                            <th width="8%">Box#</th>
                            <th width="10%">Department</th>
                            <th width="18%">Category</th>
                            <th width="12%">Ref#</th>
                            <th width="10%">Date</th>
                            <th class="text-center" width="36%">Documents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($result as $index=>$item)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{$item->box_number}}</td>
                                <td>{{$item->department}}</td>
                                <td>{{$item->category}}</td>
                                <td>{{$item->ref_number}}</td>
                                <td>{{$item->date}}</td>
                                <td class="text-center">
                                    {!! documentAttachments($item->id) !!}
                                </td>
                            </tr>
                        @empty

                        @endforelse
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
      "iDisplayLength": 100,
      dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Export Excel',
                className: 'btn btn-success',
          
            }
      ],


    });
</script>
@endpush
