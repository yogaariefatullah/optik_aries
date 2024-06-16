<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use App\Models\Cabang;
use App\Models\RekapBarangKeluar;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class RekapBarangKeluarController extends Controller
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
        $data['nama_menu'] = 'Rekap Barang Keluar';
        $model = RekapBarangKeluar::query();

        $query = $model->leftJoin('cabang', 'cabang.id', '=', 'rekap_barang_keluar.cabang_id')->
            leftJoin('barang as lensa', function ($join) {
                $join->on('rekap_barang_keluar.lensa', '=', 'lensa.id')
                    ->where('lensa.jenis', '=', 1);
            })
            ->leftJoin('barang as frame', function ($join) {
                $join->on('rekap_barang_keluar.frame', '=', 'frame.id')
                    ->where('frame.jenis', '=', 2);
            });
        if (!empty($request->cabang)) {
            $query->where('rekap_barang_keluar.cabang_id', $request->cabang);
        }
        if (!empty($request->tgl)) {
            $query->where('rekap_barang_keluar.tanggal', $request->tgl);
        }

        $data['barang'] = $query->select(
            'rekap_barang_keluar.*',
            'lensa.nama_barang as lensa_nama',
            'frame.nama_barang as frame_nama',
            'cabang.id as id_cabang',
            'cabang.nama_cabang',
        )->paginate(5);

        $data['cabang'] = Cabang::get();
        return view('rekap.index_keluar', $data);
    }
}
