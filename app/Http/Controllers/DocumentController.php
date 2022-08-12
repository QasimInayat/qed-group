<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentAttachement;
use App\Models\Restaurant;
use App\Models\TempUpload;
use Illuminate\Support\Str;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function documentType($type, Request $request){

        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => route('documents.create'), 'name' => 'Documents'],
        ];
        $data['title'] = 'Document';
        $data['heading'] = 'Add Document';
        $data['button'] = 'ADD NEW';
        $data['type'] = $type;

        if ($request->ajax()) {
            $data = Document::select('documents.*','restaurants.code','document_types.name')
                            ->join('restaurants','restaurants.id','documents.restaurant_id')
                            ->join('document_types','document_types.id','documents.document_type_id')
                            ->where('documents.document_type_id',$type)
                            ->orderBy('documents.created_at','DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('noOfDocuments', function ($row) {
                    $count = DocumentAttachement::where('document_id',$row->id)->count();
                    return '<a href="javascript:;" onClick="documentAttachements($(this))" data-id="'.$row->id.'" box-number="'.$row->box_number.'" ref-number="'.$row->ref_number.'"><span class="badge bg-primary">'.$count.'</span></a>';
                })
               ->addColumn('action', function ($row) {
                    $event = "onClick=return confirm('Are you Sure');";
                    $btn = '<a href="' . route('documents.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                            <a onClick="deleteEvent($(this))"  data-link="' . route('deleteRestaurant', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['noOfDocuments','action'])
                ->make(true);
        }

        return view('admin-portal.pages.documents.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => route('documents.create'), 'name' => 'Add Document'],
        ];
        $data['title'] = 'Document';
        $data['heading'] = 'Add Document';
        $data['button'] = 'ADD NEW';
        $data['restaurants'] = Restaurant::where('is_active', 1)->pluck('code','id')->toArray();
        $data['document_types'] = DocumentType::where('is_active', 1)->pluck('name','id')->toArray();

        if ($request->ajax()) {
            $data = Document::select('documents.*')

                            ->orderBy('documents.created_at','DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('noOfDocuments', function ($row) {
                    $count = DocumentAttachement::where('document_id',$row->id)->count();
                    return '<a href="javascript:;" onClick="documentAttachements($(this))" data-id="'.$row->id.'" box-number="'.$row->box_number.'" ref-number="'.$row->ref_number.'"><span class="badge bg-primary">'.$count.'</span></a>';
                })
               ->addColumn('action', function ($row) {
                    $event = "onClick=return confirm('Are you Sure');";
                    $btn = '<a href="' . route('documents.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                            <a onClick="deleteEvent($(this))"  data-link="' . route('deleteRestaurant', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['noOfDocuments','action'])
                ->make(true);
        }
        return view('admin-portal.pages.documents.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        if(empty($request->files)){
            return redirect()->route('documents.create')->with('error','Please upload files');
        }
        $filesName = [];
        $isUpload = [];
        $store = Document::create([
            'box_number' => $request->box_number,
            'department' => $request->department,
            'category' => $request->category,
            'date' => $request->date,
            'ref_number' => $request->ref_number,
        ]);
        if(!empty($store->id)){
            foreach($request['files'] as $index=>$file){
                $files = DocumentAttachement::create([
                    'file' => $file,
                    'document_id' => $store->id,
                    'user_id' => auth()->user()->id,
                ]);

                $filesName[] = str_replace('upload/document/','',$file);
                $isUpload[$index] = TempUpload::where('file',str_replace('upload/document/','',$file))->update(['is_upload' => 1]);
            }
            if(count($isUpload) > 0){
                $notIn = TempUpload::where('user_id',auth()->user()->id)->whereNotIn('file',$filesName)->get();
                foreach($notIn as $index=>$ni){
                    $delete = TempUpload::where('file',$ni->file)->where('is_upload', 0)->first();
                    if(File::exists(public_path('upload/document/'.$ni->file))){
                        File::delete(public_path('upload/document/'.$ni->file));
                        if(!empty($delete)){
                            $delete->delete();
                        }
                    }
                }
                DB::commit();
                return redirect()->route('documents.create')->with('success','Document Added');
            }
            DB::rollBack();
            return redirect()->route('documents.create')->with('success','Files not uploaded');
        }
        else{
            DB::rollBack();
            return redirect()->route('documents.create')->with('success','Something Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attachements = DocumentAttachement::where('document_id',$id)->get();
        return view('admin-portal.pages.documents.attachements',compact('attachements'));
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
            ['link' => route('documents.create'), 'name' => 'Add Document'],
        ];
        $data['title'] = 'Document';
        $data['heading'] = 'Edit Document';
        $data['button'] = 'UPDATE';
        $data['restaurants'] = Restaurant::where('is_active', 1)->pluck('code','id')->toArray();
        $data['document_types'] = DocumentType::where('is_active', 1)->pluck('name','id')->toArray();
        $data['document'] = Document::where('id',$id)->first();
        return view('admin-portal.pages.documents.edit',$data);
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
        DB::beginTransaction();

        $filesName = [];
        $isUpload = [];
        $update = Document::where('id',$id)->update([
            'restaurant_id' => $request->restaurant_id,
            'box_number' => $request->box_number,
            'box_quantity' => $request->box_quantity,
            'document_type_id' => $request->document_type_id,
            'year' => $request->year,
            'month' => $request->month,
            'ref_number' => $request->ref_number,
            'description' => $request->description,
        ]);
        if($update > 0){
            if(!empty($request['files'])){
                foreach($request['files'] as $index=>$file){
                    $files = DocumentAttachement::create([
                        'file' => $file,
                        'document_id' => $id,
                        'user_id' => auth()->user()->id,
                    ]);

                    $filesName[] = str_replace('upload/document/','',$file);
                    $isUpload[$index] = TempUpload::where('file',str_replace('upload/document/','',$file))->update(['is_upload' => 1]);
                }
                if(count($isUpload) > 0){
                    $notIn = TempUpload::where('user_id',auth()->user()->id)->whereNotIn('file',$filesName)->get();
                    foreach($notIn as $index=>$ni){
                        $delete = TempUpload::where('file',$ni->file)->where('is_upload', 0)->first();
                        if(File::exists(public_path('upload/document/'.$ni->file))){
                            File::delete(public_path('upload/document/'.$ni->file));
                            if(!empty($delete)){
                                $delete->delete();
                            }
                        }
                    }
                    DB::commit();
                    return redirect()->route('documents.create')->with('success','Document Updated');
                }
            }
            DB::commit();
            return redirect()->route('documents.create')->with('success','Document Updated');
        }
        else{
            DB::rollBack();
            return redirect()->route('documents.create')->with('success','Something Went Wrong');
        }
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

    public function dropZone(Request $request){
        $attachmentName = null;
        $random = Str::random(3);
        if($request->file('file')){
          $attachment = $request->file('file');
          $attachmentName = 'document'.'-'.$random . '.' . $attachment->getClientOriginalExtension();
          $attachmentPath = 'upload/document';
          $attachment->move($attachmentPath, $attachmentName);
        }
        $store = TempUpload::create([
            'file' => $attachmentName,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json(['success'=> true, 'file' => $attachmentPath.'/'.$attachmentName]);
    }


    public function getRestaurant(Request $request){
        $id = $request->id;
        $restaurant = Restaurant::where('id',$id)->first();
        return response()->json($restaurant);
    }

    public function deleteAttachements(Request $request){
        $document = DocumentAttachement::where('id',$request->id)->first();
        if(!empty($document)){
            $document->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function restaurantName(Request $request){
        $rest = Restaurant::where('id',$request->id)->first(['name']);
        if(!empty($rest)){
            return response()->json(['success' => true, 'name' => $rest->name]);
        }
        return response()->json(['success' => false]);
    }

    public function deleteRestaurant($id){
        $delete = Document::where('id',$id)->first();
        if(!empty($delete)){
            Document::where('id',$id)->delete();
            return redirect()->route('documents.create')->with('success','Document Deleted');
        }
        return redirect()->route('documents.create')->with('error','Something Went Wrong');
    }
}
