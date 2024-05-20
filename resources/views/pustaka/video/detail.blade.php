@extends('layout.main')
@section('content')
<div class="class">
    <input type="hidden" id="id_pustaka_video" value="{{$pustaka_video->id}}">
    <div class="page-wrapper">
        <div class="playlist-wrapper">
            <div class="playlist-mother-video">
                <video id="example_video_1" class="video-js vjs-theme-city c-banner"
                    controls="false"
                    preload="auto"
                    autoplay
                    muted
                    playsinline
                    preload="auto" width="800" height="450">
                <source src="{{asset('uploads/pustaka-video/'.$pustaka_video->file)}}">
                </video>
            </div>
            <div class="playlist-products"></div>
        </div>
        <div class="playlist-child-videos" id="plylst_upcming"></div>
    </div>
</div>
@endsection

@section('javascript')
    <script>
     // Definisikan variabel playlist sebagai variabel global di luar fungsi
var playlist = [];
var player = videojs("example_video_1");
var upcoming_list = $("#plylst_upcming");
var last_video_index = 0;
$(document).ready(function() {
    $(".c-banner").removeAttr("muted");
    var id_pustaka = $('#id_pustaka_video').val();
    $.ajax({
        url: "{{ route('list.video.getfile') }}",
        type: "GET",
        data: {id: id_pustaka, _token: '{{ csrf_token() }}'},
        success: function(response) {
            initplaylist(response);
            player.dimension("width", 1280);
            player.dimension("height", 720);
            // Add autoplay if needed
            // player.autoplay(true);
        }
    });
});

function initplaylist(data) {
    // Kosongkan playlist sebelum menginisialisasi ulang
    playlist = [];
    
    // Menggunakan loop for untuk memproses setiap data
    for (let i = 0; i < data.length; i++) {
        let index = data[i];
        let url = "{{asset('uploads/pustaka-video')}}/" + index.file;
        let image = "{{asset('uploads/pustaka-video/cover')}}/" + index.cover;
        let urutan = (index.urutan === 1) ? true : false;
        // Buat elemen video untuk mengambil durasi
        let videoElement = document.createElement('video');
        videoElement.src = url;
        
        // Closure untuk menyimpan nilai i
        (function(i, url, image, index, urutan) {
            videoElement.addEventListener('loadedmetadata', function() {
                // Dapatkan durasi video dalam menit
                let durationInMinutes = Math.floor(videoElement.duration / 60);
                let remainingSeconds = Math.round(videoElement.duration % 60);

                let duration_video = durationInMinutes +':'+((remainingSeconds < 10) ? '0' + remainingSeconds : remainingSeconds)
                // Buat objek dengan length yang diisi dengan durasi video dalam menit
                let obj = {
                    url: url,
                    thumbnail: image,
                    title: index.judul,
                    length: duration_video, // Isi length dengan durasi video dalam menit
                    muted: false,
                    playing: urutan // Initialize playing status
                } 
                playlist[i] = obj; // Simpan objek dalam array playlist pada indeks yang sesuai
                // Populate playlist once all videos are processed
                if (playlist.length === data.length) {
                    populate_playlist();
                }
            });
        })(i, url, image, index, urutan);
    }
}


var last_video_index = 0;

function build_list_item(s) {
    // var isLive = s.isLive.toString();
    var length = s.length;
    var e = $('<div class="playlist-item-wrapper" data-playing="' + s.playing + '" data-live="">' +
                '<div class="playlist-thumb">' +
                    '<img src="' + s.thumbnail + '"/>' +
                    '<div class="playlist-meta-length"><span>' + length + '</span></div>' +
                '</div>' +
                '<div class="playlist-meta">' +
                    '<div class="playlist-meta-title">' + s.title + '</div>' +
                '</div>' +
            '</div>');
    e.click(i => {
        player.src(s.url);
        playlist[last_video_index].playing = false;
        last_video_index = playlist.indexOf(s);
        playlist[last_video_index].playing = true;
        populate_playlist();
    });
    return e;
}

function populate_list(data, elem) {
    elem.html("");
    for (var item of data) {
        elem.append(build_list_item(item));
    }
}

function populate_playlist() {
    populate_list(playlist, $("#plylst_upcming"));
}

    </script>
@endsection
