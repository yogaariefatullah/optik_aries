@extends('layout.main')
@section('content')
<div class="class">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-flush h-xl-100" id="kt_player_widget_2" style="background: rgb(64,165,145); background: linear-gradient(87deg, rgba(64,165,145,1) 35%, rgba(183,121,235,1) 100%);">
                <div class="card-header">
                    
                </div>
                <div class="card-body pt-0">
                    <div class="mx-auto mb-6 bgi-no-repeat bgi-size-contain bgi-position-center rounded-circle w-125px h-125px" style="background-image:url('{{asset("uploads/pustaka-audio/cover/".$pustaka_audio->cover)}}')"></div>
                    <div class="text-center mb-5">
                        <h1 class="text-white fw-bold">{{$pustaka_audio->judul}}</h1>
                    </div>
                </div>
                <div class="card-footer p-0 pb-9">
                    <div class="mt-n10">
                        <div class="mb-5">
                            <div class="d-flex flex-stack px-4 text-white opacity-75">
                                <span class="current-time" data-kt-element="current-time">0:00</span>
                                <span class="duration" data-kt-element="duration">0:00</span>
                            </div>
                            <input type="range" class="form-range" data-kt-element="progress" min="0" max="100" value="0" step="0.01" />
                        </div>
                        <div class="d-flex flex-center">
                            <button class="btn btn-icon mx-1" data-kt-element="play-prev-button">
                                <i class='bi bi-caret-left-fill fs-2 text-white'></i>
                            </button>
                            <button class="btn btn-icon mx-6 play-pause" data-kt-element="play-button">
                                <i class="bi bi-play-fill text-white fs-4x" data-kt-element="play-icon"></i>
                                <i class="bi bi-pause-fill text-white fs-4x d-none" data-kt-element="pause-icon"></i>
                            </button>
                            <button class="btn btn-icon mx-1 next" data-kt-element="play-next-button">
                                <i class='bi bi-caret-right-fill fs-2 text-white'></i>
                            </button>
                        </div>
                        <audio data-kt-element="audio-track-1">
                            <source src="{{asset('uploads/pustaka-audio/'.$pustaka_audio->file)}}" type="audio/mpeg" />
                        </audio>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="text-align:left">
                <div class="card-body flex-column p-8">
                    <div class="card-px pt-0">
                        <p class="fs-4 fw-semibold mb-0">{{$pustaka_audio->pengarang}}</p>
                        <h2 class="fs-2x fw-bold mb-4">{{$pustaka_audio->judul}}</h2>
                        <p class="fs-4 fw-bold">Deskripsi Buku</p>
                        <div class="mb-10">{{$pustaka_audio->keterangan}}</div>
                        <h2 class="fs-2 fw-bold">Informasi Detail</h2>
                        <div class="row">
                            <div class="col-6">
                                <p class="fs-4 fw-bold mb-0">Tanggal Produksi</p>
                                <p class="">{{strftime("%d %B %Y", strtotime($pustaka_audio->tahun_produksi))}}</p>
                                <p class="fs-4 fw-bold mb-0">Subjek</p>
                                <p class="">{{$pustaka_audio->subjek}}</p>
                            </div>
                            <div class="col-6">
                                <p class="fs-4 fw-bold mb-0">Tipe Media</p>
                                <p class="">Audio</p>
                            </div>
                            <div class="col-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var audio = $('[data-kt-element="audio-track-1"]')[0];
            var progress = $('[data-kt-element="progress"]');

            $(audio).on('timeupdate', function() {
                var percent = (audio.currentTime / audio.duration) * 100;
                progress.val(percent);
            });

            progress.on('input', function() {
                var seekTime = (audio.duration / 100) * progress.val();
                audio.currentTime = seekTime;
            });
        });

    </script>
@endsection
