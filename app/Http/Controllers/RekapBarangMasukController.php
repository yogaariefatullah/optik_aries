<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\RekapBarangMasuk;
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


class RekapBarangMasukController extends Controller
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
        $data['nama_menu'] = 'Rekap Barang Masuk';
        $model = RekapBarangMasuk::query();

        $query = $model->leftJoin('cabang', 'cabang.id', '=', 'rekap_barang_masuk.cabang_id')
            ->leftJoin('barang', 'barang.id', '=', 'rekap_barang_masuk.id_barang');

        if (!empty($request->cabang)) {
            $query->where('rekap_barang_masuk.cabang_id', $request->cabang);
        }

        if (!empty($request->tgl)) {
            $query->where('rekap_barang_masuk.tanggal', $request->tgl);
        }

        $data['barang'] = $query->select(
            'rekap_barang_masuk.*',
            'cabang.id as id_cabang',
            'cabang.nama_cabang',
            'barang.id as id_barang',
            'barang.nama_barang'
        )->paginate(5);

        $data['cabang'] = Cabang::get();
        return view('rekap.index', $data);
    }
}
