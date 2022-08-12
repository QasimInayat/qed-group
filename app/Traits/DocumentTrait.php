<?php

namespace App\Traits;
use Exception;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentAttachement;
use Yajra\DataTables\Facades\DataTables;


trait DocumentTrait {

  public function document($type) {

      try{
        dd('check');
            $data = Document::select('documents.*','restaurants.code','document_types.name')
                    ->join('restaurants','restaurants.id','documents.restaurant_id')
                    ->join('document_types','document_types.id','documents.document_type_id');
            if(!empty($type)){
                $data = $data->where('documents.document_type_id',$type);
            }
            $data = $data->orderBy('documents.created_at','DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('noOfDocuments', function ($row) {
                $count = DocumentAttachement::where('document_id',$row->id)->count();
                return $count;
            })
                ->addColumn('action', function ($row) {
                $event = "onClick=return confirm('Are you Sure');";
                $btn = '<a href="' . route('documents.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                        <a onClick="deleteEvent($(this))"  data-link="' . route('documents.show', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';
                return $btn;
            })
            ->rawColumns(['noOfDocuments','action'])
            ->make(true);
      }
      catch(Exception $e){
        return null;
      }
  }


}
