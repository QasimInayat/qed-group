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
             <h3 class="card-title">{{$heading}}</h3>
          </div>
          <div class="card-body">
            {!! Form::model($document,['route' => ['documents.update', $document->id], 'id' => 'form', 'enctype'=>'multipart/form-data']) !!}
             @method('PUT')
             <div class="row ">
                <div class="col-md-3">
                    <label for="">Box Number</label>
                    {!! Form::text('box_number', null, ['class' => 'form-control', 'placeholder' => 'Box number']) !!}
                </div>
                <div class="col-md-3">
                    <label for="">Department</label>
                    {!! Form::text('department', null, ['class' => 'form-control',  'required', 'placeholder' => 'Department']) !!}
                </div>
                <div class="col-md-3">
                    <label for="">Category</label>
                    {!! Form::text('category', null, ['class' => 'form-control',  'placeholder' => 'Category']) !!}
                </div>
                <div class="col-md-3">
                    <label for="">Reference Number</label>
                    {!! Form::text('ref_number', null, ['class' => 'form-control',  'placeholder' => 'Reference Number']) !!}
                </div>
                <div class="col-md-3">
                    <label for="">Date</label>
                    {!! Form::date('date', null, ['class' => 'form-control',  'placeholder' => 'Date']) !!}
                </div>

                <div class="col-sm-12 mt-2 mb-2 showDropZone" >
                    <div class="form-group">
                       <div class="controls">
                            <label for="">Modify Document</label>
                        </div>
                    </div>
                    <div class="row p-1">
                        @foreach($document->attachements as $index=>$attach)
                            <div class="col-md-2 col-6 border text-center p-1" id="attachment_{{$attach->id}}">
                                <a href="{{asset($attach->file)}}" target="_blank">
                                    <i class="fa fa-file-pdf-o" style="font-size:25px"></i><br>
                                    <span>{{str_replace('upload/document/','',$attach->file)}}</span>
                                </a><br>
                                <a href="javascript:;" onClick="removeAttachement('{{$attach->id}}')" ><span class="text-danger badge bg-danger text-white">Remove</span></a>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="col-sm-12 mt-2 mb-2 showDropZone" >
                    <div class="form-group">
                       <div class="controls">
                          <label for="">UPLOAD NEW DOCUMENT</label>
                          <div class="dropzoneFiles">
                          </div>
                          <div action="{{route('documents.store')}}" class="dropzone dropzone-area" id="dpz-remove-thumb">
                            <div class="dz-message">Drop Files Here To Upload</div>
                          </div>
                       </div>
                    </div>
                </div>


                <div class="col-md-12 mt-1">
                    <button type="submit" class="btn btn-primary pull-right">{{$button}}</button>
                </div>
             </div>
             {!! Form::close() !!}
          </div>

       </div>

    </div>
 </div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js" integrity="sha512-FOhq9HThdn7ltbK8abmGn60A/EMtEzIzv1rvuh+DqzJtSGq8BRdEN0U+j0iKEIffiw/yEtVuladk6rsG4X6Uqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

    function removeAttachement(id){
        $.ajax({
            type : "GET",
            url  : "{{route('deleteAttachements')}}",
            data : {
                'id' : id,
            },
            success : function(res){
                if(res.success == true){
                    $("#attachment_"+id).remove();
                }
            },
            error   : function(res){

            }
        });
    }

    $.ajax({
        type : "GET",
        url  : "{{route('restaurantName')}}",
        data : {
            'id' : '{{$document->restaurant_id}}',
        },
        success : function(res){
            $("#restaurantName").val(res.name)
        },
        error : function(res){

        }

    });

     $("#form").validate({

        submitHandler: function(form) {
            form.submit();
        },
    });

    $('.select_2').select2();

    Dropzone.autoDiscover = false;
    file_count.num=0;
    function file_count(){
        return file_count.num++;
    }
    var serverUploadPath="remarks";
    $(function(){
        //Dropzone class
        var myDropzone = new Dropzone(".dropzone", {
            url: "{{route('dropZone')}}",
            paramName: "file",
            type:'POST',
            maxFilesize: 64,
            headers: {'X-CSRF-TOKEN':"{{ csrf_token() }}" },
            maxFiles: 25,
            addRemoveLinks: true,
            dictRemoveFile: "Remove",
            acceptedFiles: "image/*,application/pdf",
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    formData.append("upload_path",serverUploadPath);
                    formData.append("post_id",0);
                });
            },
            beforeSend:function(){
                $(".createButton").attr('disabled',true);
            },
            success:function(file,response){
                $(".createButton").attr('disabled',false);
                $(".showUploadButton").show();
                c=file_count();
                var fileuploded = file.previewElement.querySelector("[data-dz-name]");
                fileuploded.setAttribute('path',response.file);
                $('.dropzoneFiles').append("<input type='hidden' name='files["+c+"]' id='file"+c+"' value='"+response.file+"'>");

                var btndelete = file.previewElement.querySelector(".dz-remove");
                btndelete.setAttribute("id", c);
            },
                removedfile: function(file, serverFileName)
            {

            var file_path= file.previewElement.querySelector("[data-dz-name]").getAttribute('path');
            var id = file.previewElement.querySelector(".dz-remove").getAttribute('id');
            $('#file'+id).remove();

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });
    });

    $("#restaurantCode").change(function(){
        var id = $(this).val();
        $.ajax({
            type : "GET",
            url  : "{{route('getRestaurant')}}",
            data : {
                'id' : id,
            },
            success : function(res){
                $("#restaurantName").val(res.name);
            },
            error   : function(res){

            }
        });

    });


</script>
@endpush
