@extends('layout.main_type')
@section('content')
<div class="class">
    <div class="tab-content">
        <div id="kt_project_users_card_pane" class="">
            <div class="row g-6 g-xl-9">
                <div class="col-md-6 col-xxl-4">
                    <a href="{{route('list.ebook.index')}}">
                        <div class="card">
                            <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <img src="{{asset('assets/media/logos/E-book.png')}}" alt="image" />
                                </div>
                                <a class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">E-book</a>
                                
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xxl-4">
                    <a href="{{route('list.audio.index')}}">
                        <div class="card">
                            <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <img src="{{asset('assets/media/logos/AudioBook.png')}}" alt="image" />
                                </div>
                                <a href="{{route('list.audio.index')}}" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Audio Book Player</a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xxl-4">
                    <a href="{{route('list.video.index')}}">
                        <div class="card">
                            <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <img src="{{asset('assets/media/logos/video-player.png')}}" alt="image" />
                                </div>
                                <a href="{{route('list.video.index')}}" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">Video Player</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection