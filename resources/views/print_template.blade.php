<title>Aries Optical</title>
<meta charset="utf-8" />
<meta name="description"
    content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
{{-- <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" /> --}}
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="LIVRA" />
{{-- <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/media/logos/Livra Logo.png') }}" /> --}}
<link href="{{ asset('assets/media/logos/aries.png') }}" type="image/png" rel="icon">
<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/real3d-flip-book/css/flipbook.style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/real3d-flip-book/css/font-awesome.css') }}">
<!--end::Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet">
<!--end::Global Stylesheets Bundle-->
<script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
</script>
<style type="text/css">
    @media print {
        @page {
            size: A4;
            /* Set the page size to A4 */
            margin: 0;
            /* Menghilangkan margin default */
        }

        header,
        footer {
            display: none;
            /* Menyembunyikan header dan footer */
        }

        .no-print {
            display: none;
        }
    }

    @media (max-width: 991.98px) {
        .aside-logo {
            display: block !important;
        }

        .img-logo {
            height: 95px !important;
        }

    }

    @media (max-width: 991.98px) {
        .logo-utama {
            display: none !important;
        }
    }

    .menu-link {
        color: #3A69B2 !important;
    }

    .active {
        transition: color .2s ease !important;
        background-color: #3a69b2 !important;
        color: white !important;
    }

    .caret {

        display: inline-block;
        width: 0;
        height: 0;
        margin-left: 2px;
        vertical-align: middle;
        border-top: 4px dashed;
        border-top: 4px solid\9;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        display: none;
    }

    .custom-form-input {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .loader2 {
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #3498db;
        width: 15px;
        height: 15px;
        animation: spin 2s linear infinite;
        margin: auto auto 1% auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="card" style="border:none;">
    <div class="row container">
        <div class="d-flex justify-content-between">
            <img alt="Logo" src="{{ asset('assets/media/logos/aries.png') }}" style="height:100px;"
                class="logo img-logo theme-light-show">

            <label style="margin-top : 10%">No {{ $transaksi->no_transaksi }}</label>
        </div>

    </div>
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
                    <td><label>{{ $transaksi->spher_od }}</label></td>
                    <td><label>{{ $transaksi->cylders_od }}</label></td>
                    <td><label>{{ $transaksi->axis_od }}</label></td>
                    <td><label>{{ $transaksi->prism_od }}</label></td>
                    <td><label>{{ $transaksi->base_od }}</label></td>
                    <!-- atas od bawah os -->
                    <td><label>{{ $transaksi->spher_os }}</label></td>
                    <td><label>{{ $transaksi->cylders_os }}</label></td>
                    <td><label>{{ $transaksi->axis_os }}</label></td>
                    <td><label>{{ $transaksi->prism_os }}</label></td>
                    <td><label>{{ $transaksi->base_os }}</label></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Add</label>
                            <label class="col-10 col-form-label">{{ $transaksi->add_od }}</label>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="form-group row">
                            <label class="col-3 col-form-label">PD</label>
                            <label class="col-9 col-form-label">{{ $transaksi->pd_od }}</label>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">T.Seg.</label>
                            <label class="col-8 col-form-label">{{ $transaksi->tseg_os }}</label>
                        </div>
                    </td>
                    <td colspan="3">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Add</label>
                            <label class="col-10 col-form-label">{{ $transaksi->add_os }}</label>
                        </div>
                    </td>

                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Jenis Lensa : </label>
                            <label
                                class="col-4 col-form-label">{{ $text_lensa ? $text_lensa->nama_barang : 'Pribadi' }}"</label>

                            <label class="col-2 col-form-label">Order Tanggal : </label>
                            <label class="col-4 col-form-label">{{ $transaksi->order_tanggal }}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="10">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Jenis Frame : </label>
                            <label
                                class="col-4 col-form-label">{{ $text_frame ? $text_frame->nama_barang : 'Pribadi' }}"</label>

                            <label class="col-2 col-form-label">Tanggal Selesai:</label>
                            <label class="col-4 col-form-label">{{ $transaksi->tanggal_selesai }}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="10">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Lain Lain : </label>
                            <label class="col-4 col-form-label">{{ $transaksi->lain_lain }}</label>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
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
            <label class="col-2 col-form-label">Nama : </label>
            <label class="col-4 col-form-label">{{ $transaksi->nama }}</label>

            <label class="col-2 col-form-label">Tanggal Selesai:</label>
            <label class="col-4 col-form-label">{{ $transaksi->tanggal_selesai }} </label>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Alamat : </label>
            <label class="col-4 col-form-label">{{ $transaksi->alamat }}</label>

            <label class="col-2 col-form-label">Jam : </label>
            <label class="col-4 col-form-label">{{ $transaksi->jam }}</label>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Telepon : </label>
            <label class="col-4 col-form-label">{{ $transaksi->no_telp }}</label>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Resep dr./ref : </label>
            <label class="col-4 col-form-label">{{ $transaksi->resep_dr }}</label>

            <label class="col-2 col-form-label">Jumlah : </label>
            <label class="col-4 col-form-label">{{ number_format($transaksi->jumlah, 0, ',', '.') }}</label>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Lensa : </label>
            <label class="col-4 col-form-label">{{ $text_lensa ? $text_lensa->nama_barang : 'Pribadi' }}"</label>
            <label class="col-2 col-form-label">Diskon : </label>
            <label class="col-4 col-form-label">{{ $transaksi->diskon }}</label>
        </div>

        <div class="form-group row">
            <label class="col-2 col-form-label">Frame : </label>
            <label class="col-4 col-form-label">{{ $text_frame ? $text_frame->nama_barang : 'Pribadi' }}"</label>

            <label class="col-2 col-form-label">Uang Muka : </label>
            <label class="col-4 col-form-label">{{ number_format($transaksi->uang_muka, 0, ',', '.') }}</label>
        </div>
        <div class="form-group row">
            <label class="col-2 col-form-label"> </label>
            <label class="col-4 col-form-label"></label>

            <label class="col-2 col-form-label">Sisa : </label>
            <label class="col-4 col-form-label">{{ number_format($transaksi->sisa, 0, ',', '.') }}</label>
        </div>
        <ul>
            <li>Pesanan sesudah 2 bulan tidak diambil perusahaan tidak bertanggung jawab</li>
            <li>Pesanan yg dibatalkan uang muka dianggap hilang</li>
            <li>Barang yang sudah dibeli tidak dapat dikembalikan/ditukar kecuali ada perjanjian</li>
        </ul>
        <br>
        <br>
        <br
        <div class="row container">
            <div class="d-flex justify-content-between">
                <p>{{ $transaksi->nama }}</p>
                <p>{{ Auth::user()->nama }}</p>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        window.print();
    });
</script>
