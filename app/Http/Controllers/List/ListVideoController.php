<?php

namespace App\Http\Controllers\List;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PustakaVideo;
use App\Models\PustakaVideoFile;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;

class ListVideoController extends Controller
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
    public function index(Request $request)
    {
        $query =  PustakaVideo::select('subject.subjek', 'pustaka_video.id', 'pustaka_video.cover')
        // ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
        ->join('subject', 'subject.id', 'pustaka_video.id_subjek');
        if ($request->has('search')) {
            $query->where('pustaka_video.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.penerbit', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.pengarang', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.bahasa', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.tipe_media', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.produksi', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_video.tahun_produksi, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
        $data['pustaka_video'] = $query->orderby('pustaka_video.created_at', 'desc')->get();
        $data['subject'] = Subject::where('status',1)->get();
        
        return view('list.video.index',$data);
    }

    public function detail(Request $request)
    {
        $data['pustaka_video'] = PustakaVideo::select('subject.subjek', 'pustaka_video_file.file', 'pustaka_video.*')
        ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
        ->join('subject', 'subject.id', 'pustaka_video.id_subjek')
        ->where('pustaka_video.id',$request->id)
        ->where('pustaka_video_file.urutan', 1)
        ->first();
        // dd($data);
        return view('list.video.detail',$data);
    }
    
    public function getFile(Request $request)
    {
        $pustaka_video = PustakaVideoFile::select('pustaka_video_file.*', 'pustaka_video.cover', 'pustaka_video.judul')->where('id_pustaka_video',$request->id)
        ->join('pustaka_video', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
        ->orderby('urutan', 'asc')
        ->get();
        return response()->json($pustaka_video);
    }

    public function filter(Request $request)
    {
        $subjectId = $request->subject_id;
        $date = $request->date;


        // Lakukan live search dan filter untuk semua model
        // Contoh menggunakan masing-masing model
        $books = PustakaVideo::select('subject.subjek', 'pustaka_video_file.file',  'pustaka_video.id', 'pustaka_video.cover')
            ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
            ->join('subject', 'subject.id', 'pustaka_video.id_subjek')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_produksi', $date);
            })
            ->get();
        // Gabungkan hasil pencarian dari semua model
        $results = [
            'books' => $books
        ];

        return response()->json($results);
    }
    
}
