@extends('admin.layouts.admin')

@section('title')
    create banner
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
                <h5 class="font-weight-bold">ایجاد بنر</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.banners.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">عنوان</label>
                        <input class="form-control" name="title" type="text" value="{{old('title')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">متن</label>
                        <input class="form-control" name="text" type="text" value="{{old('text')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">اولویت</label>
                        <input class="form-control" name="priority" type="text" value="{{old('priority')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">نوع بنر</label>
                        <input class="form-control" name="type" type="text" value="{{old('type')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">متن دکمه</label>
                        <input class="form-control" name="button_text" type="text" value="{{old('button_text')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">لینک دکمه</label>
                        <input class="form-control" name="button_link" type="text" value="{{old('button_link')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">آیکون دکمه</label>
                        <input class="form-control" name="button_icon" type="text" value="{{old('button_icon')}}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="image">انتخاب بنر</label>
                        <div class="custom-file">
                            <input type="file" id="image" name="image" class="custom-file-input">
                            <label class="custom-file-label" for="image">انتخاب تصویر</label>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
