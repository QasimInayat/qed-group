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
              @if(isset($page))
                  {!! Form::model($page,['route' => ['admin.pages.update',$page->id]]) !!}
                  @method('PUT')
              @else
                {!! Form::open(['route' => 'admin.pages.store']) !!}
              @endif
             <div class="row p-3">
                 <div class="col-md-3">
                     <label for="">Title</label>
                     {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                 </div>
                 <div class="col-md-3">
                    <label for="">Show In Nav</label>
                    {!! Form::select('is_nav', [1 =>  'Show', 0 => 'Hide'], null, ['class' => 'form-control', 'required']) !!}

                </div>
                <div class="col-md-3">
                    <label for="">Show In Footer</label>
                    {!! Form::select('is_footer', [1 =>  'Show', 0 => 'Hide'], null, ['class' => 'form-control', 'required']) !!}
                 </div>
                 <div class="col-md-3">
                    <label for="">Status</label>
                    {!! Form::select('status', [1 =>  'Active', 0 => 'Deactive'], null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-md-12">
                    <div class="pull-right mt-4">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>
                {!! Form::close() !!}
             </div>
          </div>

          <div class="card-content mt-5 p-3">
            <h4>Pages</h4>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>#</th>
                    <th>Page</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
                @forelse ($pages as $index=>$item)
                    <tr>
                        <td>{{++$index}}</td>
                        <td><a href="">{{$item->title}}</a></td>
                        <td class="text-center">{!!status($item->status)!!}&nbsp;{!! isNav($item->is_nav)  !!}&nbsp;{!! isFooter($item->is_footer)  !!} </td>
                        <td class="text-center">
                            <a href="{{route('admin.page.details',$item->id)}}"><button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Add Content"><i class="fa fa-file"></i></button></a>&nbsp;
                            <a href="{{route('admin.pages.edit',$item->id)}}"><button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button></a>&nbsp;
                            <a href="{{route('admin.pages.show',$item->id)}}"><button type="button" onClick="return confirm('Are you sure?')" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></a>&nbsp;
                        </td>
                    </tr>
                @empty

                @endforelse
            </table>
          </div>
       </div>
    </div>
 </div>
@endsection
@push('scripts')
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush
