<?php

namespace App\Http\Controllers\Pustaka;

use Illuminate\Http\Request;

use App\User;
use App\Models\Subject;
use App\Models\PustakaBukuFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use App\Models\Activity;
use App\Models\PustakaBuku;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class PustakaBukuController extends Controller
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
        
        $data['nama_menu'] = 'Digitalisasi Pustaka Buku';

        $query = PustakaBuku::query()->select('pustaka_buku.*','subject.subjek')->leftJoin('subject', 'pustaka_buku.id_subjek', '=', 'subject.id');

        if ($request->has('search')) {
            $query->where('pustaka_buku.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_buku.deskripsi', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_buku.tahun_terbit, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
    
        // Ambil data subjek dengan paginate
        $data['pustaka_buku'] = $query->paginate(5);
        
        
        return view('pustaka.buku.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Buku';
        $data['subject'] = Subject::where('status',1)->get();
        return view('pustaka.buku.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_subjek' => "required",
            'deskripsi' => "required",
            'judul' => "required"
            ]);
        $file = $request->file('cover');
        // dd($file->getClientOriginalName());
        $directory = public_path().'/uploads/pustaka-buku/cover/';
        $cover = uniqid() . ' - ' . $file->getClientOriginalName();
        $file->move($directory, $cover);

        $id_pustaka = Str::uuid(); 
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun_terbit)));
        PustakaBuku::create([
            'id' => $id_pustaka,
            'id_subjek' => $request->id_subjek,
            'pengarang' => $request->pengarang,
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'jumlah_halaman' => $request->jumlah_halaman,
            'tipe_media' => $request->tipe_media,
            'bahasa' => $request->bahasa,
            'cover' => $cover,
            'deskripsi' => $request->deskripsi,
            'tahun_terbit' => $tanggal_diubah,
        ]);        

        PustakaBukuFile::where('code',$request->code)->update([
            'id_pustaka_buku' => $id_pustaka,
            'code' => null
        ]);
        Session::flash('success', 'Buku  Berhasil Ditambahkan.');
        return redirect()->route('pustaka.buku.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data['nama_menu'] = 'Detail Pustaka Buku';
        $data['pustaka_buku'] = PustakaBuku::select('subject.subjek', 'pustaka_buku.*', 'pustaka_buku_file.file')
        ->join('pustaka_buku_file', 'pustaka_buku_file.id_pustaka_buku', 'pustaka_buku.id')
        ->join('subject', 'subject.id', 'pustaka_buku.id_subjek')
        ->where('pustaka_buku.id',$request->id)
        ->orderby('pustaka_buku.created_at', 'desc')->first();

        return view('pustaka.buku.detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Buku';
        $data['pustaka'] = PustakaBuku::FindorFail($id);
        $data['pustaka_file'] = PustakaBukuFile::where('id_pustaka_buku',$id)->first();
        $data['subject'] = Subject::where('status',1)->get();
        return view('pustaka.buku.edit',$data);
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
        $request->validate([
            'tahun_terbit' => "required",
            'id_subjek' => "required",
            'judul' => "required",
            'deskripsi' => "required",
        ]);
        $cover = $request->cover_old;
        if ($request->file('cover')) {
            $file = $request->file('cover');
            if ($request->cover_old) {
                $location =  public_path().'/uploads/pustaka-buku/cover/'. $request->cover_old;
                File::delete($location);
            }
            $directory = public_path().'/uploads/pustaka-buku/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);
        }
        $arsip = PustakaBuku::findorFail($id);
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun_terbit)));
        $arsip->update([
            'id_subjek' => $request->id_subjek,
            'pengarang' => $request->pengarang,
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'jumlah_halaman' => $request->jumlah_halaman,
            'tipe_media' => $request->tipe_media,
            'bahasa' => $request->bahasa,
            'cover' => $cover,
            'deskripsi' => $request->deskripsi,
            'tahun_terbit' => $tanggal_diubah,
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.');
        return redirect()->route('pustaka.buku.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \
     * Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = PustakaBuku::findOrFail($id);
        $subject_file = PustakaBukuFile::where('id_pustaka_buku',$id)->get();
        foreach ($subject_file as $key => $value) {
            $location =  public_path().'/uploads/pustaka-buku/'. $value->file;
            File::delete($location);
        }
        $path =  public_path().'/uploads/pustaka-buku/cover/'. $subject->cover;
        File::delete($path);
        $subject->delete();
        $subject_file = PustakaBukuFile::where('id_pustaka_buku',$id)->delete();
        
        return redirect()->route('pustaka.buku.index')->with('success', 'Subjek berhasil dihapus.');
    }


    public function upload(Request $request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded()) {

                // receive the file
                $save = $receiver->receive();
    
                // check if the upload has finished (in chunk mode it will send smaller files)
                if ($save->isFinished()) {
                    // save the file and return any response you need
                    return $this->saveFile($save->getFile());
                } else {
                    // we are in chunk mode, lets send the current progress
    
                    /** @var AbstractHandler $handler */
                    $handler = $save->handler();
    
                    return response()->json([
                        "done" => $handler->getPercentageDone(),
                    ]);
                }
            } else {
                throw new UploadMissingFileException();
            }
    }

    protected function saveFile(UploadedFile $file)
    {
        $directory = public_path().'/uploads/pustaka-buku/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $uniqid = uniqid();
        PustakaBukuFile::create([
            'id' => Str::uuid(),
            'code' => $uniqid,
            'file'=>$filename
        ]);
        return response()->json(['code'=>1,
            'uniq' => $uniqid,
        ]);
    }

    public function uploadEdit(Request $request,$id)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded()) {

                // receive the file
                $save = $receiver->receive();
    
                // check if the upload has finished (in chunk mode it will send smaller files)
                if ($save->isFinished()) {
                    // save the file and return any response you need
                    return $this->updateFile($save->getFile(),$id);
                } else {
                    // we are in chunk mode, lets send the current progress
    
                    /** @var AbstractHandler $handler */
                    $handler = $save->handler();
    
                    return response()->json([
                        "done" => $handler->getPercentageDone(),
                    ]);
                }
            } else {
                throw new UploadMissingFileException();
            }
    }

    protected function updateFile(UploadedFile $file,$id)
    {
        $ArsipFile = PustakaBukuFile::where('id_pustaka_buku',$id)->first();
        if ($ArsipFile) {
            $location =  public_path().'/uploads/pustaka-buku/'. $ArsipFile->file;
            File::delete($location);
        }

        $directory = public_path().'/uploads/pustaka-buku/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        PustakaBukuFile::where('id_pustaka_buku',$id)->update([
            'file'=>$filename
        ]);
        return response()->json(['code'=>1,
        ]);
    }

    public function destroyFile($id)
    {
        $ArsipFile = PustakaBukuFile::FindorFail($id);
        $location =  public_path().'/uploads/pustaka-buku/'.$ArsipFile->file;
        File::delete($location);
        $ArsipFile->delete();
        return response()->json();
    }
}
