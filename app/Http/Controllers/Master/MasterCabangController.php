<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterCabangController extends Controller
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

        $data['nama_menu'] = 'Setting Cabang';

        $query = Cabang::query();

        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = '%' . strtolower($request->input('search')) . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(cabang.nama_cabang) LIKE ?', [$searchTerm]);
            });
        }

        // Ambil data subjek dengan paginate
        $data['cabang'] = $query->paginate(5);

        return view('master.cabang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Settings Cabang';

        return view('master.cabang.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Cabang::create([
            'nama_cabang' => $request->nama_cabang
        ]);
        Session::flash('success', 'Data Berhasil di tambahkan.');
        return redirect()->route('master.cabang.index');
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
        $data['nama_menu'] = 'Settings Cabang';
        $data['cabang'] = Cabang::findOrFail($id);


        return view('master.cabang.edit', $data);
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


        $menu = Cabang::findorFail($id);
        $menu->update([
            'nama_cabang' => $request->nama_cabang,
        ]);

        Session::flash('success', 'Data Berhasil di Edit.');
        return redirect()->route('master.cabang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return redirect()->route('master.cabang.index')->with('success', 'Data Berhasil di Hapus.');
    }
}
