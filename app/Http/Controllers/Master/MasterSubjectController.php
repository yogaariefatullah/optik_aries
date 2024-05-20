<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterSubjectController extends Controller
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
        
        $data['nama_menu'] = 'Master Subjek';

        $query = Subject::query();

        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $query->where('subjek', 'ilike', '%' . $request->input('search') . '%');
        }
    
        // Ambil data subjek dengan paginate
        $data['subjek'] = $query->paginate(5);
        
        return view('master.subject.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'subjek' => "required",
            ]);
        Subject::create([
            'id' => Str::uuid(),
            'subjek' => $request->subjek,
            'status' => 1
        ]);
        Session::flash('success', 'Subjek Berhasil Ditambahkan.');
        return redirect()->route('master.subject.index');

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
        $User = User::find($id);
        return response()->json($User);
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
            'subjek' => "required",
            'status' => "required",
            ]);
        
        $subjek = Subject::findorFail($id);

        $subjek->update([
            'subjek' => $request->subjek,
            'status' => $request->status
        ]);
        Session::flash('success', 'Subjek Berhasil Edit.');
        return redirect()->route('master.subject.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('master.subject.index')->with('success', 'Subjek berhasil dihapus.');
    }
}
