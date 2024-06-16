@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Rekap Barang Keluar</span>
                </h3>
            </div>

            <div class="card-body py-3">
                <div class="row mb-3">
                    <div class="col">
                        <form action="{{ route('rekap-barang-keluar.index') }}" method="GET">
                            <div class="input-group">
                                <div class="form-group row" id="cabang" style="">
                                    <div class=" col-12">
                                        <select name="cabang" aria-label="Select a Country" data-control="select2"
                                            data-placeholder="Select a Cabang..."
                                            class="form-select form-select-solid form-select-lg fw-semibold">
                                            <option value="0">Pilih Cabang</option>
                                            @foreach ($cabang as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="cabang" style="">
                                    <div class=" col-12">
                                        <input class="form-control" type="date" value=""
                                            name="tgl"id="example-text-input" />
                                    </div>
                                </div>
                                <div class="form-group row" id="cabang" style="">
                                    <div class=" col-12">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-80px rounded-start">NO</th>
                                <th class="min-w-200px">Tanggal</th>
                                <th class="min-w-200px">Frame</th>
                                <th class="min-w-200px">Lensa</th>
                                <th class="min-w-200px">Nama Cabang</th>
                                <th class="min-w-200px">Jumlah</th>
                                <th class="min-w-200px">Keterangan</th>
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
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->tanggal }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->frame_nama}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->lensa_nama }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->nama_cabang }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ formatRupiah($val->jumlah) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{ $val->keterangan }}</span>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $barang->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $barang->currentPage()]))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection