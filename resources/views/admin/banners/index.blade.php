@extends('admin.layouts.admin')

@section('title')
    index banner
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست بنر ها ({{$banners->total()}})</h5>
                <div>
                    <a href="{{route('admin.banners.create')}}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        ایجاد بنر
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>اولویت</th>
                        <th>وضعیت</th>
                        <th>نوع</th>
                        <th>متن دکمه</th>
                        <th>لینک دکمه</th>
                        <th>آیکون دکمه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($banners as $key=>$banner)
                        <tr class="text-nowrap" style="line-height: 100px">
                            <th>{{ $banners->firstItem() + $key }}</th>
                            {{--<th>{{ substr($banner->image,25) }}</th>--}}
                            <th>
                                <img class="resize-image" src="{{ env('BANNER_IMAGES_UPLOAD_PATH').$banner->image }}" alt="{{ $banner->image }}">
                            </th>
                            <th>{{ $banner->title }}</th>
                            <th>{{ $banner->text }}</th>
                            <th>{{ $banner->priority }}</th>
                            <th class="{{ $banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">{{ $banner->is_active }}</th>
                            <th>{{ $banner->type }}</th>
                            <th>{{ $banner->button_text }}</th>
                            <th>{{ $banner->button_link }}</th>
                            <th>{{ $banner->button_icon }}</th>
                            <th>
                                <div class="d-flex align-content-center">

                                    <div>
                                        <form action="{{ route('admin.banners.destroy',['banner'=>$banner->id]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit">حذف</button>
                                        </form>
                                    </div>

                                    <div>
                                        <a href="{{ route('admin.banners.edit',['banner'=>$banner->id]) }}" class="btn btn-sm btn-info mr-3">ویرایش</a>
                                    </div>

                                </div>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{$banners->render()}}
            </div>

        </div>
    </div>

@endsection
