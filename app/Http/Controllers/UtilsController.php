<?php

namespace App\Http\Controllers;

use App\Models\PustakaAudio;
use App\Models\PustakaBuku;
use App\Models\PustakaVideo;
use App\Models\Subject;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['subject'] = Subject::where('status', 1)->get();
        $data['pustaka_buku'] = PustakaBuku::select('subject.subjek', 'pustaka_buku_file.file', 'pustaka_buku.cover')
            ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
            ->join('subject', 'subject.id', 'pustaka_buku.id_subjek')
            ->orderby('pustaka_buku.created_at', 'desc')->limit(10)->get();

        $data['pustaka_audio'] = PustakaAudio::select('subject.subjek', 'pustaka_audio_file.file', 'pustaka_audio.cover', 'pustaka_audio.judul')
            ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
            ->join('subject', 'subject.id', 'pustaka_audio.id_subjek')
            ->orderby('pustaka_audio.created_at', 'desc')->limit(10)->get();

        $data['pustaka_video'] = PustakaVideo::select('subject.subjek', 'pustaka_video_file.file', 'pustaka_video.cover', 'pustaka_video.tahun_produksi')
            ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
            ->join('subject', 'subject.id', 'pustaka_video.id_subjek')
            ->orderby('pustaka_video.created_at', 'desc')->limit(10)->get();
        return view('landing_page', $data);
    }

    function searchFilter(Request $request)
    {
        $search = $request->search;
        $subjectId = $request->subject_id;
        $date = $request->date;


        // Lakukan live search dan filter untuk semua model
        // Contoh menggunakan masing-masing model
        $books = PustakaBuku::select('subject.subjek', 'pustaka_buku_file.file', 'pustaka_buku.cover')
            ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
            ->join('subject', 'subject.id', 'pustaka_buku.id_subjek')
            ->where('judul', 'ilike', '%' . $search . '%')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_terbit', $date);
            })
            ->get();

        $audios = PustakaAudio::select('subject.subjek', 'pustaka_audio_file.file', 'pustaka_audio.cover', 'pustaka_audio.judul')
            ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
            ->join('subject', 'subject.id', 'pustaka_audio.id_subjek')
            ->where('judul', 'ilike', '%' . $search . '%')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_produksi', $date);
            })
            ->get();

        $videos = PustakaVideo::select('subject.subjek', 'pustaka_video_file.file', 'pustaka_video.cover', 'pustaka_video.judul', 'pustaka_video.tahun_produksi')
            ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
            ->join('subject', 'subject.id', 'pustaka_video.id_subjek')
            ->where('judul', 'ilike', '%' . $search . '%')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_produksi', $date);
            })
            ->get();

        // Gabungkan hasil pencarian dari semua model
        $results = [
            'books' => $books,
            'audios' => $audios,
            'videos' => $videos,
        ];

        return response()->json($results);
    }
}
