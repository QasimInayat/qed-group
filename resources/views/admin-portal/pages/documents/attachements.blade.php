@foreach($attachements as $index=>$attach)
    <div class="col-md-3 border text-center p-1">
        <a href="{{asset($attach->file)}}" target="_blank">
            <i class="fa fa-file-pdf-o" style="font-size:50px"></i><br>
            <span>{{str_replace('upload/document/','',$attach->file)}}</span>
        </a>
    </div>
@endforeach