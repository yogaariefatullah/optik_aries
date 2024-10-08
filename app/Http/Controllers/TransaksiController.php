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
use App\Models\RekapBarangKeluar;
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
            ->leftJoin('barang as lensa_kiri', function ($join) {
                $join->on('transaksi.lensa_id_kiri', '=', 'lensa_kiri.id')
                    ->where('lensa_kiri.jenis', '=', 1);
            })
            ->select(
                'transaksi.id',
                'transaksi.status_pelunasan',
                'transaksi.nama',
                'transaksi.no_transaksi',
                'transaksi.resep_dr',
                'lensa.nama_barang as lensa_nama',
                'lensa_kiri.nama_barang as lensa_kiri',
                'frame.nama_barang as frame_nama'
            )->where(function ($query) {
                $query->where('transaksi.status_pelunasan', '!=', 1)
                    ->orWhereNull('transaksi.status_pelunasan');
            });

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

    public function pelunasan(Request $request)
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
            ->leftJoin('barang as lensa_kiri', function ($join) {
                $join->on('transaksi.lensa_id_kiri', '=', 'lensa_kiri.id')
                    ->where('lensa_kiri.jenis', '=', 1);
            })
            ->select(
                'transaksi.id',
                'transaksi.status_pelunasan',
                'transaksi.nama',
                'transaksi.no_transaksi',
                'transaksi.resep_dr',
                'lensa.nama_barang as lensa_nama',
                'lensa_kiri.nama_barang as lensa_kiri',
                'frame.nama_barang as frame_nama'
            )->where('transaksi.status_pelunasan', 1);

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
        // dd($request->uang_muka);
        $transaksi = Transaksi::create([
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
            'lensa_id_kiri' => $request->lensa_id_kiri,
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
            'id_cabang' => Auth::user()->cabang_id,
            'diskon' => str_replace(',', '', $request->diskon)
        ]);
        if ($frame) {
            Barang::where('jenis', 2)->where('id', $request->frame_id)->update([
                'jumlah_stok' => $frame->jumlah_stok - 1
            ]);
        }
        if ($lensa) {
            Barang::where('jenis', 1)->where('id', $request->lensa_id)->update([
                'jumlah_stok' => $lensa->jumlah_stok - 1
            ]);
        }
        RekapBarangKeluar::insert([
            'tanggal' => date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_selesai))),
            'lensa' => $request->lensa_id,
            'frame' => $request->frame_id,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'keterangan' => $request->lain_lain,
            'cabang_id' => Auth::user()->cabang_id,
            'id_transaksi' => $transaksi->id,
            'diskon' => str_replace(',', '', $request->diskon),
            'lensa_id_kiri' => $request->lensa_id_kiri,
        ]);

        Session::flash('success', 'Data Berhasil di tambahkan.');
        Session::flash('new-id', $transaksi->id);
        return redirect()->route('transaksi.index')->with('open_new_tab', true);
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
        $data['transaksi'] = Transaksi::find($id);  // Ambil transaksi berdasarkan ID
        $data['data_lensa'] = Barang::where('jenis', 1)
            ->where('jumlah_stok', '>', 0)
            ->where('cabang', Auth::user()->cabang_id)
            ->get();

        // Cek apakah lensa dari transaksi ada di daftar $data_lensa
        $lensa_id = $data['transaksi']->lensa_id;
        if (!$data['data_lensa']->pluck('id')->contains($lensa_id)) {
            // Jika lensa_id dari transaksi tidak ada di $data_lensa, cari langsung dari tabel Barang
            $data['lensa_habis'] = Barang::find($lensa_id);
        }

        $lensa_id_kiri = $data['transaksi']->lensa_id_kiri;
        if (!$data['data_lensa']->pluck('id')->contains($lensa_id_kiri)) {
            // Jika lensa_id_kiri dari transaksi tidak ada di $data_lensa, cari langsung dari tabel Barang
            $data['lensa_kiri_habis'] = Barang::find($lensa_id_kiri);
        }
        // $data['no_transaksi'] = Transaksi::where('id_cabang',Auth::user()->cabang_id)->max('no_transaksi');


        $data['data_frame'] = Barang::where('jenis', 2)
            ->where('jumlah_stok', '>', 0)
            ->where('cabang', Auth::user()->cabang_id)
            ->get();
        $frame_id = $data['transaksi']->frame_id;
        if (!$data['data_frame']->pluck('id')->contains($frame_id)) {
            // Jika frame_id dari transaksi tidak ada di $data_frame, cari langsung dari tabel Barang
            $data['frame_habis'] = Barang::find($frame_id);
        }
        $data['text_lensa'] = Barang::where('id', $data['transaksi']->lensa_id)->first();
        $data['text_lensa_kiri'] = Barang::where('id', $data['transaksi']->lensa_id_kiri)->first();
        $data['text_frame'] = Barang::where('id', $data['transaksi']->frame_id)->first();
        // dd(Auth::user()->cabang_id);



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

        $transaksi = Transaksi::find($id);
        $frame_old = $transaksi->frame_id;
        $frame_new = $request->frame_id;

        $lensa_old = $transaksi->lensa_id;  // Lensa ID sebelum di-edit
        $lensa_new = $request->lensa_id;    // Lensa ID setelah di-edit
        // $frame_old = $request->frame_old;
        if ($lensa_new != $lensa_old) {
            // Pengembalian stok lensa lama (lensa_old)
            if (!is_null($lensa_old)) {
                $stock_old = Barang::where('id', $lensa_old)->first();
                if ($stock_old) {
                    Barang::where('id', $lensa_old)->update([
                        'jumlah_stok' => $stock_old->jumlah_stok + 1  // Tambah stok karena lensa lama dikembalikan
                    ]);
                }
            }

            // Pengurangan stok lensa baru (lensa_new)
            if (!is_null($lensa_new)) {
                $stock_new = Barang::where('id', $lensa_new)->first();
                if ($stock_new && $stock_new->jumlah_stok > 0) {
                    Barang::where('id', $lensa_new)->update([
                        'jumlah_stok' => $stock_new->jumlah_stok - 1  // Kurangi stok karena lensa baru dipilih
                    ]);
                }
            }
        }
        // Frame ID setelah di-edit
        if ($frame_new != $frame_old) {
            // Pengembalian stok frame lama (frame_old)
            if (!is_null($frame_old)) {
                $stock_old = Barang::where('id', $frame_old)->first();
                if ($stock_old) {
                    Barang::where('id', $frame_old)->update([
                        'jumlah_stok' => $stock_old->jumlah_stok + 1  // Tambah stok karena frame lama dikembalikan
                    ]);
                }
            }

            // Pengurangan stok frame baru (frame_new)
            if (!is_null($frame_new)) {
                $stock_new = Barang::where('id', $frame_new)->first();
                if ($stock_new && $stock_new->jumlah_stok > 0) {
                    Barang::where('id', $frame_new)->update([
                        'jumlah_stok' => $stock_new->jumlah_stok - 1  // Kurangi stok karena frame baru dipilih
                    ]);
                }
            }
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
            'diskon' => str_replace(',', '', $request->diskon),

        ]);

        RekapBarangKeluar::where('id_transaksi', $id)->update([
            'tanggal' => date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_selesai))),
            'lensa' => $request->lensa_id,
            'lensa_id_kiri' => $request->lensa_id_kiri,
            'frame' => $request->frame_id,
            'jumlah' => str_replace(',', '', $request->jumlah),
            'diskon' => str_replace(',', '', $request->diskon),
            'keterangan' => $request->lain_lain,
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
        if ($lensa) {
            $lensa->update([
                'jumlah_stok' => $lensa->jumlah_stok + 1
            ]);
        }
        $frame = Barang::find($transaksi->frame_id);
        if ($frame) {
            $frame->update([
                'jumlah_stok' => $frame->jumlah_stok + 1
            ]);
        }
        $rekapkeluar = RekapBarangKeluar::where('id_transaksi', $id)->first();

        $rekapkeluar->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data Berhasil di Hapus.');
    }
    public function statusPelunasan($id)
    {
        $transaksi = Transaksi::where('id', $id)->first();
        // dd($transaksi);
        if ($transaksi->status_pelunasan == null || $transaksi->status_pelunasan == 0) {
            Transaksi::where('id', $id)->update([
                'status_pelunasan' => 1
            ]);
        } else {
            Transaksi::where('id', $id)->update([
                'status_pelunasan' => 0
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Data Berhasil di Ubah.');
    }
    public function print($id)
    {

        $data['data_lensa'] = Barang::where('jenis', 1)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        $data['data_frame'] = Barang::where('jenis', 2)->where('jumlah_stok', '>', 0)->where('cabang', Auth::user()->cabang_id)->get();
        // $data['no_transaksi'] = Transaksi::where('id_cabang',Auth::user()->cabang_id)->max('no_transaksi');
        $data['transaksi'] = Transaksi::find($id);
        $data['text_lensa'] = Barang::where('id', $data['transaksi']->lensa_id)->first();
        $data['text_lensa_kiri'] = Barang::where('id', $data['transaksi']->lensa_id_kiri)->first();
        $data['text_frame'] = Barang::where('id', $data['transaksi']->frame_id)->first();
        // $pdf = PDF::loadView('print_template', $data);
        // return $pdf->download('contoh.pdf');

        return view('print_template', $data);
    }
}
