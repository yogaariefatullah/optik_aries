<?php

namespace App\Http\Controllers\Pustaka;

use Illuminate\Http\Request;

use App\User;
use App\Models\Subject;
use App\Models\PustakaVideoFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use App\Models\Activity;
use App\Models\PustakaVideo;
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


class PustakaVideoController extends Controller
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
        
        $data['nama_menu'] = 'Digitalisasi Pustaka Video';

        $query = PustakaVideo::query()->select('pustaka_video.*','subject.subjek')->leftJoin('subject', 'pustaka_video.id_subjek', '=', 'subject.id');

        if ($request->has('search')) {
            $query->where('pustaka_video.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.keterangan', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('pustaka_video.produksi', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere(DB::raw("to_char(pustaka_video.tahun_produksi, 'YYYY')"), 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
        // Ambil data subjek dengan paginate
            $data['pustaka_video'] = $query->paginate(5);
        
        
        
        return view('pustaka.video.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Video';
        $data['subject'] = Subject::where('status',1)->get();
        $data['code'] = uniqid();
        return view('pustaka.video.add',$data);
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
        $directory = public_path().'/uploads/pustaka-video/cover/';
        $cover = uniqid() . ' - ' . $file->getClientOriginalName();
        $file->move($directory, $cover);

        $id_pustaka = Str::uuid(); 
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun_produksi)));
        PustakaVideo::create([
            'id' => $id_pustaka,
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun_produksi' => $tanggal_diubah,
            'produksi' => $request->produksi,
        ]);        

        PustakaVideoFile::where('code',$request->code)->update([
            'id_pustaka_video' => $id_pustaka,
            'code' => null
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('pustaka.video.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data['nama_menu'] = 'Detail Pustaka Video';
        $data['pustaka_video'] = PustakaVideo::select('subject.subjek', 'pustaka_video_file.file', 'pustaka_video.*')
        ->join('pustaka_video_file', 'pustaka_video_file.id_pustaka_video', 'pustaka_video.id')
        ->join('subject', 'subject.id', 'pustaka_video.id_subjek')
        ->where('pustaka_video.id',$request->id)
        ->where('pustaka_video_file.urutan', 1)
        ->first();
        // dd($data);
        return view('pustaka.video.detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['nama_menu'] = 'Digitalisasi Pustaka Video';
        $data['pustaka'] = PustakaVideo::FindorFail($id);
        $data['pustaka_file'] = PustakaVideoFile::where('id_pustaka_video',$id)->get();
        $data['subject'] = Subject::where('status',1)->get();
        return view('pustaka.video.edit',$data);
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
                
                $location =  public_path().'/uploads/pustaka-video/cover/'. $request->cover_old;
                File::delete($location);
            }
            $directory = public_path().'/uploads/pustaka-video/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);
        }
        $pustaka = PustakaVideo::findorFail($id);
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
        return redirect()->route('pustaka.video.index');
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
        $subject = PustakaVideo::findOrFail($id);
        $subject_file = PustakaVideoFile::where('id_pustaka_video',$id)->get();
        foreach ($subject_file as $key => $value) {
            $location =  public_path().'/uploads/pustaka-video/'. $value->file;
            File::delete($location);
        }
        $path =  public_path().'/uploads/pustaka-video/cover/'. $subject->cover;
        File::delete($path);
        $subject->delete();
        $subject_file = PustakaVideoFile::where('id_pustaka_video',$id)->delete();
        
        return redirect()->route('pustaka.video.index')->with('success', 'Subjek berhasil dihapus.');
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
                    return $this->saveFile($save->getFile(),$request->additionalParam);
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

    protected function saveFile(UploadedFile $file,$uniqid)
    {
        $directory = public_path().'/uploads/pustaka-video/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $urutan = 1;
        $check = PustakaVideoFile::where('code', $uniqid)->first();
        if ($check) {
            $urutan = PustakaVideoFile::where('code',$uniqid)->max('urutan');
            $urutan = $urutan + 1;
        }
        PustakaVideoFile::create([
            'id' => Str::uuid(),
            'code' => $uniqid,
            'urutan' => $urutan,
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
        $pustakaFile = PustakaVideoFile::where('id_pustaka_video',$id)->first();

        $directory = public_path().'/uploads/pustaka-video/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $urutan = 1;
        if ($pustakaFile) {
            $urutan = PustakaVideoFile::where('id_pustaka_video',$id)->max('urutan');
            $urutan = $urutan + 1;
        }
        PustakaVideoFile::create([
            'id' => Str::uuid(),
            'file'=>$filename,
            'id_pustaka_video'=>$id,
            'urutan'=>$urutan,
        ]);
        return response()->json(['code'=>1]);
    }

    public function destroyFile($id)
    {
        $PustakaFile = PustakaVideoFile::find($id);
        $location =  public_path().'/uploads/pustaka-video/'.$PustakaFile->file;
        File::delete($location);
        $PustakaFile->delete();
        return response()->json();
    }
    public function refresh($id)
    {
        $PustakaFile = PustakaVideoFile::where('id_pustaka_video',$id)->get();
        $html = '';
        foreach ($PustakaFile as $key => $pustaka) {
            $video = asset("uploads/pustaka-video/".$pustaka->file);
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
