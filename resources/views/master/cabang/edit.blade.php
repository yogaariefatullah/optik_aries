@extends('layout.main')
@section('content')
    <div class="class">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Edit Menu</span>
                </h3>
            </div>

            <!--begin::Form-->
            <form method="POST" action="{{ route('master.cabang.update', $cabang->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Cabang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="{{ $cabang->nama_cabang }}"
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
        $(document).ready(function() {
            var grup = $('#group_id').val()
            console.log(grup);
            if (grup == 2) {
                $('#cabang').show();
            } else {
                $('#cabang').hide();
            }
        });
        $('#kt_select2_1').select2({
            placeholder: "Select a state",  
        });

        function ShowCabang() {
            var cabang = $('#group_id').val();

            if (cabang == 2) {
                $('#cabang').show();
            } else {
                $('#cabang').hide();
            }
        }
    </script>
@endsection
