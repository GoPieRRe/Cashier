<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Alert;
use DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = User::where('level', '1');
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = 
                    '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="">
                        <form action="account/'.$row->id.'" method="POST">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                            <li><a href="account/'.$row->id.'" class="dropdown-item" data-confirm-delete="true">Delete</a></li>
                        </form>
                        </ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        confirmDelete('Delete User?', 'Are you sure you want to delete');
        return view('account.index');
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
        // dd($request);
        $check = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);


        switch ($check) {
            case true:
                if ($request->password != $request->confirm_password) {
                    toast('Password and confirm password must be the same!', 'error');
                    return back()->withInput();
                }else{

                    $result = 
                        User::create([
                            'name' => $request->name,
                            'email' => $request->name . $request->email,
                            'password' => Hash::make($request->password),
                            'level' => 1
                        ]);
                        if ($result) {
                            Alert::success('successful data input!', 'Success');
                            return back();
                        }else{
                            Alert::error('unsuccessful data input!', 'Error');
                            return back();
                        }
                }
                break;
            
            default:
            Alert::error('error input', 'error');
                return back();
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = User::findOrFail($id);
        // return response()->Json([
        //     'data' => $user
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $result = $user->delete();

        if ($result) {
            Alert::success('Data deleted!');
            return back();
        }
    }
}
