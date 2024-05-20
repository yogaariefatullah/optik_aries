<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Menu;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data['nama_menu'] = 'Settings Group';
        $query = Group::query();

        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $query
            ->where('name', 'ilike', '%' . $request->input('search') . '%')
            ->Orwhere('name', 'ilike', '%' . $request->input('search') . '%');
            
        }
        $query->whereNull('deleted_at');
    
        // Ambil data subjek dengan paginate
        $data['group'] = $query->paginate(5);
        
        return view('master.group.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['nama_menu'] = 'Settings Group';
        $data['group'] = Group::FindorFail($id);
        $data['menu']  = Menu::orderBy('urutan', 'asc')->get();
        $data['id_group'] = $id;
        return view('master.group.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $arr = array();
            
        foreach ($request->id_menu as $key => $id_menu) {
            $wj = "create".$id_menu;
            $wj2 = "read".$id_menu;
            $wj3 = "update".$id_menu;
            $wj4 = "delete".$id_menu;
            $wj5 = "view".$id_menu;
            $wx = $request->$wj;
            $wx2 = $request->$wj2;
            $wx3 = $request->$wj3;
            $wx4 = $request->$wj4;
            $wx5 = $request->$wj5;
            array_push($arr,array("group_id" => $id,
                                "menu_id" => $id_menu,
                                "c" => $wx,
                                "r" => $wx2,
                                "u" => $wx3,
                                "d" => $wx4,
                                "v" => $wx5,
                                "created_at" => date('Y-m-d')));
        }
        //dd($arr);
        Permission::where('group_id',$id)->delete();
        Permission::insert($arr);	
        return redirect()->route('master.group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    }
}
