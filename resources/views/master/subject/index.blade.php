@extends('layout.main')
@section('content')
<div class="class">
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">List Master Subjek</span>
            </h3>
            <div class="card-toolbar">
                <button type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_select_users"
                    class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Data</button>
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>Success </strong>{{ Session::get('success') }}
            </div>
        @endif
        @if($errors->has('subjek'))
            <div class="alert alert-danger" role="alert">
                <strong>{{ $errors->first('subjek') }}</strong>
            </div>
        @endif

        <div class="card-body py-3">
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col">
                        <form action="{{ route('master.subject.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari subjek...">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-80px rounded-start">NO</th>
                            <th class="min-w-200px">Subjek</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-200px">Date</th>
                            <th class="min-w-200px rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjek as $key => $val)
                        <tr>
                            <td>
                             {{ ($subjek->currentPage() - 1) * $subjek->perPage() + $loop->index + 1 }}
                            </td>
                            <td>
                                <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->subjek}}</span>
                            </td>
                            <td>
                                @if($val->status == 1)
                                <span class="badge badge-light-success fs-7 fw-bold">Aktif</span>
                                @else
                                <span class="badge badge-light-danger fs-7 fw-bold">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->created_at}}</span>
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal{{$val->id}}">
                                    <i class="ki-solid ki-pencil fs-2">
                                    </i>
                                </a>
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"data-bs-toggle="modal" data-bs-target="#deleteModal{{$val->id}}">
                                    <i class="ki-solid ki-trash fs-2">
                                       
                                    </i>
                                </a>
                            </td>
                        </tr>
                        <!-- modal edit -->
                        <div class="modal fade" id="editModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $val->id }}Label" aria-hidden="true">
                            <div class="modal-dialog mw-700px" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Edit Subjek</h5>
                                        <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                                            </i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body mx-5 mx-xl-10 pt-0 pb-15">
                                        <div class="mb-13">
                                            <form method="POST" action="{{ route('master.subject.update', $val->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="d-flex justify-content-center align-items-center pt-4">Subjek</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input id="" type="text" class="form-control @error('email') is-invalid @enderror"
                                                            name="subjek" value="{{ $val->subjek }}" required autofocus>
                                                    </div>
                                                </div>
                                                &nbsp;
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="d-flex justify-content-center align-items-center pt-4">Status</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select name="status" class="form-control" id="">
                                                            <option value="1" @if($val->status == 1) selected @endif>Aktif</option>
                                                            <option value="2" @if($val->status == 2) selected @endif>Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-9"></div>
                                                    <div class="col-3">
                                                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal hapus -->
                        <div class="modal fade" id="deleteModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $val->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Hapus Subjek</h5>
                                        <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                                            </i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus subjek ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('master.subject.destroy', $val->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal hapus -->
                        @endforeach
                    </tbody>
                </table>
                {{ $subjek->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $subjek->currentPage()]))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_select_users" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Tambah Subjek</h5>
                    <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                        </i></span>
                    </button>
                </div>
                <div class="modal-body  mx-5 mx-xl-10 pt-0 pb-15">
                    <div class="mb-13">
                        <form method="POST" action="{{ route('master.subject.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-3">
                                    <label class="d-flex justify-content-center align-items-center pt-4">Subjek</label>
                                </div>
                                <div class="col-9">
                                    <input id="" type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="subjek" value="" required autofocus>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9"></div>
                                <div class="col-3 mt-2">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
