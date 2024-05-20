<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;

use App\User;
use App\Models\Subject;
use App\Models\ArsipVideoFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use App\Models\Activity;
use App\Models\ArsipVideo;
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


class ArsipVideoController extends Controller
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
        
        $data['nama_menu'] = 'Digitalisasi Arsip Video';

        $query = ArsipVideo::query()->select('arsip_video.*','subject.subjek')->leftJoin('subject', 'arsip_video.id_subjek', '=', 'subject.id');

        if ($request->has('search')) {
            $query->where('arsip_video.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('arsip_video.keterangan', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('arsip_video.tahun', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
    
        // Ambil data subjek dengan paginate
        $data['arsip_video'] = $query->paginate(5);
        
        
        return view('arsip.video.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Digitalisasi Arsip Video';
        $data['subject'] = Subject::where('status',1)->get();
        return view('arsip.video.add',$data);
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
        $directory = public_path().'/uploads/arsip-video/cover/';
        $cover = uniqid() . ' - ' . $file->getClientOriginalName();
        $file->move($directory, $cover);

        $id_arsip = Str::uuid(); 
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun)));
        ArsipVideo::create([
            'id' => $id_arsip,
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun' => $tanggal_diubah,
        ]);        

        ArsipVideoFile::where('code',$request->code)->update([
            'id_arsip_video' => $id_arsip,
            'code' => null
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('arsip.video.index');

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
        $data['nama_menu'] = 'Digitalisasi Arsip Video';
        $data['arsip'] = ArsipVideo::FindorFail($id);
        $data['arsip_file'] = ArsipVideoFile::where('id_arsip_video',$id)->first();
        $data['subject'] = Subject::where('status',1)->get();
        return view('arsip.video.edit',$data);
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
            'tahun' => "required",
            'id_subjek' => "required",
            'judul' => "required",
            'keterangan' => "required",
        ]);
        $cover = $request->cover_old;
        if ($request->file('cover')) {
            $file = $request->file('cover');
            if ($request->cover_old) {
                
                $location =  public_path().'/uploads/arsip-video/cover/'. $request->cover_old;
                File::delete($location);
            }
            $directory = public_path().'/uploads/arsip-video/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);
        }
        $arsip = ArsipVideo::findorFail($id);
        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun)));
        $arsip->update([
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun' => $tanggal_diubah,
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.');
        return redirect()->route('arsip.video.index');
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
        $subject = ArsipVideo::findOrFail($id);
        $subject_file = ArsipVideoFile::where('id_arsip_video',$id)->get();
        foreach ($subject_file as $key => $value) {
            $location =  public_path().'/uploads/arsip-video/'. $value->file;
            File::delete($location);
        }
        $path =  public_path().'/uploads/arsip-video/cover/'. $subject->cover;
        File::delete($path);
        $subject->delete();
        $subject_file = ArsipVideoFile::where('id_arsip_video',$id)->delete();
        
        return redirect()->route('arsip.video.index')->with('success', 'Subjek berhasil dihapus.');
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
        $directory = public_path().'/uploads/arsip-video/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $uniqid = uniqid();
        Log::info($uniqid);
        ArsipVideoFile::create([
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
        $ArsipFile = ArsipVideoFile::where('id_arsip_video',$id)->first();
        $location =  public_path().'/uploads/arsip-video/'. $ArsipFile->file;
        File::delete($location);

        $directory = public_path().'/uploads/arsip-video/';
        $filename = uniqid() . ' - ' . $file->getClientOriginalName();

        if (!$file->move($directory, $filename))
        {
            return 'Error saving the file.';
        }
        $uniqid = uniqid();
        Log::info($uniqid);
        ArsipVideoFile::where('id_arsip_video',$id)->update([
            'id' => Str::uuid(),
            'code' => $uniqid,
            'file'=>$filename
        ]);
        return response()->json(['code'=>1,
            'uniq' => $uniqid,
        ]);
    }

    public function destroyFile($id)
    {
        $ArsipFile = ArsipVideoFile::FindorFail($id);
        $location =  public_path().'/uploads/arsip-video/'.$ArsipFile->file;
        File::delete($location);
        $ArsipFile->delete();
        return response()->json();
    }
    public function refresh($id)
    {
        $ArsipFile = ArsipVideoFile::where('id_arsip_video',$id)->get();
        $html = '';
        foreach ($ArsipFile as $key => $arsip) {
            $video = asset("uploads/arsip-video/".$arsip->file);
            $html .= '<tr>';
            $html .= '<td><center>' . ($key + 1) . '</center></td>';
            $html .= '<td>';
            $html .= '<div class="symbol symbol-500 mr-5 align-self-start align-self-xxl-center">';
            $html .= '<div class="symbol-label" style="background-image:url(\'' . $video . '\')"></div>';
            $html .= '<i class="symbol-badge bg-success"></i>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '<td class="text-end">';
            $html .= '<center>';
            $html .= '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal' . $arsip->id . '">';
            $html .= '<i class="ki-solid ki-trash fs-2"></i>';
            $html .= '</a>';
            $html .= '</center>';
            $html .= '</td>';
            $html .= '</tr>';
            // Tambahkan modal untuk setiap arsip
            $html .= '<div class="modal fade" id="deleteModal' . $arsip->id . '" tabindex="-1" role="dialog" aria-labelledby="deleteModal' . $arsip->id . 'Label" aria-hidden="true">';
            $html .= '<div class="modal-dialog" role="document">';
            $html .= '<div class="modal-content">';
            $html .= '<div class="modal-header">';
            $html .= '<h5 class="modal-title" id="deleteModal' . $arsip->id . 'Label">Hapus Arsip</h5>';
            $html .= '<button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">';
            $html .= '<span aria-hidden="true"><i class="ki-solid ki-cross fs-1"></i></span>';
            $html .= '</button>';
            $html .= '</div>';
            $html .= '<div class="modal-body">';
            $html .= '<input type="hidden" value="' . $arsip->id . '" id="ids">';
            $html .= '<h5 class="modal-title" id="deleteModal' . $arsip->id . 'Label">Hapus Arsip</h5>';
            $html .= 'Apakah Anda yakin ingin menghapus Arsip ini?';
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
