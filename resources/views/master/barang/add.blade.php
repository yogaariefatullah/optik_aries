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
            <form method="POST" action="{{ route('master.barang.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Kode Barang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value=""
                                name="kode_barang"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Barang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value=""
                                name="nama_barang"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jumlah Stok</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="number" value=""
                                name="jumlah_stok"id="example-text-input" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Harga Jual</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="harga_jual" required />
                            <input type="hidden" name="harga_jual" id="harga_jual_hidden" required />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Harga Asli</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="harga_asli" required />
                            <input type="hidden" name="harga_asli" id="harga_asli_hidden" required />
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
                                    <option value="{{ $value->id }}">{{ $value->nama_cabang }}</option>
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
        $('#kt_select2_1').select2({
            placeholder: "Select a state",
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

        function formatRupiah(value) {
            if (!value) return '';
            return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
@endsection
