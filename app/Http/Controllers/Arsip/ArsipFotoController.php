<?php

namespace App\Http\Controllers\Arsip;

use Illuminate\Http\Request;

use App\User;
use App\Models\Subject;
use App\Models\ArsipFoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use File;
use App\Models\Activity;
use App\Models\ArsipFotoFile;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


class ArsipFotoController extends Controller
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
        
        $data['nama_menu'] = 'Digitalisasi Arsip Foto';

        $query = ArsipFoto::query()->select('arsip_foto.*','subject.subjek')->leftJoin('subject', 'arsip_foto.id_subjek', '=', 'subject.id');

        if ($request->has('search')) {
            $query->where('arsip_foto.judul', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('arsip_foto.keterangan', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('arsip_foto.tahun', 'ilike', '%' . $request->input('search') . '%')
            ->orWhere('subject.subjek', 'ilike', '%' . $request->input('search') . '%');
        }
    
        // Ambil data subjek dengan paginate
        $data['arsip_foto'] = $query->paginate(5);
        
        
        return view('arsip.foto.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Digitalisasi Arsip Foto';
        $data['subject'] = Subject::where('status',1)->get();
        $data['code'] = uniqid();
        return view('arsip.foto.add',$data);
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
            $directory = public_path().'/uploads/arsip-foto/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);

            $id_arsip = Str::uuid(); 
            $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun)));
        ArsipFoto::create([
            'id' => $id_arsip,
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun' => $tanggal_diubah,
        ]);
        ArsipFotoFile::where('code',$request->code)->update([
            'id_arsip_foto' => $id_arsip,
            'code' => null
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('arsip.foto.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['nama_menu'] = 'Digitalisasi Arsip Foto';
        $data['arsip'] = ArsipFoto::findorFail($id);
        $data['arsip_file'] = ArsipFotoFile::where('id_arsip_foto',$id)->get();
        $data['subjek'] = Subject::where('id',$data['arsip']->id_subjek)->first();

        return view('arsip.foto.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['nama_menu'] = 'Digitalisasi Arsip Foto';
        $data['arsip'] = ArsipFoto::FindorFail($id);
        $data['arsip_file'] = ArsipFotoFile::where('id_arsip_foto',$id)->get();
        $data['subject'] = Subject::where('status',1)->get();
        return view('arsip.foto.edit',$data);
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
                $location =  public_path().'/uploads/arsip-foto/cover/'. $request->cover_old;
                File::delete($location);
            }
            $directory = public_path().'/uploads/arsip-foto/cover/';
            $cover = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $cover);
        }
        $arsip = ArsipFoto::findorFail($id);

        $tanggal_diubah = date("Y-m-d", strtotime(str_replace('/', '-', $request->tahun)));
        $arsip->update([
            'id_subjek' => $request->id_subjek,
            'keterangan' => $request->keterangan,
            'judul' => $request->judul,
            'cover' => $cover,
            'tahun' => $tanggal_diubah,
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.');
        return redirect()->route('arsip.foto.index');
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
        $subject = ArsipFoto::findOrFail($id);
        $subject_file = ArsipFotoFile::where('id_arsip_foto',$id)->get();
        foreach ($subject_file as $key => $value) {
            $location =  public_path().'/uploads/arsip-foto/'. $value->file;
            File::delete($location);
        }
        $path =  public_path().'/uploads/arsip-foto/cover/'. $subject->cover;
        File::delete($path);
        $subject->delete();
        $subject_file = ArsipFotoFile::where('id_arsip_foto',$id)->delete();
        
        return redirect()->route('arsip.foto.index')->with('success', 'Subjek berhasil dihapus.');
    }


    public function upload(Request $request)
    {
        try {
            $input = $request->all();
            $rules = array(
                'file' => 'image|max:3000',
            );
        
            $validation = Validator::make($input, $rules);
        
            if ($validation->fails()) {
                return Response::make($validation->errors()->first(), 400);
            }

            $file = $request->file('file');

            $directory = public_path().'/uploads/arsip-foto/';
            $filename = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $filename);

            ArsipFotoFile::create([
                'id' => Str::uuid(),
                'code' => $request->additionalParam,
                'file'=>$filename
            ]);
            
            $response = [
                "meta" => ['code' => 200, 'message' => 'success'],
                "data" => $filename
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
        

        
    }

    public function uploadEdit(Request $request,$id)
    {       
        try {
            $input = $request->all();
            $rules = array(
                'file' => 'image|max:3000',
            );
        
            $validation = Validator::make($input, $rules);
        
            if ($validation->fails()) {
                return Response::make($validation->errors()->first(), 400);
            }

            $file = $request->file('file');

            $directory = public_path().'/uploads/arsip-foto/';
            $filename = uniqid() . ' - ' . $file->getClientOriginalName();
            $file->move($directory, $filename);

            ArsipFotoFile::create([
                'id' => Str::uuid(),
                'id_arsip_foto' => $id,
                'file'=>$filename
            ]);
            
            $response = [
                "meta" => ['code' => 200, 'message' => 'success'],
                "data" => $filename
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
        

        
    }

    public function destroyFile($id)
    {
        $ArsipFile = ArsipFotoFile::FindorFail($id);
        $location =  public_path().'/uploads/arsip-foto/'.$ArsipFile->file;
        File::delete($location);
        $ArsipFile->delete();
        return response()->json();
    }
    public function refresh($id)
    {
        $ArsipFile = ArsipFotoFile::where('id_arsip_foto',$id)->get();
        $html = '';
        foreach ($ArsipFile as $key => $arsip) {
            $foto = asset("uploads/arsip-foto/".$arsip->file);
            $html .= '<tr>';
            $html .= '<td><center>' . ($key + 1) . '</center></td>';
            $html .= '<td>';
            $html .= '<div class="symbol symbol-500 mr-5 align-self-start align-self-xxl-center">';
            $html .= '<div class="symbol-label" style="background-image:url(\'' . $foto . '\')"></div>';
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
