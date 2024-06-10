<?php

namespace App\Http\Controllers;

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
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class TransaksiController extends Controller
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

        $data['nama_menu'] = 'Transaksi';

        $query = Transaksi::leftJoin('barang as lensa', function ($join) {
            $join->on('transaksi.lensa_id', '=', 'lensa.id')
                ->where('lensa.jenis', '=', 1);
        })
            ->leftJoin('barang as frame', function ($join) {
                $join->on('transaksi.frame_id', '=', 'frame.id')
                    ->where('frame.jenis', '=', 2);
            })
            ->select(
                'transaksi.id',
                'transaksi.nama',
                'transaksi.no_transaksi',
                'transaksi.resep_dr',
                'lensa.nama_barang as lensa_nama',
                'frame.nama_barang as frame_nama'
            );

        if ($request->has('search')) {
            $searchTerm = '%' . strtolower($request->input('search')) . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(lensa.nama_barang) LIKE ?', [$searchTerm])
                    ->orwhereRaw('LOWER(frame.nama_barang) LIKE ?', [$searchTerm])
                    ->orwhereRaw('LOWER(transaksi.nama) LIKE ?', [$searchTerm])
                    ->orwhereRaw('LOWER(transaksi.no_transaksi) LIKE ?', [$searchTerm])
                    ->orwhereRaw('LOWER(transaksi.no_telp) LIKE ?', [$searchTerm])
                    ->orwhereRaw('LOWER(transaksi.resep_dr) LIKE ?', [$searchTerm]);
            });
        }

        // Ambil data subjek dengan paginate
        $data['transaksi'] = $query->where('transaksi.id_cabang', Auth::user()->cabang_id)->paginate(5);

        return view('transaksi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Transaksi';
        $data['data_lensa'] = Barang::where('jenis', 1)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        $data['data_frame'] = Barang::where('jenis', 2)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        $data['no_transaksi'] = Transaksi::where('id_cabang', Auth::user()->cabang_id)->max('no_transaksi');
        return view('transaksi.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frame = Barang::where('jenis', 2)->where('id', $request->frame_id)->first();
        $lensa = Barang::where('jenis', 1)->where('id', $request->lensa_id)->first();
        $no_transaksi = Transaksi::where('id_cabang', Auth::user()->cabang_id)->max('no_transaksi');
        if ($frame) {
            if ($frame->jumlah_stok < 1) {
                Session::flash('error', 'Stok Frame tidak ada');
                return redirect()->route('transaksi.index');
            }
        }

        if ($lensa) {
            if ($lensa->jumlah_stok < 1) {
                Session::flash('error', 'Stok Lensa tidak ada');
                return redirect()->route('transaksi.index');
            }
        }
        Transaksi::create([
            'spher_od' => $request->spher_od,
            'cylders_od' => $request->cylders_od,
            'axis_od' => $request->axis_od,
            'prism_od' => $request->prism_od,
            'base_od' => $request->base_od,
            'add_od' => $request->add_od,
            'pd_od' => $request->pd_od,

            'spher_os' => $request->spher_os,
            'cylders_os' => $request->cylders_os,
            'axis_os' => $request->axis_os,
            'prism_os' => $request->prism_os,
            'base_os' => $request->base_os,
            'add_os' => $request->add_os,
            'tseg_os' => $request->tseg_os,

            'lensa_id' => $request->lensa_id,
            'frame_id' => $request->frame_id,
            'tanggal_selesai' => date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_selesai))),
            'order_tanggal' => date("Y-m-d", strtotime(str_replace('/', '-', $request->order_tanggal))),
            'lain_lain' => $request->lain_lain,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jam' => $request->jam,
            'no_telp' => $request->no_telp,
            'resep_dr' => $request->resep_dr,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'uang_muka' => str_replace(',', '', $request->uang_muka),
            'sisa' => str_replace(',', '', $request->sisa),
            'no_transaksi' => $no_transaksi ? $no_transaksi + 1 : 1,
            'id_cabang' => Auth::user()->cabang_id
        ]);
        Barang::where('jenis', 2)->where('id', $request->frame_id)->update([
            'jumlah_stok' => $frame->jumlah_stok - 1
        ]);
        Barang::where('jenis', 1)->where('id', $request->lensa_id)->update([
            'jumlah_stok' => $lensa->jumlah_stok - 1
        ]);

        Session::flash('success', 'Data Berhasil di tambahkan.');
        return redirect()->route('transaksi.index');
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
        $data['nama_menu'] = 'Transaksi';
        $data['data_lensa'] = Barang::where('jenis', 1)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        $data['data_frame'] = Barang::where('jenis', 2)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        // $data['no_transaksi'] = Transaksi::where('id_cabang',Auth::user()->cabang_id)->max('no_transaksi');
        $data['transaksi'] = Transaksi::find($id);
        $data['text_lensa'] = Barang::where('id', $data['transaksi']->lensa_id)->first();
        $data['text_frame'] = Barang::where('id', $data['transaksi']->frame_id)->first();



        return view('transaksi.edit', $data);
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
        $lensa_old = $request->lensa_old;
        $frame_old = $request->frame_old;
        if ($request->lensa_id != $lensa_old) {
            $stock_old = Barang::where('id', $lensa_old)->first();
            Barang::where('id', $lensa_old)->update([
                'jumlah_stok' => $stock_old->jumlah_stok + 1
            ]);


            Barang::where('id', $request->lensa_id)->update([
                'jumlah_stok' => $stock_old->jumlah_stok - 1
            ]);
        }


        if ($request->frame_id != $frame_old) {
            $stock_old = Barang::where('id', $frame_old)->first();
            Barang::where('id', $frame_old)->update([
                'jumlah_stok' => $stock_old->jumlah_stok + 1
            ]);

            Barang::where('id', $request->frame_id)->update([
                'jumlah_stok' => $stock_old->jumlah_stok - 1
            ]);
        }

        Transaksi::where('id', $id)->update([
            'spher_od' => $request->spher_od,
            'cylders_od' => $request->cylders_od,
            'axis_od' => $request->axis_od,
            'prism_od' => $request->prism_od,
            'base_od' => $request->base_od,
            'add_od' => $request->add_od,
            'pd_od' => $request->pd_od,

            'spher_os' => $request->spher_os,
            'cylders_os' => $request->cylders_os,
            'axis_os' => $request->axis_os,
            'prism_os' => $request->prism_os,
            'base_os' => $request->base_os,
            'add_os' => $request->add_os,
            'tseg_os' => $request->tseg_os,

            'lensa_id' => $request->lensa_id,
            'frame_id' => $request->frame_id,
            'tanggal_selesai' => date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_selesai))),
            'order_tanggal' => date("Y-m-d", strtotime(str_replace('/', '-', $request->order_tanggal))),
            'lain_lain' => $request->lain_lain,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jam' => $request->jam,
            'no_telp' => $request->no_telp,
            'resep_dr' => $request->resep_dr,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'uang_muka' => str_replace(',', '', $request->uang_muka),
            'sisa' => str_replace(',', '', $request->sisa),

        ]);

        Session::flash('success', 'Data Berhasil di Edit.');
        return redirect()->route('transaksi.index');
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
        $transaksi = Transaksi::findOrFail($id);
        $lensa = Barang::find($transaksi->lensa_id);
        $lensa->update([
            'jumlah_stok' => $lensa->jumlah_stok + 1
        ]);
        $frame = Barang::find($transaksi->frame_id);
        $frame->update([
            'jumlah_stok' => $frame->jumlah_stok + 1
        ]);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data Berhasil di Hapus.');
    }
}
