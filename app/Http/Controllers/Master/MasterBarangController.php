<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use App\Models\Cabang;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterBarangController extends Controller
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

        $data['nama_menu'] = 'Setting Barang';

        $model = Barang::query();
        $query = $model->leftjoin('cabang', 'cabang.id', 'barang.cabang');

        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = '%' . strtolower($request->input('search')) . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(barang.jumlah_stok) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(barang.kode_barang) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(barang.nama_barang) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(cabang.nama_cabang) LIKE ?', [$searchTerm]);
            });
        }

        // Ambil data subjek dengan paginate
        $data['barang'] = $query->select('barang.*', 'cabang.id as id_cabang', 'cabang.nama_cabang')->paginate(5);

        return view('master.barang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Settings Barang';
        $data['cabang'] = Cabang::get();

        return view('master.barang.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Barang::where('kode_barang', $request->kode_barang)->count();
        // dd($cek);
        if ($cek > 0) {
            Session::flash('error', 'Kode Barang Sudah Ada.');
            return redirect()->route('master.barang.index');
        } else {
            Barang::create([
                'kode_barang' => $request->kode_barang,
                'jumlah_stok' => $request->jumlah_stok,
                'harga_jual' => $request->harga_jual,
                'harga_asli' => $request->harga_asli,
                'nama_barang' => $request->nama_barang,
                'cabang' => $request->cabang
            ]);
            Session::flash('success', 'Data Berhasil di tambahkan.');
            return redirect()->route('master.barang.index');
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
        $data['nama_menu'] = 'Settings Barang';
        $data['barang'] = Barang::findOrFail($id);
        $data['cabang'] = Cabang::get();


        return view('master.barang.edit', $data);
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

        $cek = Barang::where('kode_barang', $request->kode_barang)->whereNotIn('id', [$id])->count();
        $menu = Barang::findorFail($id);
        if ($cek > 0) {
            Session::flash('error', 'Kode Barang Sudah Ada.');
            return redirect()->route('master.barang.index');
        } else {
            $menu->update([
                'kode_barang' => $request->kode_barang,
                'jumlah_stok' => $request->jumlah_stok,
                'harga_jual' => $request->harga_jual,
                'harga_asli' => $request->harga_asli,
                'nama_barang' => $request->nama_barang,
                'cabang' => $request->cabang
            ]);
            Session::flash('success', 'Data Berhasil di tambahkan.');
            return redirect()->route('master.barang.index');
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
        // dd($id);
        $cabang = Barang::findOrFail($id);
        $cabang->delete();

        return redirect()->route('master.barang.index')->with('success', 'Menu berhasil dihapus.');
    }
}
