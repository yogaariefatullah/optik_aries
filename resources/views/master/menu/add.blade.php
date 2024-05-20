@extends('layout.main')
@section('content')
<div class="class">
    <div class="card mb-5 mb-xl-8">
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
        <form  method="POST" action="{{ route('master.menu.store') }}">
        @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label  class="col-1 col-form-label">Nama Menu</label>
                    <label  class="col-1 col-form-label">:</label>
                    <div class="col-8">
                        <input class="form-control" type="text" value="" name="name"id="example-text-input"/>
                    </div>
                </div>
                &nbsp;
                <div class="form-group row" id="parent_modal">
                    <label  class="col-1 col-form-label">Parent Menu</label>
                    <label  class="col-1 col-form-label">:</label>
                    <div class=" col-8">
                        <select name="parent_id" aria-label="Select a Country" data-control="select2" data-placeholder="Select a Parent..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="0">Pilih Parent</option>
                            @foreach($parent as $key => $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                &nbsp;
                <div class="form-group row">
                    <label  class="col-1 col-form-label">Url</label>
                    <label  class="col-1 col-form-label">:</label>
                    <div class="col-8">
                        <input class="form-control" placeholder="Default #" name="url" type="text" value="" id="example-text-input"/>
                    </div>
                </div>
                &nbsp;
                <div class="form-group row">
                    <label  class="col-1 col-form-label">Urutan</label>
                    <label  class="col-1 col-form-label">:</label>
                    <div class="col-8">
                        <input class="form-control" type="number" value="" name="urutan" id="example-text-input"/>
                    </div>
                </div>
                &nbsp;
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('master.menu.index')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</div>
@endsection
@section('javascript')
    <script>
        $('#kt_select2_1').select2({
			placeholder: "Select a state",
        });
    </script>
@endsection
