<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use App\User;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Activity;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class MasterUserController extends Controller
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

        $data['nama_menu'] = 'Setting User';

        $model = User::query();
        $query = $model->leftJoin('cabang', 'cabang.id', '=', 'users.cabang_id');
        // Periksa apakah ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = '%' . strtolower($request->input('search')) . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(users.nama) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(users.email) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(cabang.nama_cabang) LIKE ?', [$searchTerm]);
            });
        }

        // Ambil data subjek dengan paginate
        $data['user'] = $query->select('users.*', 'cabang.id as id_cabang', 'cabang.nama_cabang')->paginate(5);
        // dd($data['user']);

        return view('master.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['nama_menu'] = 'Settings user';

        $data['cabang'] = Cabang::orderBy('nama_cabang', 'asc')->get();

        return view('master.user.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'group_id' =>  $request->group_id,
            'cabang_id' =>  $request->cabang_id,
        ]);
        Session::flash('success', 'Data Berhasil di tambahkan');
        return redirect()->route('master.user.index');
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
        $data['nama_menu'] = 'Settings User';
        $data['user'] = User::findOrFail($id);

        $data['cabang'] = Cabang::get();

        return view('master.user.edit', $data);
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


        $menu = user::findorFail($id);
        if ($request->password == null) {
            $menu->update([
                'nama' => $request->nama,
                'email' =>  $request->email,
                'group_id' => $request->group_id,
                'cabang_id' =>  $request->cabang_id,
            ]);
        } else {
            $menu->update([
                'nama' => $request->nama,
                'email' =>  $request->email,
                'group_id' => $request->group_id,
                'cabang_id' =>  $request->cabang_id,
                'password' => Hash::make($request->password),
            ]);
        }


        Session::flash('success', 'Data Berhasil di edit');
        return redirect()->route('master.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('master.user.index')->with('Data Berhasil di Hapus');
    }
}
