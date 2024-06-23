<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Barang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['nama_menu'] = 'Dashboard';
        $data['count_cabang'] = Cabang::count();
        $data['count_lensa'] = Barang::where('jenis', 1)->sum('jumlah_stok');
        $data['count_frame'] = Barang::where('jenis', 2)->sum('jumlah_stok');
        // $data['count_pustaka_buku'] = PustakaBuku::count();
        // $data['count_pustaka_video'] = PustakaVideo::count();
        // $data['count_pustaka_audio'] = PustakaAudio::count();
        return view('home', $data);
    }

    public function SelectType()
    {
        return view('selectType');
    }
}
