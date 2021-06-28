@extends('admin.layouts.admin')

@section('title')
    index categories
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست دسته بندی ها ({{$categories->total()}})</h5>
                <div>
                    <a href="{{route('admin.categories.create')}}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        ایجاد دسته بندی
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>نام انگلیسی</th>
                        <th>والد</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $key=>$category)
                        <tr>
                            <th>{{ $categories->firstItem() + $key }}</th>
                            <th>{{ $category->name }}</th>
                            <th>{{ $category->slug }}</th>
                            <th>{{$category->parent_id == 0 ? '___' : $category->parent->name}}</th>
                            <th>
                                <span class="{{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                    {{ $category->is_active }}
                                </span>
                            </th>

                            <th>
                                <div class="d-inline-block" style="width: max-content">
                                    <a href="{{ route('admin.categories.show',['category'=>$category->id]) }}" class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.categories.edit',['category'=>$category->id]) }}" class="btn btn-sm btn-outline-info">ویرایش</a>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{$categories->render()}}
            </div>

        </div>
    </div>

@endsection
