<?php

namespace App\Http\Controllers;

use App\Models\ArsipFoto;
use App\Models\PustakaAudio;
use App\Models\PustakaBuku;
use App\Models\PustakaVideo;
use App\Models\Subject;
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
        // $data['count_subjek'] = Subject::where('status',1)->count();
        // $data['count_arsip_foto'] = ArsipFoto::count();
        // $data['count_arsip_video'] = ArsipFoto::count();
        // $data['count_pustaka_buku'] = PustakaBuku::count();
        // $data['count_pustaka_video'] = PustakaVideo::count();
        // $data['count_pustaka_audio'] = PustakaAudio::count();
        return view('home',$data);
    }

    public function SelectType()
    {
        return view('selectType');
    }
}
