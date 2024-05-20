@extends('layout.main')
@section('content')
<div class="class">
    <input type="hidden" id="arsipid" value="{{$pustaka->id}}">
    <div class="card mb-5 mb-xl-8 custom-form-input">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Tambah Menu</span>
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
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif
        <form  method="POST" action="{{ route('pustaka.video.update',$pustaka->id) }}" enctype='multipart/form-data'>
            @csrf
            
        @method('PUT')
            <div class="card-body custom-form-input">
                <div class="row">
                    <div class="form-group col-6">
                        <label>Subjek</label>
                        <select name="id_subjek" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih subject..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih subject</option>
                            @foreach($subject as $key => $value)
                                <option value="{{$value->id}}" @if($pustaka->id_subjek == $value->id) selected="selected"@endif>{{$value->subjek}}</option>
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
                        <label>Produksi</label>
                        <input type="number" name="produksi" value="{{$pustaka->produksi}}" class="form-control"/>
                    </div>
                    <div class="form-group col-6">
                        <label>Tahun</label>
                        <div class="input-group" id="kt_td_picker_date_only" data-td-target-input="nearest" data-td-target-toggle="nearest">
                            <input id="kt_td_picker_date_only_input" name="tahun_produksi" value="{{$pustaka->tahun_produksi}}" type="text" class="form-control" data-td-target="#kt_td_picker_date_only"/>
                            <span class="input-group-text" data-td-target="#kt_td_picker_date_only" data-td-toggle="datetimepicker">
                                <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </span>
                        </div>
                    </div>
                    
                </div>
                &nbsp;
                <div class="row">
                   <div class="form-group col-6">
                        <label>Cover</label>
                        <input type="file" accept="image/*" name="cover" value="" class="form-control"/>
                        <input type="hidden" name="cover_old" value="{{$pustaka->cover}}"/>
                        <label>{{$pustaka->cover}}</label>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-12">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="exampleTextarea" rows="3">{{$pustaka->keterangan}}</textarea>
                    </div>
                </div>
                &nbsp;
                &nbsp;
                <div class="row">
                    <div class="form-group col-12">
                        <label>Upload</label>
                        
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Dropzone-->
                                <div class="dropzone" id="kt_dropzonejs_example_1">
                                    <!--begin::Message-->
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                        <!--begin::Info-->
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                </div>
                                <!--end::Dropzone-->
                            </div>
                            
                    </div>
                </div>
                &nbsp;
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4" id="data-table" style="background-color: white;">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-80px text-center">NO</th>
                                <th class="">Video</th>
                                <th class="min-w-150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pustaka_file as $key => $val)
                                <tr>
                                    <td>
                                        <center>
                                            {{ $key + 1 }}
                                        </center>
                                    </td>
                                    <td>
                                    <div class="symbol symbol-500 mr-5 align-self-start align-self-xxl-center">
                                        <label>{{$val->file}}</label>
                                        <i class="symbol-badge bg-success"></i>
                                    </div>
                                    </td>
                                    <td class="text-end">
                                        <center>
                                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"data-bs-toggle="modal" data-bs-target="#deleteModal{{$val->id}}">
                                                <i class="ki-solid ki-trash fs-2">
                                                
                                                </i>
                                            </a>
                                        </center>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $val->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Hapus Arsip</h5>
                                                <button type="button" class="close btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="ki-solid ki-cross fs-1">
                                                    </i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="modal-title" id="deleteModal{{ $val->id }}Label">Hapus Arsip</h5>
                                                Apakah Anda yakin ingin menghapus Arsip ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="button" id="hapus-data" onclick="hapusdata('{{$val->id}}')" class="btn btn-danger">Hapus</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                &nbsp;
            </div>
            <div class="card-footer custom-form-input" >
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('master.menu.index')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</div>
@endsection
@section('javascript')
    <script>
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
        //     url: '{{ route("pustaka.video.upload") }}', // Set the url for your upload script location
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
        
        function hapusdata(id){
            let url = '{{ route("pustaka.video.destroy.file", "code") }}';
            url = url.replace('code', id);
            console.log(url);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                success: function(response) {
                    refreshTabel();
                    $("#deleteModal"+id).modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        $('#kt_dropzonejs_example_1').dropzone({
            url: '{{ route("pustaka.video.upload.edit",$pustaka->id) }}', // Set the url for your upload script location
            paramName: "file", // Nama parameter untuk file yang akan dikirim
            maxFilesize: 5, // Ukuran maksimum file dalam MB
            maxFiles: 5, // Jumlah maksimum file yang diizinkan diunggah
            acceptedFiles: ".mp4,.avi,.mov,.wmv", // Jenis file yang diizinkan
            chunking: true,
            method: "POST",
            maxFilesize: 400000000,
            chunkSize: 1000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    var additionalParamValue = $('#additionalParam').val();
                    console.log(additionalParamValue)
                    formData.append('additionalParam', additionalParamValue);
                });

                this.on("success", function(file, response) {
                    refreshTabel();
                });
            }
        });
        
        function refreshTabel() {
            let id = $('#arsipid').val();
            let url = '{{ route("pustaka.video.edit.refresh", "code") }}';
            url = url.replace('code', id);
            $.ajax({
                url: url,
            method: 'GET',
            success: function(data) {
                $('#data-table tbody').html(data);
            }
            });
        }

    </script>
@endsection
