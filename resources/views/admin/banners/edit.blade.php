@extends('admin.layouts.admin')

@section('title')
    edit banner
@endsection

@section('script')
    <script>

        //show file name
        $('#image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ویرایش بنر: {{$banner->image}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')

            <div class="d-flex justify-content-center">
                <div class="col-md-6 text-center">
                    <img class="resize-image-edit" src="{{ env('BANNER_IMAGES_UPLOAD_PATH').$banner->image }}" alt="{{ $banner->image }}">
                </div>
            </div>

            <hr>

            <form action="{{route('admin.banners.update',['banner'=>$banner->id])}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">عنوان</label>
                        <input class="form-control" name="title" type="text" value="{{$banner->title}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">متن</label>
                        <input class="form-control" name="text" type="text" value="{{ $banner->text }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">اولویت</label>
                        <input class="form-control" name="priority" type="text" value="{{ $banner->priority }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{ $banner->getRawOriginal('is_active') ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ $banner->getRawOriginal('is_active') ? '' : 'selected' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">نوع بنر</label>
                        <input class="form-control" name="type" type="text" value="{{ $banner->type }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">متن دکمه</label>
                        <input class="form-control" name="button_text" type="text" value="{{ $banner->button_text }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">لینک دکمه</label>
                        <input class="form-control" name="button_link" type="text" value="{{ $banner->button_link }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">آیکون دکمه</label>
                        <input class="form-control" name="button_icon" type="text" value="{{ $banner->button_icon }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="image">انتخاب بنر</label>
                        <div class="custom-file">
                            <input type="file" id="image" name="image" class="custom-file-input">
                            <label class="custom-file-label" for="image">انتخاب تصویر</label>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
