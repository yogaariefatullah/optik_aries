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
            <form method="POST" action="{{ route('master.user.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="{{ $user->nama }}"
                                name="nama"id="example-text-input" />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Username</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" placeholder="" name="email" type="text"
                                value="{{ $user->email }}" id="example-text-input" />
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Password</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <input class="form-control" placeholder="" name="password" type="text" value=""
                                id="example-text-input" />
                        </div>
                        <span style="color: red">*) kosongkan jika tidak ingin mengubah</span>
                    </div>
                    &nbsp;
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Role</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class="col-8">
                            <select name="group_id" id="group_id" aria-label="Select a Country" data-control="select2"
                                onchange="ShowCabang()" data-placeholder="Select a Group..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                                @if ($user->group_id == '1')
                                    <option value="0">Pilih Grup</option>
                                    <option value="1" selected="selected">Admin</option>
                                    <option value="2">Kasir</option>
                                @elseif($user->group_id == '2')
                                    <option value="0">Pilih Grup</option>
                                    <option value="1">Admin</option>
                                    <option value="2" selected="selected">Kasir</option>
                                @else
                                    <option value="0">Pilih Grup</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Kasir</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    &nbsp;
                    <div class="form-group row" id="cabang" style="">
                        <label class="col-2 col-form-label">Cabang</label>
                        <label class="col-2 col-form-label">:</label>
                        <div class=" col-8">
                            <select name="cabang_id" aria-label="Select a Country" data-control="select2"
                                data-placeholder="Select a Parent..."
                                class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="0">Pilih Cabang</option>
                                @foreach ($cabang as $key => $value)
                                    @if ($user->cabang_id == $value->id)
                                        <option value="{{ $value->id }}" selected="selected">{{ $value->nama_cabang }}</option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->nama_cabang }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    &nbsp;
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ route('master.user.index') }}" class="btn btn-secondary">Cancel</a>
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
