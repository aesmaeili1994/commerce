@extends('admin.layouts.admin')

@section('title')
    edit product images
@endsection

@section('script')
    <script>

        //show imageFile name
        $('#primary_image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#images').change(function () {
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
                <h5 class="font-weight-bold">ویرایش تصاویر محصول: {{$product->name}}</h5>
            </div>
            @include('admin.sections.errors')

            <div class="row">

                {{--imagePrimary & other images--}}
                <div class="col-md-12">

                    <div class="row justify-content-center">

                        <div class="col-md-12">
                            <hr>
                            <p>تصویر اصلی محصول:</p>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top"
                                     src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                     alt="{{ $product->name }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <p>تصاویر محصول:</p>
                        </div>

                        @foreach($product->images as $image)
                            <div class="col-md-3">
                                <div class="card">
                                    <img class="card-img-top"
                                         src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                         alt="{{ $product->name }}">

                                    <div class="card-body text-center">
                                        <form action="{{ route('admin.products.images.destroy',['product'=>$product->id]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                                            <button class="btn btn-danger btn-sm mb-3" type="submit">حذف</button>
                                        </form>

                                        <form action="{{ route('admin.products.images.set_primary',['product'=>$product->id]) }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                                            <button class="btn btn-primary btn-sm mb-3" type="submit">انتخاب به عنوان تصویر اصلی</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{--product image--}}
                        <div class="col-md-12">
                            <hr>
                            <p>انتخاب تصویر:</p>
                        </div>

                        <form action="{{ route('admin.products.images.add',['product'=>$product->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="primary_image">انتخاب تصویر اصلی:</label>
                                    <div class="custom-file">
                                        <input type="file" id="primary_image" name="primary_image"
                                               class="custom-file-input">
                                        <label class="custom-file-label" for="primary_image">انتخاب فایل</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="primary_image">انتخاب دیگر تصاویر:</label>
                                    <div class="custom-file">
                                        <input type="file" id="images" name="images[]" multiple
                                               class="custom-file-input">
                                        <label class="custom-file-label" for="images">انتخاب فایل ها</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
