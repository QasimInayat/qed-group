<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class RestaurantController extends Controller
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
            ['link' => route('restaurants.index'), 'name' => 'Add Restaurant'],
        ];
        $data['title'] = 'Restaurants';
        $data['heading'] = 'Add Restaurant';
        $data['button'] = 'ADD NEW';
        if ($request->ajax()) {
            $data = Restaurant::select('*');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('isActive', function ($row) {
                    $isActive = isActive($row->is_active);
                    return $isActive;
                })
               ->addColumn('action', function ($row) {
                    $event = "onClick=return confirm('Are you Sure');";
                    $btn = '<a href="' . route('restaurants.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                            <a onClick="deleteEvent($(this))"  data-link="' . route('restaurants.show', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['isActive','action'])
                ->make(true);
        }
        return view('admin-portal.pages.restaurants.index',$data);
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
            'code' => 'required|max:11',
            'is_active' => 'required'
        ]);

        $data = $request->except(['_token']);
        $store = Restaurant::create($data);
        if(!empty($store->id)){
            return redirect()->route('restaurants.index')->with('success','Restaurant Added');
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
        $restaurant =  Restaurant::where('id',$id)->first();
        if(!empty($restaurant)){
            $delete = Restaurant::where('id',$id)->delete();
            if($delete > 0){
                return redirect()->route('restaurants.index')->with('success','Restaurant Deleted');
            }
            return redirect()->route('restaurants.index')->with('error','Something Went Wrong');
        }
        return redirect()->route('restaurants.index')->with('error','Restaurant id is invalid');
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
            ['link' => route('restaurants.index'), 'name' => 'Add Restaurant'],
            ['link' => '#', 'name' => 'Edit Restaurant'],
        ];
        $data['title'] = 'Restaurants';
        $data['heading'] = 'Edit Restaurant';
        $data['button'] = 'UPDATE';
        $data['restaurant'] = Restaurant::where('id',$id)->first();
        return view('admin-portal.pages.restaurants.index',$data);
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
            'code' => 'required|max:11',
            'is_active' => 'required'
        ]);

        $data = $request->except(['_token','_method']);
        $update = Restaurant::where('id',$id)->update($data);
        if(!empty($update > 0)){
            return redirect()->route('restaurants.index')->with('success','Restaurant Updated');
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
