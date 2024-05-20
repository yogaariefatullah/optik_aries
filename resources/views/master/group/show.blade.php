@extends('layout.main')
@section('content')
<div class="class">
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">List Master Group</span>
            </h3>
            <div class="card-toolbar">
                
            </div>
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

        <div class="card-body py-3">
            
            <div class="table-responsive">
                <div class="row mb-3">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" onkeyup="searchMenu()" placeholder="Search Menu...">
                        </div>
                    </div>
                </div>
                <form action="{{ route('master.group.updatepermission',$id_group) }}" method="post">
                @csrf
                <table class="table align-middle gs-0 gy-4" id="tbl_menu">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-80px rounded-start">NO</th>
                            <th class="min-w-200px">Nama</th>
                            <th class="min-w-200px">Url</th> 
                            <th class="">C</th> 
                            <th class="">R</th> 
                            <th class="">U</th> 
                            <th class="">D</th> 
                            <th class="">V</th> 
                        </tr>
                    </thead>
                    <tbody style="overflow-y:auto;">
                        
                        <?php $no = 1; ?>
                        @foreach($menu as $val)
                            @if($val->parent_id == 0)    
                                <?php $permissions = getPermission($id_group,$val->id);?>
                                <tr>
                                    <td>
                                    {{ $no++ }}
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->name}}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->url}}</span>
                                    </td>
                                    <td>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="hidden"  name="id_menu[]" value="{{$val->id}}">
                                            <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->c == true) checked="checked" @endif @endif  name="create{{$val->id}}" value="t">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->r == true) checked="checked" @endif @endif  name="read{{$val->id}}" value="t">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->u == true) checked="checked" @endif @endif  name="update{{$val->id}}" value="t">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->d == true) checked="checked" @endif @endif name="delete{{$val->id}}" value="t">
                                        </label>
                                    </td>
                                    <td>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->v == true) checked="checked" @endif @endif  name="view{{$val->id}}" value="t">
                                        </label>
                                    </td>
                                    
                                </tr>
                            @endif

                            @foreach($menu as $Child)
                                @if($Child->parent_id == $val->id)    
                                    
                                    <?php $permissions = getPermission($id_group,$Child->id);?>
                                    <tr>
                                        <td>
                                        
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$Child->name}}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$Child->url}}</span>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="hidden"  name="id_menu[]" value="{{$Child->id}}">
                                                <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->c == true) checked="checked" @endif @endif name="create{{$Child->id}}" value="t">
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->r == true) checked="checked" @endif @endif  name="read{{$Child->id}}" value="t">
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->u == true) checked="checked" @endif @endif name="update{{$Child->id}}" value="t">
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->d == true) checked="checked" @endif @endif  name="delete{{$Child->id}}" value="t">
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" @if($permissions) @if($permissions->v  == true) checked="checked" @endif @endif  name="view{{$Child->id}}" value="t">
                                            </label>
                                        </td>
                                        
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <div align="right">
                    <a href="{{ route('master.group.index') }}" class="btn btn-light btn-active-light-primary me-2" type="submit"> Kembali</a>
                    <button type="submit" class="btn  btn-primary"><i class="fa fa-save"></i>
                        Simpan
                    </button>
                </div>
                </form>
                &nbsp;
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script>
        function searchMenu() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("tbl_menu");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection