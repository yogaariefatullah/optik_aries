@extends('layout.main')
@section('content')
<div class="class">
    <input type="hidden" id="pustakaid" value="{{$pustaka->id}}">
    <div class="card mb-5 mb-xl-8 custom-form-input">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Edit pdf</span>
            </h3>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>Success </strong>{{ Session::get('success') }}
            </div>
        @endif
        @if($errors->has('subjek'))
            <div class="alert alert-danger" role="alert">
                <strong>{{ $errors->first('subjek') }}</strong>
            </div>
        @endif

        {{-- <div class="card-body py-3">
                <form method="POST" action="{{ route('master.subject.store') }}">
                    @csrf
                    <div class="form-group row">
                        <label  class="col-2 col-form-label">Text</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"/>
                        </div>
                    </div>
                    &nbsp;
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3 mt-2">
                            <button type="submit" class="btn btn-sm btn-success"> Simpan
                            </button>
                        </div>
                    </div>
                </form> 
        </div> --}}
            <!--begin::Form-->
        <form  method="POST" action="{{ route('pustaka.buku.update',$pustaka->id) }}" enctype='multipart/form-data'>
            @csrf
            @method('put')
            <div class="card-body custom-form-input">
                <div class="row">
                    <div class="form-group col-6">
                        <label>Subjek</label>
                        <select name="id_subjek" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih subject..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih subject</option>
                            @foreach($subject as $key => $value)
                                <option value="{{$value->id}}" @if($value->id == $pustaka->id_subjek) selected="selected"@endif>{{$value->subjek}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label>Judul</label>
                        <input type="text" name="judul" value="{{$pustaka->judul}}" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Pengarang</label>
                        <input type="text" name="pengarang" value="{{$pustaka->pengarang}}" class="form-control"/>
                    </div>
                    <div class="form-group col-6">
                        <label>Tahun Terbit</label>
                        <div class="input-group" id="kt_td_picker_date_only" data-td-target-input="nearest" data-td-target-toggle="nearest">
                            <input id="kt_td_picker_date_only_input" name="tahun_terbit" value="{{$pustaka->tahun_terbit}}" type="text" class="form-control" data-td-target="#kt_td_picker_date_only"/>
                            <span class="input-group-text" data-td-target="#kt_td_picker_date_only" data-td-toggle="datetimepicker">
                                <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </span>
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Penerbit</label>
                        <input type="text" name="penerbit" value="{{$pustaka->penerbit}}" class="form-control"/>
                    </div>
                    <div class="form-group col-6">
                        <label>Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" value="{{$pustaka->jumlah_halaman}}" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Tipe Media</label>
                        <input type="text" name="tipe_media" value="{{$pustaka->tipe_media}}" class="form-control"/>
                    </div>
                    <div class="form-group col-6">
                        <label>Bahasa</label>
                        <input type="text" name="bahasa" value="{{$pustaka->bahasa}}" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Cover</label>
                        <input type="file" accept="image/*" name="cover" class="form-control"/>
                        <input type="hidden" name="cover_old" value="{{$pustaka->cover}}"/>
                        <label>{{$pustaka->cover}}</label>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-12">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="exampleTextarea" rows="3">{{$pustaka->deskripsi}}</textarea>
                    </div>
                </div>
                &nbsp;
                <input type="hidden" name="code" id="hidden_code" value="">
                &nbsp;
                
                <div class="loader2" style="display:none;"></div>
                <div class="row">
                    <div class="form-group col-6">
                        <label>File</label>
                        <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf" onChange='pdfValidation(event)'>
                        <label>{{$pustaka_file->file}}</label>
                        <div class="col-md-1" id="btn-upload" style="display: none;">
                                <div class="btn btn-warning btn-block btn-add" title="Upload pdf">
                                    <i class="fa fa-upload"></i>
                                </div>
                        </div>
                    </div>
                </div>
                &nbsp;
            </div>
            <div class="card-footer custom-form-input" id="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('master.menu.index')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</div>
@endsection
@section('javascript')
    <script>
        function pdfValidation(event) {
            if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
                return;
            }

            // Array tipe file pdf yang diperbolehkan
            const allowedExtensions = ["pdf"];

            const file = event.target.files[0];
            const name = file.name;
            const size = file.size;

            // Mendapatkan ekstensi file
            const lastDot = name.lastIndexOf('.');
            const ext = name.substring(lastDot + 1);

            // Memeriksa ekstensi file
            const clonedFileInput = $('#pdf').clone(); // Mengkloning input pertama
            clonedFileInput.prop('id', 'hidden_file').removeAttr('onchange').insertAfter('#pdf'); // Menambahkan input kedua setelah input pertama
            $('#hidden_file').attr('name', 'pdf[]').attr('disabled', false); 

            // Mengatur nilai input kedua dengan file yang sama dengan input pertama
            const fileInput2 = document.getElementById('hidden_file');
            fileInput2.files = event.target.files;
            $('#pdf').hide();
            $('#btn-upload').show();
            $('#card-footer').hide();
            if (!allowedExtensions.includes(ext)) {
                event.target.value = "";
                swal.fire("Error!", "Hanya file dengan tipe pdf yang diperbolehkan :)", "error");
                return;
            }

            // Memeriksa ukuran file
        }
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
        $('#kt_select2_1').select2({
			placeholder: "Select a state",
        });

        // var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
        //     url: '{{ route("pustaka.buku.upload") }}', // Set the url for your upload script location
        //     paramName: "file", // The name that will be used to transfer the file
        //     maxFiles: 10,
        //     maxFilesize: 10, // MB
        //     addRemoveLinks: true,
        //     headers: {
        //                 'X-CSRF-TOKEN': '{{csrf_token()}}'
        //             },
        //     accept: function(file, done) {
        //         if (file.name == "wow.jpg") {
        //             done("Naha, you don't.");
        //         } else {
        //             done();
        //         }
        //     }
        // });
            $('#btn-upload').click(function() {
                console.log("asdasdsa");
                startUpload(); // Panggil fungsi untuk memulai upload saat tombol simpan diklik
            });
            let id =  $('#pustakaid').val();
            let url = '{{ route("pustaka.buku.upload.edit", "ids") }}';
            url = url.replace('ids', id);
            let resumable = new Resumable({
                target: url,
                query: {_token: '{{ csrf_token() }}'},
                fileType: ['pdf'],
                chunkSize: 2 * 1024 * 1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
                headers: {
                    'Accept': 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });
                let browseFile = $('#pdf');
                resumable.assignBrowse(browseFile[0]);  
            // Fungsi untuk memulai upload saat tombol simpan diklik
            function startUpload() {
                
                
                showProgress();
                resumable.upload(); // Memulai upload
            }



            resumable.on('fileProgress', function (file) { // trigger when file progress update
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
                response = JSON.parse(response)
                console.log(response);
                if (response.code == 1) {
                    $('#btn-upload').hide();
                    $('#card-footer').show();
                    $('#hidden_code').val(response.uniq);
                }
            });

            resumable.on('fileError', function (file, response) { // trigger when there is any error
                alert('file uploading error.')
            });

            let progress = $('.loader2');

            function showProgress() {
                
                progress.show();
            }

            function updateProgress(value) {

                if (value === 100) {
                    progress.hide();
                }
            }

            function hideProgress() {
                progress.hide();
            }
    </script>
@endsection
