@extends('admin.layouts.admin')

@section('title')
    show product
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">محصول: {{$product->name}}</h5>
            </div>
            <hr>
            <div class="row">

                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" type="text" value="{{ $product->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>نام برند</label>
                    <input class="form-control" type="text" value="{{ $product->brand->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>دسته بندی</label>
                    <input class="form-control" type="text" value="{{ $product->category->name }}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" type="text" value="{{ $product->is_active }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>برچسب ها</label>
                    <div class="form-control div-disabled">
                        @foreach($product->tags as $tag)
                            {{ $tag->name }}{{$loop->last ? '' : '،'}}
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" type="text" value="{{ verta($product->created_at) }}" disabled>
                </div>
                <div class="form-group col-md-12">
                    <label>توضیحات</label>
                    <textarea class="form-control" row="3" disabled>{{ $product->description }}</textarea>
                </div>

                {{--div for delivery--}}
                <div class="col-md-12">
                    <hr>
                    <p>هزینه ارسال :</p>
                </div>

                <div class="form-group col-md-3">
                    <label for="delivery_amount">هزینه ارسال</label>
                    <input class="form-control" type="text" value="{{$product->delivery_amount}}" disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="delivery_amount">هزینه ارسال به ازای محصول اضافی</label>
                    <input class="form-control" type="text" value="{{$product->delivery_amount_per_product}}" disabled>
                </div>

                {{--attribute&variations section--}}
                <div class="col-md-12">
                    <hr>
                    <p>ویژگی ها:</p>
                </div>

                @foreach($productAttributes as $productAttribute)
                    <div class="form-group col-md-3">
                        <label for="delivery_amount">{{ $productAttribute->attribute->name }}</label>
                        <input class="form-control" type="text" value="{{$productAttribute->value}}" disabled>
                    </div>
                @endforeach


                @foreach($productVariations as $variation)
                    <div class="col-md-12">
                        <hr>
                        <div class="d-flex">
                            <p class="mb-0"> قیمت و موجودی برای متغیر({{$variation->value}}):
                            </p>
                            <p class="mb-0 mr-3">
                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{$variation->id}}" aria-expanded="false"
                                        aria-controls="collapseExample">
                                    نمایش
                                </button>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="collapse row mt-2 p-4 border-info" style="border: 1px solid; border-radius: 3px"
                             id="collapse-{{$variation->id}}">
                            <div class="form-group col-md-4">
                                <label>قیمت</label>
                                <input class="form-control" type="text" value="{{$variation->price}}" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label>تعداد</label>
                                <input class="form-control" type="text" value="{{$variation->quantity}}" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label>شناسه انبار</label>
                                <input class="form-control" type="text" value="{{$variation->sku}}" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label>قیمت حراجی</label>
                                <input class="form-control" type="text"
                                       value="{{$variation->sale_price == null ? '--' : $variation->sale_price}}"
                                       disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label>شروع حراج</label>
                                <input class="form-control" type="text"
                                       value="{{$variation->date_on_sale_from == null ? '--' : verta($variation->date_on_sale_from) }}"
                                       disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label>پایان حراج</label>
                                <input class="form-control" type="text"
                                       value="{{$variation->date_on_sale_to == null ? '--' : verta($variation->date_on_sale_to)}}"
                                       disabled>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{--imagePrimary & other images--}}
                <div class="col-md-12">
                    <hr>
                    <p>تصاویر محصول:</p>
                </div>

                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top"
                                     src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                     alt="{{ $product->name }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        @foreach($images as $image)
                            <div class="col-md-3">
                                <div class="card">
                                    <img class="card-img-top"
                                         src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                         alt="{{ $product->name }}">
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>


            </div>

            <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>

    </div>

@endsection
