<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Alert;
use DataTables;
use DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $img = '<img src="'. asset("storage/images/menu/".$row->image).'" alt="'.$row->name.'" class="d-block rounded" height="100" width="100">';
                    return $img;
                })
                ->addColumn('discount', function ($row) {
                    return $row->discount . ' %';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == true) {
                        $badge = '<span class="badge bg-success">Active</span>';
                    }else{
                        $badge = '<span class="badge bg-danger">Non Active</span>';
                    }
                    return $badge;
                })
                ->addColumn('action', function($row){
                    if ($row->status == true) {
                        $status = "Deactive status";
                    }else{
                        $status = "Activate status";
                    }

                    $btn = 
                    '<div class="btn-group">
                        <button type="button" class="btn btn-primary btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><button class="dropdown-item edit-button" type="button" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#editMenu">Edit</button>
                        <form action="menu/'.$row->id.'" method="POST">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                            <li><a href="menu/'.$row->id.'/statusUpdate" class="dropdown-item">'.$status.'</a></li>
                            <li><a href="menu/'.$row->id.'" class="dropdown-item" data-confirm-delete="true">Delete</a></li>
                        </form>
                        </ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action','image', 'discount','status'])
                ->make(true);
        }
        confirmDelete('Delete Menu?', 'Are you sure you want to delete');
        
        return view('menu.index');
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
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'menu_name' => 'required',
            'price' => 'required',
            'type' => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $img_name = $request->menu_name . '.' . $extension;

            if ($request->discount == 0 || null) {
                $price = $request->price;
                $discount = 0;
            }else{
                $price = $request->total_price;
                $discount = $request->discount;
            }

            if ($request->status == null) {
                $status = 0;
            }else{
                $status = $request->boolean('status');
            }

            $results = Menu::create([
                'name' => $request->menu_name,
                'image' => $img_name,
                'price' => $request->price,
                'total_price' => $price,
                'discount' => $discount,
                'type' => $request->type,
                'status' => $status
            ]);
            if ($results) {
                $path = $image->storeAs('public/images/menu', $img_name);
                return redirect()->back()->with('success', 'data insert successfully');
            }
    
        }
    
        return response()->json(['error' => 'No image file found']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Menu::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $result = $menu->delete();

            if ($result) {
            toast('Deleted menu success', 'success');
            return back();
        }
        toast('Deleted menu error', 'error');
        return back();
    }
    
    function statusUpdate($id) {
        $menu = Menu::findOrFail($id);
        
        if ($menu->status == true) {
            $status = false;
        }else{
            $status = true;
        }
        $result = DB::table('menus')->where('id',$id)->update([
            'status' => $status
        ]);
        
        if ($result) {
            toast('status update successfully', 'success');
            return back();
        }
        
        toast('status update unsuccessfully', 'error');
        return back();
    }
}