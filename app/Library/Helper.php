<?php

use App\Models\DocumentType;
use App\Models\DocumentAttachement;

function activeInActive(){
    return $arr = [
        1 => 'Active',
        0 => 'Inactive',
    ];
}
function isActive($status){
    $html = "";
    if($status == 1){
        $html = '<span class="badge bg-success">Active</span>';
    }
    elseif($status == 0){
        $html = '<span class="badge bg-danger">InActive</span>';
    }
    else{
        $html = '<span class="badge bg-secondary">Pending</span>';
    }
    return $html;
}
function documentTypes(){
    $documentTypes = DocumentType::where('is_active',1)->get();
    if(!empty($documentTypes)){
        return $documentTypes;
    }
    return  null;
}
function months(){
    $arr = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];
    return $arr;
}
function  documentAttachments($id){
    $attach = DocumentAttachement::where('document_id',$id)->get();

    $html = '';
    foreach($attach as $index=>$a){
        $html.='<a href="'.asset($a->file).'" target="_blank">'.str_replace('upload/document/','',$a->file).'</a>&nbsp;|&nbsp;';
    }
    return $html;
}

