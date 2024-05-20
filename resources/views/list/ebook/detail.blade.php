@extends('layout.main_type')
@section('content')
<div class="class">
    <div class=" mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5 mb-4  ">
            <h1 class="card-title align-items-start flex-column">
                E-Book
            </h1>
        </div>
        <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
            <div class="col-md-2 col-lg-2 col-xl-2">
                <div class="h-100">
                    <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <div class="symbol symbol-200px mb-5">
                            <img src="{{asset('uploads/pustaka-buku/cover/'.$pustaka_buku->cover)}}" class="theme-light-show" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-xl-8">
                <div class=""  style="text-align:left">
                    <div class="card-body flex-column p-8">
                        <div class="card-px pt-0">
                            <p class="fs-4 fw-semibold mb-0">{{$pustaka_buku->pengarang}}</p>
                            <h2 class="fs-2x fw-bold mb-4">{{$pustaka_buku->judul}}</h2>
                            <p class="fs-4 fw-bold">Deskripsi Buku</p>
                            <div class="mb-10">{{$pustaka_buku->deskripsi}}</div>
                            <h2 class="fs-2 fw-bold">Informasi Detail</h2>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fs-4 fw-bold mb-0">Jumlah Halaman</p>
                                    <p class="">{{number_format($pustaka_buku->jumlah_halaman,0,',','.')}}</p>
                                    <p class="fs-4 fw-bold mb-0">Tanggal Terbit</p>
                                    <p class="">{{strftime("%d %B %Y", strtotime($pustaka_buku->tahun_terbit))}}</p>
                                    <p class="fs-4 fw-bold mb-0">Subjek</p>
                                    <p class="">{{$pustaka_buku->subjek}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="fs-4 fw-bold mb-0">Penerbit</p>
                                    <p class="">{{$pustaka_buku->penerbit}}</p>
                                    <p class="fs-4 fw-bold mb-0">Tipe Media</p>
                                    <p class="">{{$pustaka_buku->tipe_media}}</p>
                                    <p class="fs-4 fw-bold mb-0">Bahasa</p>
                                    <p class="">{{$pustaka_buku->bahasa}}</p>
                                </div>
                                <div class="col-6"></div>
                            </div>
                            <button type="button" style="color:white" onclick="showPdf('{{$pustaka_buku->file}}')" class="btn btn-primary">Baca</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="show-preview-pdf">

    </div>

</div>
@endsection

@section('javascript')
    <script>
        function showPdf(file){
            var options = {
                    pdfUrl: ``,
                    preloaderText: 'Please wait, just a moment...',
                    btnSearch: {
                        enabled: true,
                        title: "Search",
                        icon: "fas fa-search"

                    },
                    skin: "dark",
                    layout: "2",
                };
            options.pdfUrl = "{{ asset('uploads/pustaka-buku') }}" + '/' + file ;
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', options.pdfUrl, false);
            xhr.send();
            if (xhr.readyState == 4 && xhr.status == 404) {
                $(".show-data-pdf").html(ilustrationNotFound);
            } else {
                let hPdf = `<div class="3dflip">
                                <div id="pdf-content"></div>
                                <span data-name="btnClose" class="btnClose" title="Close" style="position:fixed;top: 55px;right: 0px;z-index: 9999999999;">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" aria-hidden="true" class="flipbook-icon flipbook-menu-btn" style="font-size: 40px; padding: 12px; color: rgb(255, 255, 255); fill: rgb(255, 255, 255); background: rgba(255, 0, 0, 0.73);">
                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                    </svg>
                                </span>
                            </div>`;

                $(".show-preview-pdf").html(hPdf);
                $("#pdf-content").flipBook(options);
            }
        }
        $('.show-preview-pdf').on('click', '.btnClose', function() {
            $('#pdf-content').remove();
            $('.btnClose').remove();
        })
    </script>
@endsection
