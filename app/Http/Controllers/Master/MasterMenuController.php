<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterMenuController extends Controller
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
        
        $data['nama_menu'] = 'Settings Menu';

        $query = Menu::query();

        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $query
            ->where('url', 'ilike', '%' . $request->input('search') . '%')
            ->Orwhere('url', 'ilike', '%' . $request->input('search') . '%')
            ->where('name', 'ilike', '%' . $request->input('search') . '%')
            ->Orwhere('name', 'ilike', '%' . $request->input('search') . '%');
            
        }
    
        // Ambil data subjek dengan paginate
        $data['menu'] = $query->paginate(5);
        
        return view('master.menu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Settings Menu';

        $data['parent'] = Menu::where('url','#')->orWhere('parent_id',0)->get();
        
        return view('master.menu.add',$data);

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
            'name' => "required",
            ]);
            // dd($request->all());
        Menu::create([
            'name' => $request->name,
            'url' => ($request->url == null)? "#": $request->url,
            'urutan' => $request->urutan,
            'parent_id' => ($request->parent_id == null)? 0 : $request->parent_id,
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('master.menu.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['nama_menu'] = 'Settings Menu';
        $data['menu'] = Menu::findOrFail($id);

        $data['parent'] = Menu::where('url','#')->orWhere('parent_id',0)->get();
        
        return view('master.menu.edit',$data);
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
            'name' => "required"
            ]);
        
        $menu = Menu::findorFail($id);  

        $menu->update([
            'name' => $request->name,
            'url' => ($request->url == null)? "#": $request->url,
            'urutan' => $request->urutan,
            'parent_id' => ($request->parent_id == null)? 0 : $request->parent_id,
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.'); 
        return redirect()->route('master.menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('master.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
