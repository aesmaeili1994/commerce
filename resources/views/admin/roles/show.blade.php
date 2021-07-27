@extends('admin.layouts.admin')

@section('title')
    show role
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">نقش: {{$role->display_name}}</h5>
            </div>
            <hr>
            <div class="row">

                <div class="form-group col-md-3">
                    <label>نام نمایشی</label>
                    <input class="form-control" type="text" value="{{ $role->display_name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" type="text" value="{{ $role->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" type="text" value="{{ verta($role->created_at) }}" disabled>
                </div>

                <div class="accordion col-md-12" id="accordionPermission">
                    <div class="card">
                        <div class="card-header p-0" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    مجوزها
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionPermission">
                            <div class="card-body">
                                @foreach($role->permissions as $permission)
                                    <div class="custom-control custom-checkbox col-md-3 d-inline">
                                        <span>{{ $permission->display_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>

    </div>

@endsection
