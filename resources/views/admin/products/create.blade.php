@extends('admin.layouts.admin')

@section('title')
    create products
@endsection

@section('script')
    <script>

        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });

        $('#tagSelect').selectpicker({
            'title': 'انتخاب برچسب'
        });

        //show file name
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

        $('#categorySelect').selectpicker({
            'title': 'انتخاب دسته بندی'
        });

        $('#attributesContainer').hide();

        $('#categorySelect').on('changed.bs.select', function () {
            let categoryId = $(this).val();

            $.get(`{{ url('/admin-panel/management/category-attributes/${categoryId}') }}`, function (response, status) {
                if (status == 'success') {

                    $('#attributesContainer').fadeIn();

                    //empty attribute container
                    $("#attributes").find('div').remove();

                    //create  and append attributes input
                    response.attributes.forEach(attribute => {

                        let attributeFormGroup = $('<div/>', {
                            class: 'form-group col-md-3'
                        });

                        attributeFormGroup.append($('<label/>', {
                            for: attribute.name,
                            text: attribute.name
                        }));

                        attributeFormGroup.append($("<input/>", {
                            type: 'text',
                            class: 'form-control',
                            id: attribute.name,
                            name: `attribute_ids[${attribute.id}]`
                        }));

                        $("#attributes").append(attributeFormGroup);
                    });

                    //create variatinName for span
                    $('#variationName').text(response.variation.name);

                } else {
                    alert('مشکل در دریافت لیست ویژگی ها');
                }
            }).fail(function () {
                alert('مشکل در دریافت لیست ویژگی ها');
            })
        });

        $("#czContainer").czMore();

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="mb-4 text-center text-md-right">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{old('name')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control" data-live-search="true">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" selected>فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagSelect">برچسب</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control" multiple data-live-search="true">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"
                                  name="description">{{old('description')}}</textarea>
                    </div>

                    {{--product image--}}
                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول:</p>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="primary_image">انتخاب تصویر اصلی</label>
                        <div class="custom-file">
                            <input type="file" id="primary_image" name="primary_image" class="custom-file-input">
                            <label class="custom-file-label" for="primary_image">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="primary_image">انتخاب تصاویر</label>
                        <div class="custom-file">
                            <input type="file" id="images" name="images[]" multiple class="custom-file-input">
                            <label class="custom-file-label" for="images">انتخاب فایل ها</label>
                        </div>
                    </div>

                    {{--category & attribute section--}}
                    <div class="col-md-12">
                        <hr>
                        <p>دسته بندی و ویژگی ها:</p>
                    </div>

                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="form-group col-md-3">
                                <label for="categorySelect">دسته بندی</label>
                                <select id="categorySelect" name="category_id" class="form-control"
                                        data-live-search="true">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                            - {{ $category->parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{--attributes&variation section--}}
                    <div id="attributesContainer" class="col-md-12">
                        {{--div for attributes--}}
                        <div id="attributes" class="row"></div>

                        {{--div for variation--}}
                        <div class="col-md-12">
                            <hr>
                            <p>افزودن قیمت و موجودی برای متغیر <span class="font-weight-bold" id="variationName"></span> : </p>
                        </div>

                        {{--czMore library jQuery--}}
                        <div id="czContainer">
                            <div id="first">
                                <div class="recordset">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="value">نام</label>
                                            <input class="form-control" id="value" name="variation_values[value][]" type="text">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="price">قیمت</label>
                                            <input class="form-control" id="price" name="variation_values[price][]" type="text">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="quantity">تعداد</label>
                                            <input class="form-control" id="quantity" name="variation_values[quantity][]" type="text">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sku">شناسه انبار</label>
                                            <input class="form-control" id="sku" name="variation_values[sku][]" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{--div for delivery--}}
                    <div class="col-md-12">
                        <hr>
                        <p>هزینه ارسال :</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال</label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" type="text" value="{{old('delivery_amount')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product" type="text" value="{{old('delivery_amount_per_product')}}">
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
