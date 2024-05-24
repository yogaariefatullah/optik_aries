@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Tambah Cabang</span>
                </h3>
            </div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>Success </strong>{{ Session::get('success') }}
                </div>
            @endif
            @if ($errors->has('subjek'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $errors->first('subjek') }}</strong>
                </div>
            @endif

            <!--begin::Form-->
            <form method="POST" action="{{ route('master.cabang.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Cabang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value=""
                                name="nama_cabang"id="example-text-input" required/>
                        </div>
                    </div>
                    &nbsp;
                   
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ route('master.cabang.index') }}" class="btn btn-secondary">Cancel</a>
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
