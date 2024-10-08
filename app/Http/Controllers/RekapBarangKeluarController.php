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
use App\Exports\RekapKeluarExport;
use Maatwebsite\Excel\Facades\Excel;


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

        $query = $model->leftJoin('cabang', 'cabang.id', '=', 'rekap_barang_keluar.cabang_id')->leftJoin('barang as lensa', function ($join) {
            $join->on('rekap_barang_keluar.lensa', '=', 'lensa.id')
                ->where('lensa.jenis', '=', 1);
        })
            ->leftJoin('barang as frame', function ($join) {
                $join->on('rekap_barang_keluar.frame', '=', 'frame.id')
                    ->where('frame.jenis', '=', 2);
            })
            ->leftJoin('barang as lensa_kiri', function ($join) {
                $join->on('rekap_barang_keluar.lensa_id_kiri', '=', 'lensa_kiri.id')
                    ->where('lensa_kiri.jenis', '=', 1);
            })
            ->join('transaksi', 'transaksi.id', 'rekap_barang_keluar.id_transaksi');
        if (Auth::user()->cabang_id == 0) {
            if (!empty($request->cabang)) {
                $query->where('rekap_barang_keluar.cabang_id', $request->cabang);
            }
        } else {
            $query->where('rekap_barang_keluar.cabang_id', Auth::user()->cabang_id);
        }
        if (!empty($request->tgl)) {
            $query->where('rekap_barang_keluar.tanggal', $request->tgl);
        }

        $data['barang'] = $query->select(
            'rekap_barang_keluar.*',
            'transaksi.no_telp',
            'lensa.nama_barang as lensa_nama',
            'lensa_kiri.nama_barang as lensa_nama_kiri',
            'frame.nama_barang as frame_nama',
            'lensa.harga_asli as lensa_harga',
            'frame.harga_asli as frame_harga',
            'lensa_kiri.harga_asli as lensa_kiri_harga',
            'cabang.id as id_cabang',
            'cabang.nama_cabang',
        )->paginate(5);

        $data['cabang'] = Cabang::get();
        return view('rekap.index_keluar', $data);
    }
    public function excels(Request $request)
    {
        $dates = $request->tgl ? $request->tgl : null;
        $cabang_export = $request->cabang_export ? $request->cabang_export : null;
        return Excel::download(new RekapKeluarExport($dates, $cabang_export), 'rekap_barang_keluar.xlsx');
    }
}
