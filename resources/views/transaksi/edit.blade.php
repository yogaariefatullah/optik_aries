@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Edit transaksi</span>
                </h3>
            </div>
            <div class="row container">
                <div class="d-flex justify-content-between">
                    <img alt="Logo" src="{{ asset('assets/media/logos/aries.png') }}" style="height:100px;"
                        class="logo img-logo theme-light-show">
                    <label>No {{ $transaksi->no_transaksi }}</label>
                </div>

            </div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>Success </strong>{{ Session::get('success') }}
                </div>
            @endif
            @if ($errors->has('subjek'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $errors->first('subjek') }}</strong>
                </div>
            @endif

            <!--begin::Form-->
            <form method="POST" action="{{ route('transaksi.update', $transaksi->id) }}">
                @csrf
                @method('put')
                <div class="card-body">
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th,
                        td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: center;
                        }

                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                    <table>
                        <thead>
                            <tr>
                                <th colspan="10">Optik Aries</th>
                            </tr>
                            <tr>
                                <th colspan="5">OD (Mata Kanan)</th>
                                <th colspan="5">OS (Mata Kiri)</th>
                            </tr>
                            <tr>
                                <th>Spher</th>
                                <th>Cylders</th>
                                <th>Axis</th>
                                <th>Prism</th>
                                <th>Base</th>
                                <th>Spher</th>
                                <th>Cylders</th>
                                <th>Axis</th>
                                <th>Prism</th>
                                <th>Base</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-control floatInput" type="text" value="{{ $transaksi->spher_od }}"
                                        placeholder="spher" name="spher_od" /></td>
                                <td><input class="form-control floatInput" type="text"
                                        value="{{ $transaksi->cylders_od }}" placeholder="cylders" name="cylders_od" /></td>
                                <td>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">x</label>
                                        <div class="col-10">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->axis_od }}" placeholder="axis" name="axis_od" />
                                        </div>
                                    </div>
                                </td>
                                <td><input class="form-control floatInput" type="text" value="{{ $transaksi->prism_od }}"
                                        placeholder="prism" name="prism_od" /></td>
                                <td><input class="form-control floatInput" type="text" value="{{ $transaksi->base_od }}"
                                        placeholder="base" name="base_od" /></td>
                                <!-- atas od bawah os -->
                                <td><input class="form-control floatInput" type="text"
                                        value="{{ $transaksi->spher_os }}" placeholder="spher" name="spher_os" /></td>
                                <td><input class="form-control floatInput" type="text"
                                        value="{{ $transaksi->cylders_os }}" placeholder="cylders" name="cylders_os" />
                                </td>
                                <td>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">x</label>
                                        <div class="col-10">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->axis_os }}" placeholder="axis" name="axis_os" />
                                        </div>
                                    </div>
                                </td>
                                <td><input class="form-control floatInput" type="text"
                                        value="{{ $transaksi->prism_os }}" placeholder="prism" name="prism_os" /></td>
                                <td><input class="form-control floatInput" type="text" value="{{ $transaksi->base_os }}"
                                        placeholder="base" name="base_os" /></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Add</label>
                                        <div class="col-10">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->add_od }}" placeholder="add" name="add_od" />
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">PD</label>
                                        <div class="col-9">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->pd_od }}" placeholder="pd" name="pd_od" />
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group row">
                                        <label class="col-4 col-form-label">T.Seg.</label>
                                        <div class="col-8">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->tseg_os }}" placeholder="tseg" name="tseg_os" />
                                        </div>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Add</label>
                                        <div class="col-10">
                                            <input class="form-control floatInput" type="text"
                                                value="{{ $transaksi->add_os }}" placeholder="add" name="add_os" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Jenis Lens Kanan</label>
                                        <div class="col-4">
                                            <input type="hidden" name="lensa_old" value="{{ $transaksi->lensa_id }}">
                                            <select name="lensa_id" id="lensa_id" aria-label="Pilih lensa"
                                                data-control="select2" data-placeholder="Pilih lensa..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">

                                                <option value="">Pilih lensa</option>

                                                @foreach ($data_lensa as $key => $value)
                                                    <option data-harga="{{ $value->harga_jual }}"
                                                        value="{{ $value->id }}"
                                                        {{ $transaksi->lensa_id == $value->id ? 'selected' : '' }}>
                                                        {{ $value->nama_barang }}
                                                    </option>
                                                @endforeach

                                                <!-- Tampilkan lensa yang stoknya habis jika ada -->
                                                @if (isset($lensa_habis))
                                                    <option data-harga="{{ $lensa_habis->harga_jual }}"
                                                        value="{{ $lensa_habis->id }}" selected>
                                                        {{ $lensa_habis->nama_barang }} (stok habis)
                                                    </option>
                                                @endif

                                                <!-- Opsi 'Pribadi' -->
                                                <option data-harga="0" value="pribadi"
                                                    {{ $transaksi->lensa_id == 'pribadi' || is_null($transaksi->lensa_id) ? 'selected' : '' }}>
                                                    Pribadi
                                                </option>
                                            </select>

                                        </div>
                                        <label class="col-2 col-form-label">Order Tanggal</label>
                                        <div class="col-4">
                                            <div class="input-group" id="kt_td_picker_date_only"
                                                data-td-target-input="nearest" data-td-target-toggle="nearest">
                                                <input id="kt_td_picker_date_only_input"
                                                    value="{{ $transaksi->order_tanggal }}" name="order_tanggal"
                                                    type="text" class="form-control"
                                                    data-td-target="#kt_td_picker_date_only" />
                                                <span class="input-group-text" data-td-target="#kt_td_picker_date_only"
                                                    data-td-toggle="datetimepicker">
                                                    <i class="ki-duotone ki-calendar fs-2"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Jenis Lensa Kiri</label>
                                        <div class="col-4">
                                            <select name="lensa_id_kiri" id="lensa_id_kiri" aria-label="Pilih Lensa"
                                                data-control="select2" data-placeholder="Pilih Lensa..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">

                                                <option value="">Pilih lensa</option>

                                                @foreach ($data_lensa as $key => $value)
                                                    <option data-harga="{{ $value->harga_jual }}"
                                                        value="{{ $value->id }}"
                                                        {{ $transaksi->lensa_id_kiri == $value->id ? 'selected' : '' }}>
                                                        {{ $value->nama_barang }}
                                                    </option>
                                                @endforeach

                                                <!-- Tampilkan lensa yang stoknya habis jika ada -->
                                                @if (isset($lensa_kiri_habis))
                                                    <option data-harga="{{ $lensa_kiri_habis->harga_jual }}"
                                                        value="{{ $lensa_kiri_habis->id }}" selected>
                                                        {{ $lensa_kiri_habis->nama_barang }} (stok habis)
                                                    </option>
                                                @endif

                                                <!-- Opsi 'Pribadi' -->
                                                <option data-harga="0" value="pribadi"
                                                    {{ $transaksi->lensa_id_kiri == 'pribadi' || is_null($transaksi->lensa_id_kiri) ? 'selected' : '' }}>
                                                    Pribadi
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Jenis Frame</label>
                                        <div class="col-4">
                                            <input type="hidden" name="frame_old" value="{{ $transaksi->frame_id }}">
                                            <select name="frame_id" id="frame_id" aria-label="Pilih Frame"
                                                data-control="select2" data-placeholder="Pilih Frame..."
                                                class="form-select form-select-solid form-select-lg fw-semibold">

                                                <option value="">Pilih Frame</option>

                                                @foreach ($data_frame as $key => $value)
                                                    <option data-harga="{{ $value->harga_jual }}"
                                                        value="{{ $value->id }}"
                                                        {{ $transaksi->frame_id == $value->id ? 'selected' : '' }}>
                                                        {{ $value->nama_barang }}
                                                    </option>
                                                @endforeach

                                                <!-- Tampilkan frame yang stoknya habis jika ada -->
                                                @if (isset($frame_habis))
                                                    <option data-harga="{{ $frame_habis->harga_jual }}"
                                                        value="{{ $frame_habis->id }}" selected>
                                                        {{ $frame_habis->nama_barang }} (stok habis)
                                                    </option>
                                                @endif

                                                <!-- Opsi 'Pribadi' -->
                                                <option data-harga="0" value="pribadi"
                                                    {{ $transaksi->frame_id == 'pribadi' || is_null($transaksi->frame_id) ? 'selected' : '' }}>
                                                    Pribadi
                                                </option>
                                            </select>


                                        </div>
                                        <label class="col-2 col-form-label">Tanggal Selesai</label>
                                        <div class="col-4">
                                            <div class="input-group" id="kt_td_picker_date_only_1"
                                                data-td-target-input="nearest" data-td-target-toggle="nearest">
                                                <input id="kt_td_picker_date_only_input1"
                                                    value="{{ $transaksi->tanggal_selesai }}" name="tanggal_selesai"
                                                    type="text" class="form-control"
                                                    data-td-target="#kt_td_picker_date_only_1" />
                                                <span class="input-group-text" data-td-target="#kt_td_picker_date_only_1"
                                                    data-td-toggle="datetimepicker">
                                                    <i class="ki-duotone ki-calendar fs-2"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Lain Lain</label>
                                        <div class="col-4">
                                            <input class="form-control" type="text"
                                                value="{{ $transaksi->lain_lain }}" name="lain_lain" />
                                        </div>
                                        <label class="col-2 col-form-label">Nama</label>
                                        <div class="col-4">
                                            <input class="form-control" type="text" value="{{ $transaksi->nama }}"
                                                id="nama" name="nama" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>



                    &nbsp;

                    &nbsp;

                    <hr>

                    <div class="row container">
                        <div class="d-flex justify-content-between">
                            <img alt="Logo" src="{{ asset('assets/media/logos/aries.png') }}" style="height:100px;"
                                class="logo img-logo theme-light-show">
                            <label>No {{ $transaksi->no_transaksi }}</label>
                        </div>

                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="{{ $transaksi->nama }}" id="label_nama"
                                disabled />
                        </div>

                        <label class="col-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="{{ $transaksi->tanggal_selesai }}"
                                disabled id="label_tanggal" />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Alamat</label>
                        <div class="col-4">
                            <textarea name="alamat" class="form-control" id="">{{ $transaksi->alamat }}</textarea>
                        </div>

                        <label class="col-2 col-form-label">Jam</label>
                        <div class="col-4">
                            <input class="form-control" type="time" value="{{ $transaksi->jam }}" name="jam" />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Telepon</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="{{ $transaksi->no_telp }}" name="no_telp"
                                id="example-text-input" />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Resep dr./ref</label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="{{ $transaksi->resep_dr }}"
                                name="resep_dr" id="example-text-input" />
                        </div>

                        <label class="col-2 col-form-label">Jumlah</label>
                        <div class="col-4">
                            <input class="form-control uangs" id="jumlah" type="text"
                                value="{{ $transaksi->jumlah }}" name="jumlah" id="example-text-input" readonly />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Lensa Kiri</label>
                        <div class="col-4">
                            <input class="form-control" disabled type="text"
                                value="{{ $text_lensa_kiri ? $text_lensa_kiri->nama_barang : 'Pribadi' }}"
                                id="label_lensa_kiri" />
                        </div>
                        <label class="col-2 col-form-label">Diskon</label>
                        <div class="col-2">
                            <input class="form-control uangs" id="diskon" type="text"
                                value="{{ $transaksi->diskon }}" name="diskon" id="example-text-input" />
                            <p style="color: red">*) Tulis 0 jika tanpa diskon</p>
                        </div>
                        <div class="col-2">
                            <input class="form-control" type="text" value="RP" id="example-text-input"
                                disabled />
                        </div>

                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Lensa Kanan</label>
                        <div class="col-4">
                            <input class="form-control" disabled type="text"
                                value="{{ $text_lensa ? $text_lensa->nama_barang : 'Pribadi' }}" id="label_lensa" />
                        </div>
                        <label class="col-2 col-form-label">Uang Muka</label>
                        <div class="col-4">
                            <input class="form-control uangs" id="uang_muka" type="text"
                                value="{{ $transaksi->uang_muka }}" name="uang_muka" id="example-text-input" />
                        </div>

                    </div>
                    &nbsp;
                    <div class="form-group row">

                        <label class="col-2 col-form-label">Frame</label>
                        <div class="col-4">
                            <input class="form-control" disabled type="text"
                                value="{{ $text_frame ? $text_frame->nama_barang : 'Pribadi' }}" id="label_frame" />
                        </div>
                        <label class="col-2 col-form-label">Sisa</label>
                        <div class="col-4">
                            <input class="form-control uangs" id="sisa" type="text"
                                value="{{ $transaksi->sisa }}" name="sisa" id="example-text-input" />
                        </div>

                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {

            $('.floatInput').inputmask({
                alias: 'decimal',
                digits: 2,
                digitsOptional: false,
                placeholder: '0',
                radixPoint: '.',
                autoGroup: true,
                groupSeparator: ',',
                rightAlign: false
            });

            $('.uangs').inputmask({
                alias: 'decimal',
                digits: 0,
                digitsOptional: false,
                placeholder: '0',
                radixPoint: '.',
                autoGroup: true,
                groupSeparator: ',',
                rightAlign: false
            });

            // Menyimpan nilai asli dari jumlah saat halaman dimuat
            var originalJumlah = parseFloat($('#jumlah').val().replace(/,/g, '')) || 0;
            $('#jumlah').data('original-jumlah', originalJumlah);

            var previousHargaLensaKiri = 0;
            var previousHargaLensa = 0;
            var previousHargaFrame = 0;

            function updateJumlah() {
                var hargaLensaKiri = previousHargaLensaKiri;
                var hargaLensa = previousHargaLensa;
                var hargaFrame = previousHargaFrame;

                // Ambil kembali nilai asli dari data
                var originalJumlah = parseFloat($('#jumlah').data('original-jumlah')) || 0;

                // Tambahkan atau kurangi nilai harga tergantung pada apakah mereka diubah menjadi 0 atau bukan
                var newJumlah = hargaLensaKiri + hargaLensa + hargaFrame;

                console.log("Harga Lensa Kiri: ", hargaLensaKiri);
                console.log("Harga Lensa: ", hargaLensa);
                console.log("Harga Frame: ", hargaFrame);
                console.log("Original Jumlah: ", originalJumlah);
                console.log("New Jumlah: ", newJumlah);

                $('#jumlah').val(newJumlah.toFixed(2));
                updateSisa(); // Update sisa after updating jumlah
            }

            function updateSisa() {
                var jumlah = parseFloat($('#jumlah').val().replace(/,/g, '')) || 0;
                var uang_muka = parseFloat($('#uang_muka').val().replace(/,/g, '')) || 0;
                var diskon = parseFloat($('#diskon').val().replace(/,/g, '')) || 0;

                var jumlahSetelahDiskon = jumlah - diskon;
                var total = jumlahSetelahDiskon - uang_muka;

                // Menampilkan total di elemen dengan id "sisa"
                $('#sisa').val(total.toFixed(2));
            }

            $("#lensa_id_kiri").change(function() {
                var selectedText = $("#lensa_id_kiri option:selected").text();
                var selectedHarga = parseFloat($("#lensa_id_kiri option:selected").data('harga')) || 0;

                // Perbarui original jumlah sebelum memperbarui previousHargaLensaKiri
                var originalJumlah = parseFloat($('#jumlah').data('original-jumlah')) || 0;
                originalJumlah -= previousHargaLensaKiri;
                $('#jumlah').data('original-jumlah', originalJumlah);

                // Perbarui previousHargaLensaKiri dengan selectedHarga baru
                previousHargaLensaKiri = selectedHarga;

                updateJumlah();
                $("#label_lensa_kiri").val(selectedText);
            });

            $("#lensa_id").change(function() {
                var selectedText = $("#lensa_id option:selected").text();
                var selectedHarga = parseFloat($("#lensa_id option:selected").data('harga')) || 0;

                // Perbarui original jumlah sebelum memperbarui previousHargaLensa
                var originalJumlah = parseFloat($('#jumlah').data('original-jumlah')) || 0;
                originalJumlah -= previousHargaLensa;
                $('#jumlah').data('original-jumlah', originalJumlah);

                // Perbarui previousHargaLensa dengan selectedHarga baru
                previousHargaLensa = selectedHarga;

                updateJumlah();
                $("#label_lensa").val(selectedText);
            });

            $("#frame_id").change(function() {
                var selectedText = $("#frame_id option:selected").text();
                var selectedHarga = parseFloat($("#frame_id option:selected").data('harga')) || 0;

                // Perbarui original jumlah sebelum memperbarui previousHargaFrame
                var originalJumlah = parseFloat($('#jumlah').data('original-jumlah')) || 0;
                originalJumlah -= previousHargaFrame;
                $('#jumlah').data('original-jumlah', originalJumlah);

                // Perbarui previousHargaFrame dengan selectedHarga baru
                previousHargaFrame = selectedHarga;

                updateJumlah();
                $("#label_frame").val(selectedText);
            });

            $('#diskon').change(function() {
                updateJumlah(); // Ensure the original amount is recalculated
            });

            $('#uang_muka').change(function() {
                updateSisa();
            });

            // Trigger changes on initial load to set default values
            var frameSelect = $("#frame_id");
            if (!frameSelect.val()) {
                frameSelect.val("0").trigger('change');
            }
            var lensaSelect = $("#lensa_id");
            if (!lensaSelect.val()) {
                lensaSelect.val("0").trigger('change');
            }
            var lensaKiriSelect = $("#lensa_id_kiri");
            if (!lensaKiriSelect.val()) {
                lensaKiriSelect.val("0").trigger('change');
            }
        });




        $('#nama').on('input', function() {
            var nama = $(this).val();
            $('#label_nama').val(nama)
        })


        $('#kt_td_picker_date_only_input1').on('change', function(e) {
            console.log(e);
            var newValue = $(this).val();
            // Set the value of the target input element (replace "target_date_input" with your actual ID)
            $('#label_tanggal').val(newValue); // Format the date (optional)
        });



        $('#kt_td_picker_date_only_input1').on('change', function(e) {
            console.log(e);
            var newValue = $(this).val();
            // Set the value of the target input element (replace "target_date_input" with your actual ID)
            $('#label_tanggal').val(newValue); // Format the date (optional)
        });
        new tempusDominus.TempusDominus(document.getElementById("kt_td_picker_date_only"), {
            display: {
                viewMode: "calendar",
                components: {
                    decades: true,
                    year: true,
                    month: true,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            },
            localization: {
                locale: "id",
                startOfTheWeek: 1,
                format: "dd/MM/yyyy"
            }
        });
        new tempusDominus.TempusDominus(document.getElementById("kt_td_picker_date_only_1"), {
            display: {
                viewMode: "calendar",
                components: {
                    decades: true,
                    year: true,
                    month: true,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            },
            localization: {
                locale: "id",
                startOfTheWeek: 1,
                format: "dd/MM/yyyy"
            }
        });
    </script>
@endsection
