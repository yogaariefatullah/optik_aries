<?php

namespace App\Http\Controllers\List;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PustakaBuku;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;

class ListEbookController extends Controller
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
        $query =  PustakaBuku::select('subject.subjek', 'pustaka_buku_file.file',  'pustaka_buku.id', 'pustaka_buku.cover')
        ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
        ->join('subject', 'subject.id', 'pustaka_buku.id_subjek');
        if ($request->has('search')) {
            $query->where('pustaka_buku.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_buku.penerbit', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_buku.pengarang', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_buku.bahasa', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_buku.tipe_media', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_buku.tahun_terbit, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
        $data['pustaka_buku'] = $query->orderby('pustaka_buku.created_at', 'desc')->get();
        $data['subject'] = Subject::where('status',1)->get();
        
        return view('list.ebook.index',$data);
    }

    public function detail(Request $request)
    {
        $data['pustaka_buku'] = PustakaBuku::select('subject.subjek', 'pustaka_buku.*', 'pustaka_buku_file.file')
        ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
        ->join('subject', 'subject.id', 'pustaka_buku.id_subjek')
        ->where('pustaka_buku.id',$request->id)
        ->orderby('pustaka_buku.created_at', 'desc')->first();
        return view('list.ebook.detail',$data);
    }

    public function filter(Request $request)
    {
        $subjectId = $request->subject_id;
        $date = $request->date;
        $books = PustakaBuku::select('subject.subjek', 'pustaka_buku_file.file',  'pustaka_buku.id', 'pustaka_buku.cover')
            ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
            ->join('subject', 'subject.id', 'pustaka_buku.id_subjek')
            ->when($subjectId, function ($query) use ($subjectId) {
                return $query->where('id_subjek', $subjectId);
            })
            ->when($date, function ($query) use ($date) {
                return $query->where('tahun_terbit', $date);
            })
            ->get();
        $results = [
            'books' => $books
        ];

        return response()->json($results);
    }
}
