<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LIVRA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/media/logos/Livra Logo.png') }}" rel="icon">
    <link href="{{ asset('assets/landingpage/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">    
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>


    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/landingpage/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landingpage/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/landingpage/css/style.css')}}" rel="stylesheet">
    <style>
        .gradient{
            font-size: xx-large;
            background: -webkit-linear-gradient(#2F5D62, #60BEC8);
            font-weight: bold;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            align-content: space-around;
        }
        .slider {
  display: flex;
  overflow-x: auto;
  width: 100%;
}
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div>
                <h1 class="gradient">LIVRA</h1>
            </div>
            <div>
                <a class="btn btn btn-light" style=" background: -webkit-linear-gradient(#2F5D62, #60BEC8); color:white;" href="{{route('login')}}">Login</a>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="container" data-aos="fade-in">
            <div class="col-6">
                <h1>Untuk Semua Yang Dibutuhkan Pembaca</h1>
                <p>Era baru membaca digital yang menggabungkan kehebatan E-book Reader, Audio Book Player dan Video Player dalam satu Platform.</p>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container">

                <div class="row">
                    <div data-aos="fade-up">
                        <div class="">
                            <input class="form-control" type="text" placeholder="Search.." onclick="showMoreFilter()" id="search-ebook">
                        </div>
                        &nbsp;
                        <div class="card" id="advanced-filter" style="display: none;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Quick Filters</span>
                                    <span>Clear All</span>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                            <select class=" form-control js-example-basic-single" style="width: 100% !important;"  id="filter-subjek"
                                                placeholder="Pilih Subjek" required>
                                                @if (!$subject->count())
                                                    <p>There's nothing data.</p>
                                                @else
                                                    <option value="" selected>Pilih Subjek</option>
                                                    @foreach ($subject as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->subjek }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="datetimepicker" placeholder="pilih tahun terbit" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ======= About Section ======= -->
        
        <section id="" class="section-bg">
            <div class="container">
                <center>
                    <h2>Koleksi E-Book</h2>
                    <span>Koleksi perpustakaan kami ditampilkan di sini. Carilah mereka. Semoga Anda juga menyukainya.</span>
                </center>
                &nbsp;

                <div class="row pustaka-buku">
                    <div class="slider">
                    @foreach($pustaka_buku as $key => $value)
                        <div class="card" style="margin-right: 1rem!important;" data-aos="fade-up">
                        <div class="card-header" style="border:none !important;background:transparent !important;">
                            <img src="{{asset('uploads/pustaka-buku/cover/'.$value->cover)}}" alt="" srcset="">
                        </div>

                        <div class="card-body" style="border:none !important;background:transparent !important;">
                            <center>
                            <p>
                                {{$value->subjek}}
                            </p>
                            </center>
                        </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

        </section>
        <section id="" class="section-bg">
            <div class="container">
                <center>
                    <h2>Koleksi Audio Book Player</h2>
                    <span>Koleksi perpustakaan kami ditampilkan di sini. Carilah mereka. Semoga Anda juga menyukainya.</span>
                </center>
                &nbsp;
                
                <div class="row pustaka-audio">
                    <div class="slider">
                    @foreach($pustaka_audio as $key => $value)
                        <div class="card" style="margin-right: 1rem!important;" data-aos="fade-up">
                            <div class="card-header" style="border:none !important;background:transparent !important;">
                                <img src="{{asset('uploads/pustaka-audio/cover/'.$value->cover)}}" alt="" srcset="">
                            </div>
                            
                            <div class="card-body" style="border:none !important;background:transparent !important;">
                                <center>
                                <p> 
                                    {{-- <?php $filename = substr($value->file, strpos($value->file, '-') + 1)?>
                                    {{substr($filename, 0, strrpos($filename, '.'));}} --}}
                                    {{$value->judul}}
                                </p>   
                                </center>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

            </div>
        </section>
        <section id="" class="section-bg">
            <div class="container">
                <center>
                    <h2>Koleksi Video Player</h2>
                    <span>Koleksi perpustakaan kami ditampilkan di sini. Carilah mereka. Semoga Anda juga menyukainya.</span>
                </center>
                &nbsp;
                
                <div class="row pustaka-video">
                    <div class="slider">
                    @foreach($pustaka_video as $key => $value)
                        <div class="card" style="margin-right: 1rem!important;"  data-aos="fade-up">
                            <div class="card-header" style="border:none !important;background:transparent !important;">
                                <img src="{{asset('uploads/pustaka-video/cover/'.$value->cover)}}" alt="" srcset="">
                            </div>
                            
                            <div class="card-body" style="border:none !important;background:transparent !important;">
                                <center>
                                    <p>
                                        {{$value->subjek}}
                                    </p>    
                                </center>
                            </div>
                            <div class="card-footer d-flex justify-content-between" style="border:none !important;background:transparent !important;">
                                    <b>
                                        {{$value->tahun_produksi}}
                                    </b>    
                                    <b>
                                        {{$value->subjek}}
                                    </b>    
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row d-flex justify-content-between">
                        <div class="col-4 footer-contact">
                            <h2>Tentang Kami</h2>
                            <p>
                            Era baru membaca digital yang menggabungkan kehebatan E-book Reader, Audio Book Player dan Video Player dalam satu Platform.
                            </p>
                        </div>
                        <div class="col-6 footer-contact">
                            
                        </div>
                        <div class="col-2 footer-newsletter">
                            <img src="{{asset('assets/media/logos/logo pusdikif.png')}}" alt="">
                        </div>

                </div>
            </div>
        </div>

        <div class="container d-flex justify-content-center py-2">
                <span style="color:black;">© 2024 | Politeknik Angkatan Darat</span>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('assets/landingpage/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('assets/landingpage/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/landingpage/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets/landingpage/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('assets/landingpage/js/main.js')}}"></script>
    <script>
        function showMoreFilter() {
            $('#advanced-filter').show();
        }

        flatpickr("#datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d",
            time_24hr: true
        });
        $('.js-example-basic-single').select2({
            
        });

        $(document).ready(function() {

                $('.slider').slick({
                    slidesToShow: 5, /* Jumlah kartu yang ditampilkan */
                    slidesToScroll: 1, /* Jumlah kartu yang bergeser saat navigasi */
                    autoplay: true, /* Putar otomatis */
                    autoplaySpeed: 2000, /* Kecepatan putar otomatis (dalam milidetik) */
                });

            $('#search-ebook, #filter-subjek, #datetimepicker').on('input change', function() {
                searchFilter();
            });
            
            function searchFilter() {
                var search = $('#search-ebook').val();
                var subjectId = $('#filter-subjek').val();
                var date = $('#datetimepicker').val();
                
                $.ajax({
                    url: "{{ route('search-filter') }}",
                    type: "GET",
                    data: {search: search, subject_id: subjectId, date: date, _token: '{{ csrf_token() }}'},
                    success: function(response) {
                        updateResults(response);
                    }
                });
            }

            function updateResults(data) {

                $('.pustaka-buku').empty().css({
                    'display':' grid',
                    'grid-template-columns':' repeat(5, 2.4fr)',
                    'gap':' 1%'
                });
                $.each(data.books, function(index, item) {
                    var image = "{{asset('uploads/pustaka-buku/cover')}}/" + item.cover;
                    var html = '<div class="card" data-aos="fade-up">' +
                                    '<div class="card-header" style="border:none !important;background:transparent !important;">' +
                                        '<img src="'+ image +'" alt="" srcset="">' +
                                    '</div>' +
                                    '<div class="card-body" style="border:none !important;background:transparent !important;">' +
                                        '<center>' +
                                            '<p>' + item.subjek + '</p>' +
                                        '</center>' +
                                    '</div>' +
                                '</div>';
                    $('.pustaka-buku').append(html);
                });

                $('.pustaka-audio').empty().css({
                    'display':' grid',
                    'grid-template-columns':' repeat(5, 2.4fr)',
                    'gap':' 1%'
                });
                $.each(data.audios, function(index, item) {
                    var image = "{{asset('uploads/pustaka-audio/cover')}}/" + item.cover;
                    var html = '<div class="card" data-aos="fade-up">' +
                                    '<div class="card-header" style="border:none !important;background:transparent !important;">' +
                                        '<img src="'+ image +'" alt="" srcset="">' +
                                    '</div>' +
                                    '<div class="card-body" style="border:none !important;background:transparent !important;">' +
                                        '<center>' +
                                            '<p>' + item.judul + '</p>' +
                                        '</center>' +
                                    '</div>' +
                                '</div>';
                    $('.pustaka-audio').append(html);
                });

                $('.pustaka-video').empty().css({
                    'display':' grid',
                    'grid-template-columns':' repeat(5, 2.4fr)',
                    'gap':' 1%'
                });
                $.each(data.videos, function(index, item) {
                    var image = "{{asset('uploads/pustaka-video/cover')}}/" + item.cover;
                    var html = '<div class="card" data-aos="fade-up">' +
                                    '<div class="card-header" style="border:none !important;background:transparent !important;">' +
                                        '<img src="'+ image + '" alt="" srcset="">' +
                                    '</div>' +
                                    '<div class="card-body" style="border:none !important;background:transparent !important;">' +
                                        '<center>' +
                                            '<p>' + item.judul + '</p>' +
                                        '</center>' +
                                    '</div>' +
                                    '<div class="card-footer d-flex justify-content-between" style="border:none !important;background:transparent !important;">' +
                                        '<b>'+ item.tahun_produksi +
                                        '</b>'+  
                                        '<b>'+ item.subjek+
                                        '</b>'+  
                                    '</div>' +
                                '</div>';
                    $('.pustaka-video').append(html);
                });
            }
        });


        // function filter
    </script>

</body>

</html>
