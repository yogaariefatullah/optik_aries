<?php

namespace App\Http\Controllers\Pustaka;

use Illuminate\Http\Request;

use App\User;
use App\Models\Subject;
use App\Models\PustakaAudioFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use App\Models\Activity;
use App\Models\PustakaAudio;
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

class PustakaAudioController extends Controller
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
        
        $data['nama_menu'] = 'Digitalisasi Pustaka Audio';

        $query = PustakaAudio::query()->select('pustaka_audio.*','subject.subjek')->leftJoin('subject', 'pustaka_audio.id_subjek', '=', 'subject.id');

        if ($request->has('search')) {
            $query->where('pustaka_audio.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_audio.keterangan', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_audio.tahun_produksi, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
    
        // Ambil data subjek dengan paginate
        $data['pustaka_audio'] = $query->paginate(5);
        
        
        return view('pustaka.audio.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Audio';
        $data['subject'] = Subject::where('status',1)->get();
        $data['code'] = uniqid();
        return view('pustaka.audio.add',$data);
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
            'keterangan' => "required",
            'judul' => "required"
            ]);
        $file = $request->file('cover');
        // dd($file->getClientOriginalName());
        $directory = public_path().'/uploads/pustaka-audio/cover/';
        $cover = uniqid() . ' - ' . $file->getClientOriginalName();
        $file->move($directory, $cover);

        $id_pustaka = Str::uuid(); 
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun_produksi)));
        PustakaAudio::create([
            'id' => $id_pustaka,
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun_produksi' => $tanggal_diubah,
            'produksi' => $request->produksi,
        ]);        

        PustakaAudioFile::where('code',$request->code)->update([
            'id_pustaka_audio' => $id_pustaka,
            'code' => null
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('pustaka.audio.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data['nama_menu'] = 'Detail Pustaka Audio';
        $data['pustaka_audio'] = PustakaAudio::select('subject.subjek', 'pustaka_audio.*', 'pustaka_audio_file.file')
        ->join('pustaka_audio_file', 'pustaka_audio_file.id_pustaka_audio', 'pustaka_audio.id')
        ->join('subject', 'subject.id', 'pustaka_audio.id_subjek')
        ->where('pustaka_audio.id',$request->id)
        ->orderby('pustaka_audio.created_at', 'desc')->first();
        return view('pustaka.audio.detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Audio';
        $data['pustaka'] = PustakaAudio::FindorFail($id);
        $data['pustaka_file'] = PustakaAudioFile::where('id_pustaka_audio',$id)->first();
        $data['subject'] = Subject::where('status',1)->get();
        return view('pustaka.audio.edit',$data);
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
            'tahun_produksi' => "required",
            'id_subjek' => "required",
            'judul' => "required",
            'keterangan' => "required",
        ]);
        $cover = $request->cover_old;
        if ($request->file('cover')) {
            $file = $request->file('cover');
            if ($request->cover_old) {
                
                $location =  public_path().'/uploads/pustaka-audio/cover/'. $request->cover_old;
                File::delete($location);
            }
            $directory = public_path().'/uploads/pustaka-audio/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);
        }
        $pustaka = PustakaAudio::findorFail($id);
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun_produksi)));
        $pustaka->update([
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun_produksi' => $tanggal_diubah,
            'produksi' => $request->produksi,
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.');
        return redirect()->route('pustaka.audio.index');
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
        $subject = PustakaAudio::findOrFail($id);
        $subject_file = PustakaAudioFile::where('id_pustaka_audio',$id)->get();
        foreach ($subject_file as $key => $value) {
            $location =  public_path().'/uploads/pustaka-audio/'. $value->file;
            File::delete($location);
        }
        $path =  public_path().'/uploads/pustaka-audio/cover/'. $subject->cover;
        File::delete($path);
        $subject->delete();
        $subject_file = PustakaAudioFile::where('id_pustaka_audio',$id)->delete();
        
        return redirect()->route('pustaka.audio.index')->with('success', 'Subjek berhasil dihapus.');
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
        $directory = public_path().'/uploads/pustaka-audio/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $uniqid = uniqid();
        PustakaAudioFile::create([
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
        $ArsipFile = PustakaAudioFile::where('id_pustaka_audio',$id)->first();
        if ($ArsipFile) {
            $location =  public_path().'/uploads/pustaka-audio/'. $ArsipFile->file;
            File::delete($location);
        }

        $directory = public_path().'/uploads/pustaka-audio/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        PustakaAudioFile::where('id_pustaka_audio',$id)->update([
            'file'=>$filename
        ]);
        return response()->json(['code'=>1
        ]);
    }

    public function destroyFile($id)
    {
        $PustakaFile = PustakaAudioFile::find($id);
        $location =  public_path().'/uploads/pustaka-audio/'.$PustakaFile->file;
        File::delete($location);
        $PustakaFile->delete();
        return response()->json();
    }
    public function refresh($id)
    {
        $PustakaFile = PustakaAudioFile::where('id_pustaka_audio',$id)->get();
        $html = '';
        foreach ($PustakaFile as $key => $pustaka) {
            $video = asset("uploads/pustaka-audio/".$pustaka->file);
            $html .= '<tr>';
            $html .= '<td><center>' . ($key + 1) . '</center></td>';
            $html .= '<td>';
            $html .= '<div class="symbol symbol-500 mr-5 align-self-start align-self-xxl-center">';
            $html .= '<label>'. $pustaka->file .'</label>';
            $html .= '<i class="symbol-badge bg-success"></i>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '<td class="text-end">';
            $html .= '<center>';
            $html .= '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal' . $pustaka->id . '">';
            $html .= '<i class="ki-solid ki-trash fs-2"></i>';
            $html .= '</a>';
            $html .= '</center>';
            $html .= '</td>';
            $html .= '</tr>';
            // Tambahkan modal untuk setiap Pustaka
            $html .= '<div class="modal fade" id="deleteModal' . $pustaka->id . '" tabindex="-1" role="dialog" aria-labelledby="deleteModal' . $pustaka->id . 'Label" aria-hidden="true">';
            $html .= '<div class="modal-dialog" role="document">';
            $html .= '<div class="modal-content">';
            $html .= '<div class="modal-header">';
            $html .= '<h5 class="modal-title" id="deleteModal' . $pustaka->id . 'Label">Hapus Pustaka</h5>';
            $html .= '<button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">';
            $html .= '<span aria-hidden="true"><i class="ki-solid ki-cross fs-1"></i></span>';
            $html .= '</button>';
            $html .= '</div>';
            $html .= '<div class="modal-body">';
            $html .= '<input type="hidden" value="' . $pustaka->id . '" id="ids">';
            $html .= '<h5 class="modal-title" id="deleteModal' . $pustaka->id . 'Label">Hapus Pustaka</h5>';
            $html .= 'Apakah Anda yakin ingin menghapus Pustaka ini?';
            $html .= '</div>';
            $html .= '<div class="modal-footer">';
            $html .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>';
            $html .= '<button type="button" id="hapus-data" class="btn btn-danger">Hapus</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        // Kembalikan HTML yang dihasilkan
        return response()->json($html);
    }
}
