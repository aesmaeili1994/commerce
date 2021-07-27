@extends('admin.layouts.admin')

@section('title')
    edit role
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ویرایش نقش: {{$role->display_name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.roles.update',['role'=>$role->id])}}" method="POST">
                @csrf
                @method('put')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name"> نام نمایشی</label>
                        <input class="form-control" id="display_name" name="display_name" type="text" value="{{ $role->display_name }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ $role->name }}">
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
                                    @foreach($permissions as $permission)
                                        <div class="custom-control custom-checkbox col-md-3 d-inline">
                                            <input type="checkbox" class="custom-control-input" id="customCheck-{{ $permission->id }}"
                                                   name="{{ $permission->name }}" value="{{ $permission->name }}"
                                                  {{ in_array($permission->id,$role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                            <label class="custom-control-label" for="customCheck-{{ $permission->id }}">{{ $permission->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
