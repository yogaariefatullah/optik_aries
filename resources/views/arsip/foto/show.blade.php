@extends('layout.main')
@section('content')
<div class="class">
    <div class="card mb-5 mb-xl-8 custom-form-input">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">{{$nama_menu}}</span>
            </h3>
        </div> 
        <hr>
        <div class="content d-flex flex-column flex-column-fluid">
            <!-- <div class="container-fluid">   </div> -->
            <center>
                <h3 class="fs-2hx text-gray-900 mb-5">{{$arsip->judul}}</h3>
                <p >{{$subjek->subjek}} | {{strftime("%d %B %Y", strtotime($arsip->tahun))}}</p>
            </center>
            <div class="col-12">
                <span>
                    {{$arsip->keterangan}}
                </span>
            </div>
            &nbsp;
            &nbsp;
            <div class="row">
                @foreach($arsip_file as $val)
                    <div class="col-4">
                        <div class="card">
                            <img class="" src="{{asset("uploads/arsip-foto/".$val->file)}}" alt="Card image cap">
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
        
            {{-- <div class="card-body custom-form-input">
                <div class="row">
                    <div class="form-group col-6">
                        <label>Subjek</label>
                        <select name="id_subjek" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih subject..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih subject</option>
                            
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label>Judul</label>
                        <input type="text" name="judul" value="{{$arsip->judul}}" class="form-control"/>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-6">
                        <label>Tahun</label>
                        <div class="input-group" id="kt_td_picker_date_only" data-td-target-input="nearest" data-td-target-toggle="nearest">
                            <input id="kt_td_picker_date_only_input" name="tahun" value="{{$arsip->tahun}}" type="text" class="form-control" data-td-target="#kt_td_picker_date_only"/>
                            <span class="input-group-text" data-td-target="#kt_td_picker_date_only" data-td-toggle="datetimepicker">
                                <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label>Cover</label>
                        <input type="file" accept="image/*" name="cover" value="" class="form-control"/>
                        <input type="hidden" name="cover_old" value="{{$arsip->cover}}"/>
                        <label>{{$arsip->cover}}</label>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group col-12">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="exampleTextarea" rows="3">{{$arsip->keterangan}}</textarea>
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
                &nbsp;
            </div>
            <div class="card-footer custom-form-input" >
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('master.menu.index')}}" class="btn btn-secondary">Cancel</a>
            </div>--}}
    </div>

</div>
@endsection
@section('javascript')
    
@endsection
