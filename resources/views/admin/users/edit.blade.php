@extends('admin.layouts.admin')

@section('title')
    edit users
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ویرایش کاربر: {{$user->name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.users.update',['user'=>$user->id])}}" method="POST">
                @csrf
                @method('put')

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label>نام</label>
                        <input class="form-control" name="name" type="text" value="{{$user->name}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label>تلفن</label>
                        <input class="form-control" name="cellphone" type="text" value="{{$user->cellphone}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="role">نقش کاربر</label>
                        <select class="form-control" name="role" id="role">
                            <option></option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ in_array($role->id , $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
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

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPermission">
                                <div class="card-body">
                                    @foreach($permissions as $permission)
                                        <div class="custom-control custom-checkbox col-md-3 d-inline">
                                            <input type="checkbox" class="custom-control-input" id="customCheck-{{ $permission->id }}"
                                                   name="{{ $permission->name }}" value="{{ $permission->name }}"
                                                {{ in_array($permission->id,$user->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                            <label class="custom-control-label" for="customCheck-{{ $permission->id }}">{{ $permission->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
