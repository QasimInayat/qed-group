<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filter(Request $request){
        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => '#', 'name' => 'Advance Filter'],
        ];
        $data['title'] = 'Advance Filter';

        $query = new Document();
        if(isset($request->box_number)){
            if($request->box_number_type == '='){
                $query = $query->where('box_number',$request->box_number);
            }
            if($request->box_number_type == 'LIKE'){
                $query = $query->where('box_number','LIKE', '%'.$request->box_number.'%');
            }
        }

        if(isset($request->department)){
            if($request->department_type == '='){
                $query = $query->where('department',$request->department);
            }
            if($request->department_type == 'LIKE'){
                $query = $query->where('department','LIKE', '%'.$request->department.'%');
            }
        }

        if(isset($request->category)){
            if($request->category_type == '='){
                $query = $query->where('category',$request->category);
            }
            if($request->category_type == 'LIKE'){
                $query = $query->wherere('category','LIKE', '%'.$request->category.'%');
            }
        }

        if(isset($request->ref_number)){
            if($request->ref_number_type == '='){
                $query = $query->where('ref_number',$request->ref_number);
            }
            if($request->ref_number_type == 'LIKE'){
                $query = $query->where('ref_number','LIKE', '%'.$request->ref_number.'%');
            }
        }

        if(isset($request->start_date) && isset($request->end_date)){
            $query = $query->where('date', '>=',$request->start_date)->where('date', '<=', $request->end_date);
        }

        $query = $query->orderBy('created_at','DESC')->get();
        $data['result'] = $query;

        return view('admin-portal.pages.filter.index',$data);
    }
}
