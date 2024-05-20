@extends('layout.main')
@section('content')
<div class="class">
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">List Digitalisasi Arsip Foto</span>
            </h3>
            <div class="card-toolbar">
                <a href="{!! route('arsip.foto.create') !!}"><button type="button" data-bs-toggle="modal" data-bs-target=""
                    class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Tambah Data</button></a>
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
                            <th class="min-w-125px">Judul</th>
                            <th class="min-w-200px">Keterangan</th>
                            <th class="min-w-200px">Tahun</th>
                            <th class="min-w-200px rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($arsip_foto) == 0)
                            <tr>Data tidak ada</tr>
                        @else
                            @foreach($arsip_foto as $key => $val)
                                <tr>
                                    <td>
                                    {{ ($arsip_foto->currentPage() - 1) * $arsip_foto->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->subjek}}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->judul}}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->keterangan}}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->tahun}}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{route('arsip.foto.edit',$val->id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i class="ki-solid ki-pencil fs-2">
                                            </i>
                                        </a>
                                        <a href="{{route('arsip.foto.show',$val->id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i class="ki-solid ki-eye fs-2">
                                            </i>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"data-bs-toggle="modal" data-bs-target="#deleteModal{{$val->id}}">
                                            <i class="ki-solid ki-trash fs-2">
                                            
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $val->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Hapus Arsip</h5>
                                                <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                                                    </i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus Arsip ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('arsip.foto.destroy', $val->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $arsip_foto->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $arsip_foto->currentPage()]))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
