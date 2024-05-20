@extends('layout.main')
@section('content')
<div class="class">
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
        <form  method="POST" action="{{ route('arsip.foto.store') }}" enctype='multipart/form-data'>
            @csrf
            <div class="card-body custom-form-input">
                <div class="row">
                    <div class="form-group col-6">
                        <label>Subjek</label>
                        <select name="id_subjek" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih subject..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih subject</option>
                            @foreach($subject as $key => $value)
                                <option value="{{$value->id}}">{{$value->subjek}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Tahun</label>
                        <div class="input-group" id="kt_td_picker_date_only" data-td-target-input="nearest" data-td-target-toggle="nearest">
                            <input id="kt_td_picker_date_only_input" name="tahun" type="text" class="form-control" data-td-target="#kt_td_picker_date_only"/>
                            <span class="input-group-text" data-td-target="#kt_td_picker_date_only" data-td-toggle="datetimepicker">
                                <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label>Cover</label>
                        <input type="file" accept="image/*" name="cover" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-12">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="exampleTextarea" rows="3"></textarea>
                    </div>
                </div>
                &nbsp;
                <input type="hidden" name="code" id="additionalParam" value="{{$code}}">
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
        //     url: '{{ route("arsip.foto.upload") }}', // Set the url for your upload script location
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

        $('#kt_dropzonejs_example_1').dropzone({
                url: '{{ route("arsip.foto.upload") }}', // Set the url for your upload script location
                paramName: "file", // Nama parameter untuk file yang akan dikirim
                maxFilesize: 5, // Ukuran maksimum file dalam MB
                maxFiles: 5, // Jumlah maksimum file yang diizinkan diunggah
                acceptedFiles: ".jpeg,.jpg,.png,.gif", // Jenis file yang diizinkan
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
                        console.log(response); // Tanggapan dari server
                    });
                }
            });

    </script>
@endsection
