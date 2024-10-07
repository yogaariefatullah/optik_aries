@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">List Transaksi</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-sm btn-light-primary">
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
                    <strong>Success </strong>{{ Session::get('error') }}
                </div>
            @endif

            <div class="card-body py-3">
                <div class="row mb-3">
                    <div class="col">
                        <form action="{{ route('transaksi.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search transaksi...">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-80px rounded-start">NO</th>
                                <th class="min-w-200px">No Transaksi</th>
                                <th class="min-w-200px">Status Pelunasan</th>
                                <th class="min-w-200px">Nama</th>
                                <th class="min-w-200px">Resep Dokter</th>
                                <th class="min-w-200px">Lensa Kanan</th>
                                <th class="min-w-200px">Lensa Kiri</th>
                                <th class="min-w-200px">Frame</th>
                                <th class="min-w-125px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $key => $val)
                                <tr>
                                    <td>
                                        {{ ($transaksi->currentPage() - 1) * $transaksi->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->no_transaksi }}</span>
                                    </td>
                                    <td>
                                        <div data-bs-toggle="modal" data-bs-target="#StatusModal{{ $val->id }}"
                                            style="cursor: pointer;">
                                            <input type="checkbox" class="form-check-input"
                                                {{ $val->status_pelunasan == 1 ? 'checked' : '' }}
                                                style="pointer-events: none;">
                                        </div>
                                        </td>


                                        <td>
                                            <span
                                                class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->nama }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->resep_dr }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->lensa_nama }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->lensa_kiri }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->frame_nama }}</span>
                                        </td>
                                        <td class="">
                                            <a href="{{ route('transaksi.edit', $val->id) }}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <i class="ki-solid ki-pencil fs-2"></i>
                                            </a>
                                            <a href="{{ route('transaksi.print', $val->id) }}" target="_blank"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <i class="ki-solid ki-exit-down fs-2"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $val->id }}">
                                                <i class="ki-solid ki-trash fs-2"></i>
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
                                                    <span aria-hidden="true"><i class="ki-solid ki-cross fs-1"></i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus transaksi ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ route('transaksi.destroy', $val->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal hapus -->

                                <!-- modal hapus -->
                                <div class="modal fade" id="StatusModal{{ $val->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModal{{ $val->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Ubah
                                                    Data Transaksi ini?
                                                </h5>
                                                <button type="button" class="close btn btn-outline-light"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki-solid ki-cross fs-1"></i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Ubah
                                                Data Transaksi ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form action="{{ route('transaksi.status.pelunasan', $val->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger">Ubah</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal hapus -->
                            @endforeach
                        </tbody>
                    </table>

                    {{ $transaksi->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $transaksi->currentPage()]))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @if (session('open_new_tab'))
        <script>
            // Buka tab baru untuk menampilkan detail transaksi
            var newTab = window.open('{{ route('transaksi.print', Session::get('new-id')) }}', '_blank');
            newTab.focus();
        </script>
    @endif
@endsection
