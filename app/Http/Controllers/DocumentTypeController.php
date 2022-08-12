<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => route('document-types.index'), 'name' => 'Add Document Type'],
        ];
        $data['title'] = 'Document Type';
        $data['heading'] = 'Add Document Type';
        $data['button'] = 'ADD NEW';
        if ($request->ajax()) {
            $data = DocumentType::select('*');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('isActive', function ($row) {
                    $isActive = isActive($row->is_active);
                    return $isActive;
                })
               ->addColumn('action', function ($row) {
                    $event = "onClick=return confirm('Are you Sure');";
                    $btn = '<a href="' . route('document-types.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                            <a onClick="deleteEvent($(this))"  data-link="' . route('document-types.show', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['isActive','action'])
                ->make(true);
        }
        return view('admin-portal.pages.document-types.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'is_active' => 'required'
        ]);

        $data = $request->except(['_token']);
        $store = DocumentType::create($data);
        if(!empty($store->id)){
            return redirect()->route('document-types.index')->with('success','Document Type Added');
        }
        return redirect()->route('error','Something Went Wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documentType =  DocumentType::where('id',$id)->first();
        if(!empty($documentType)){
            $delete = DocumentType::where('id',$id)->delete();
            if($delete > 0){
                return redirect()->route('document-types.index')->with('success','Document Type Deleted');
            }
            return redirect()->route('document-types.index')->with('error','Something Went Wrong');
        }
        return redirect()->route('document-types.index')->with('error','Document Type id is invalid');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => route('document-types.index'), 'name' => 'Add Document Type'],
            ['link' => '#', 'name' => 'Edit Document Type'],
        ];
        $data['title'] = 'Document Type';
        $data['heading'] = 'Edit Document Type';
        $data['button'] = 'UPDATE';
        $data['documentType'] = DocumentType::where('id',$id)->first();
        return view('admin-portal.pages.document-types.index',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:191',
            'is_active' => 'required'
        ]);

        $data = $request->except(['_token','_method']);
        $update = DocumentType::where('id',$id)->update($data);
        if(!empty($update > 0)){
            return redirect()->route('document-types.index')->with('success','Document Type Updated');
        }
        return redirect()->route('error','Something Went Wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
