@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">List Master Barang</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('master.barang.create') }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Data</a>
                </div>
            </div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>Success </strong>{{ Session::get('success') }}
                </div>
            @endif
           
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>Error </strong>{{ Session::get('error') }}
                </div>
            @endif

            <div class="card-body py-3">
                <div class="table-responsive">
                    <div class="row mb-3">
                        <div class="col">
                            <form action="{{ route('master.barang.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search barang...">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-80px rounded-start">NO</th>
                                <th class="min-w-200px">Kode Barang</th>
                                <th class="min-w-200px">Nama Barang</th>
                                <th class="min-w-200px">Nama Cabang</th>
                                <th class="min-w-200px">Jumlah Stok</th>
                                <th class="min-w-200px">Harga Jual</th>
                                <th class="min-w-200px">Harga Asli</th>
                                <th class="min-w-125px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $key => $val)
                                <tr>
                                    <td>
                                        {{ ($barang->currentPage() - 1) * $barang->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->kode_barang }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->nama_barang }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->nama_cabang }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->jumlah_stok }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ formatRupiah($val->harga_jual) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ formatRupiah($val->harga_asli) }}</span>

                                    </td>


                                    <td class="">
                                        <a href="{{ route('master.barang.edit', $val->id) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <i class="ki-solid ki-pencil fs-2">
                                            </i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $val->id }}">
                                            <i class="ki-solid ki-trash fs-2">

                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- modal hapus -->
                                <div class="modal fade" id="deleteModal{{ $val->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModal{{ $val->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Hapus Menu
                                                </h5>
                                                <button type="button" class="close btn btn-outline-light"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                                                        </i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus Barang ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ route('master.barang.destroy', $val->id) }}"
                                                    method="POST">
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
                    {{ $barang->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $barang->currentPage()]))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
