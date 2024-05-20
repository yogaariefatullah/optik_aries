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
                        <form action="{{ route('master.menu.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search Menu...">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-80px rounded-start">NO</th>
                            <th class="min-w-200px">Nama</th>
                            <th class="min-w-200px">Keterangan</th> 
                            <th class="min-w-200px rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $key => $val)
                        <tr>
                            <td>
                             {{ ($group->currentPage() - 1) * $group->perPage() + $loop->index + 1 }}
                            </td>
                            <td>
                                <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->name}}</span>
                            </td>
                            <td>
                                <span class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">{{$val->keterangan}}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{route('master.group.show', $val->id)}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <i class="ki-solid ki-eye fs-2">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $group->onEachSide(1)->appends(array_merge(request()->query(), ['page' => $group->currentPage()]))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
