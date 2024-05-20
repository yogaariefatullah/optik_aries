@extends('layout.main_type')
@section('content')
<div class="class">
    <div class=" mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h1 class="card-title align-items-start flex-column">
                E-Book
            </h1>
        </div>
        <div class="card-body py-2">
            <div class="card-px text-center pt-10">
                <h2 class="fs-2x fw-bold mb-0">Koleksi Ebook</h2>
                <p class="text-gray-500 fs-4 fw-semibold">Koleksi perpustakaan kami ditampilkan di sini. Carilah mereka. Baca mereka. Semoga Anda juga menyukainya.</p>
            </div>
            
            <div class="card-px pt-10 d-flex justify-content-end">
                <button type="button" onclick="showMoreFilter()" class="btn btn-light">Filter</button>
            </div>
            <div class="card-px pt-10 d-flex justify-content-end">
                <div class="card" id="more-filter" style="display: none;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Quick Filters</span>
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

            <div class="row g-6 g-xl-9 mb-6 mb-xl-9" id="pustaka-buku">
                @foreach($pustaka_buku as $value)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                            <a onclick="showDetail()" class="text-gray-800 text-hover-primary d-flex flex-column" style="cursor:pointer!important;">
                                <div class="symbol symbol-200px mb-5">
                                    <img src="{{asset('uploads/pustaka-buku/cover/'.$value->cover)}}" class="theme-light-show" alt="" />
                                </div>
                                <div class="fs-5 fw-bold mb-2">{{$value->subjek}}</div>
                            </a>
                            <form id="postForm" action="{{ route("list.ebook.detail") }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{$value->id}}">
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
    <script>
    new tempusDominus.TempusDominus(document.getElementById("datetimepicker"), {
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
                format: "yyyy/MM/dd"
            }
        });
            function showDetail(){
                let url = '{{ route("list.ebook.detail") }}';
                event.preventDefault(); 
        
                
                $('#postForm').submit();
            }

            function showMoreFilter(){
                $('#more-filter').show();
            }

            $('#filter-subjek, #datetimepicker').on('input change', function() {
                searchFilter();
            });
            
            function searchFilter() {
                var subjectId = $('#filter-subjek').val();
                var date = $('#datetimepicker').val();
                
                $.ajax({
                    url: "{{ route('list.ebook.filter') }}",
                    type: "GET",
                    data: {subject_id: subjectId, date: date, _token: '{{ csrf_token() }}'},
                    success: function(response) {
                        updateResults(response);
                    }
                });
            }

            function updateResults(data) {

                $('#pustaka-buku').empty();
                $.each(data.books, function(index, item) {
                    var image = "{{asset('uploads/pustaka-buku/cover')}}/" + item.cover;
                    var html = '<div class="col-md-6 col-lg-4 col-xl-3">' +
                                    '<div class="card h-100">' +
                                        '<div class="card-body d-flex justify-content-center text-center flex-column p-8">' +
                                            '<a onclick="showDetail()" class="text-gray-800 text-hover-primary d-flex flex-column" style="cursor:pointer!important;">' +
                                                '<div class="symbol symbol-200px mb-5">' +
                                                    '<img src="' + image + '" class="theme-light-show" alt="" />' +
                                                '</div>' +
                                                '<div class="fs-5 fw-bold mb-2">' + item.subjek + '</div>' +
                                            '</a>' +
                                            '<form id="postForm" action="{{ route("list.ebook.detail") }}" method="POST" style="display: none;">' +
                                                '@csrf' +
                                                '<input type="hidden" name="id" value="' + item.id + '">' +
                                            '</form>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                    $('#pustaka-buku').append(html);
                });

            }
    </script>
@endsection
