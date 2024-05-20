<?php

namespace App\Http\Controllers\List;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PustakaAudio;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;

class ListAudioController extends Controller
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
        $query =  PustakaAudio::select('subject.subjek', 'pustaka_audio_file.file',  'pustaka_audio.id', 'pustaka_audio.judul', 'pustaka_audio.cover')
        ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
        ->join('subject', 'subject.id', 'pustaka_audio.id_subjek');
        if ($request->has('search')) {
            $query->where('pustaka_audio.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.penerbit', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.pengarang', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.bahasa', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.tipe_media', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.produksi', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_audio.tahun_produksi, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
        $data['pustaka_audio'] = $query->orderby('pustaka_audio.created_at', 'desc')->get();
        $data['subject'] = Subject::where('status',1)->get();
        
        return view('list.audio.index',$data);
    }

    public function detail(Request $request)
    {
        $data['pustaka_audio'] = PustakaAudio::select('subject.subjek', 'pustaka_audio.*', 'pustaka_audio_file.file')
        ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
        ->join('subject', 'subject.id', 'pustaka_audio.id_subjek')
        ->where('pustaka_audio.id',$request->id)
        ->orderby('pustaka_audio.created_at', 'desc')->first();
        return view('list.audio.detail',$data);
    }

    public function filter(Request $request)
    {
        $subjectId = $request->subject_id;
        $date = $request->date;
        $books = PustakaAudio::select('subject.subjek', 'pustaka_audio_file.file',  'pustaka_audio.id', 'pustaka_audio.judul', 'pustaka_audio.cover')
            ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
            ->join('subject', 'subject.id', 'pustaka_audio.id_subjek')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_produksi', $date);
            })
            ->get();
        $results = [
            'books' => $books
        ];

        return response()->json($results);
    }
}
