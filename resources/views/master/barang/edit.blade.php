@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Tambah Barang</span>
                </h3>
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

            <!--begin::Form-->
            <form method="POST" action="{{ route('master.barang.update', $barang->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Kode Barang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="{{ $barang->kode_barang }}"
                                name="kode_barang"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Barang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="{{ $barang->nama_barang }}"
                                name="nama_barang"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jenis Barang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <select name="jenis_barang" id="jenis_barang" aria-label="Select a Country"
                                data-control="select2" data-placeholder="Select a Group..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                                @if ($barang->jenis_barang == '1')
                                    <option value="0">Pilih Jenis Barang</option>
                                    <option value="1" selected="selected">Lensa</option>
                                    <option value="2">Frame</option>
                                @elseif($barang->group_id == '2')
                                    <option value="0">Pilih Jenis Barang</option>
                                    <option value="1">Lensa</option>
                                    <option value="2" selected="selected">Frame</option>
                                @else
                                    <option value="0">Pilih Jenis Barang</option>
                                    <option value="1">Lensa</option>
                                    <option value="2">Frame</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jumlah Stok</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="number" value="{{ $barang->jumlah_stok }}"
                                name="jumlah_stok"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Harga Jual</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="harga_jual"
                                value="{{ number_format($barang->harga_jual, 0, ',', '.') }}" required />
                            <input type="hidden" name="harga_jual" id="harga_jual_hidden" value="{{ $barang->harga_jual }}"
                                required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Harga Asli</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="harga_asli"
                                value="{{ number_format($barang->harga_asli, 0, ',', '.') }}" required />
                            <input type="hidden" name="harga_asli" id="harga_asli_hidden" value="{{ $barang->harga_asli }}"
                                required />
                        </div>
                    </div>

                    &nbsp;
                    <div class="form-group row" id="cabang" style="">
                        <label class="col-2 col-form-label">Cabang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class=" col-8">
                            <select name="cabang" aria-label="Select a Country" data-control="select2"
                                data-placeholder="Select a Cabang..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="0">Pilih Cabang</option>
                                @foreach ($cabang as $key => $value)
                                    @if ($barang->cabang == $value->id)
                                        <option value="{{ $value->id }}" selected="selected">{{ $value->nama_cabang }}
                                        </option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->nama_cabang }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ route('master.barang.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var hargaAsliInput = document.getElementById('harga_asli');
            var hargaAsliHidden = document.getElementById('harga_asli_hidden');

            hargaAsliInput.addEventListener('input', function(e) {
                var value = e.target.value.replace(/[^0-9]/g, '');
                hargaAsliHidden.value = value;

                e.target.value = formatRupiah(value);
            });

            function formatRupiah(value) {
                if (!value) return '';
                return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Format the initial value
            if (hargaAsliHidden.value) {
                hargaAsliInput.value = formatRupiah(hargaAsliHidden.value);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var hargaAsliInput = document.getElementById('harga_jual');
            var hargaAsliHidden = document.getElementById('harga_jual_hidden');

            hargaAsliInput.addEventListener('input', function(e) {
                var value = e.target.value.replace(/[^0-9]/g, '');
                hargaAsliHidden.value = value;

                e.target.value = formatRupiah(value);
            });

            function formatRupiah(value) {
                if (!value) return '';
                return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Format the initial value
            if (hargaAsliHidden.value) {
                hargaAsliInput.value = formatRupiah(hargaAsliHidden.value);
            }
        });

        document.getElementById('harga_jual').addEventListener('input', function(e) {
            var value = e.target.value.replace(/[^0-9]/g, '');
            document.getElementById('harga_jual_hidden').value = value;

            e.target.value = formatRupiah(value);
        });

        document.getElementById('harga_asli').addEventListener('input', function(e) {
            var value = e.target.value.replace(/[^0-9]/g, '');
            document.getElementById('harga_asli_hidden').value = value;

            e.target.value = formatRupiah(value);
        });

        $('#kt_select2_1').select2({
            placeholder: "Select a state",
        });


        function formatRupiah(value) {
            if (!value) return '';
            return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
@endsection
