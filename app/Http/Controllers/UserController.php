<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['breadcrumbs'] = [
            ['link' => route('home'), 'name' => 'Dashboard'],
            ['link' => route('users.index'), 'name' => 'Add User'],
        ];
        $data['title'] = 'Users';
        $data['heading'] = 'Add User';
        $data['button'] = 'ADD NEW';
        if ($request->ajax()) {
            $data = User::select('*');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('isActive', function ($row) {
                    $isActive = isActive($row->is_active);
                    return $isActive;
                })
                ->addColumn('role', function ($row) {
                    if($row->role_id == 1){
                        return 'Admin';
                    }
                    elseif($row->role_id == 2){
                        return 'Employee';
                    }
                    else{
                        return null;
                    }
                })
               ->addColumn('action', function ($row) {
                    $event = "onClick=return confirm('Are you Sure');";
                    $btn = '<a href="' . route('users.edit', $row->id) . '" ><i class="fa fa-edit text-success"></i></a>&nbsp;
                            <a onClick="deleteEvent($(this))"  data-link="' . route('users.show', $row->id)    . '" ><i class="fa fa-trash text-danger"></i></a>';

                    return $btn;
                })
                ->rawColumns(['isActive','action'])
                ->make(true);
        }
        return view('admin-portal.pages.users.index',$data);
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
            'email' => 'required|max:191|unique:users,email',
            'phone' => 'max:20|unique:users,phone',
            'psw' => 'required|min:8|max:20',
            'role_id' => 'required',
            'is_active' => 'required'
        ]);

        $request->merge(['password' => Hash::make('psw')]);
        $data = $request->except(['_token','psw']);
        $store = User::create($data);
        if(!empty($store->id)){
            return redirect()->route('users.index')->with('success','User Added');
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
        $user =  User::where('id',$id)->first();
        if(!empty($user)){
            $delete = User::where('id',$id)->delete();
            if($delete > 0){
                return redirect()->route('users.index')->with('success','User Deleted');
            }
            return redirect()->route('users.index')->with('error','Something Went Wrong');
        }
        return redirect()->route('users.index')->with('error','User id is invalid');
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
            ['link' => route('users.index'), 'name' => 'Add User'],
            ['link' => '#', 'name' => 'Edit User'],
        ];
        $data['title'] = 'Users';
        $data['heading'] = 'Edit User';
        $data['button'] = 'UPDATE';
        $data['user'] = User::where('id',$id)->first();
        return view('admin-portal.pages.users.index',$data);
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
            'email' => 'required|max:191|unique:users,email,'.$id,
            'phone' => 'max:20',
            'role_id' => 'required',
            'is_active' => 'required'
        ]);

        $update = User::where('id',$id)->first();
        $update->name = $request->name;
        $update->email = $request->email;
        if(isset($request->psw)){
            $update->password = Hash::make($request->psw);
        }
        $update->phone = $request->phone;
        $update->is_active = $request->is_active;
        $update->role_id = $request->role_id;
        $update->save();

        if(!empty($update)){
            return redirect()->route('users.index')->with('success','User Updated');
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
