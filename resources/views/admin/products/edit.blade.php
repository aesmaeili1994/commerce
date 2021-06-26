@extends('admin.layouts.admin')

@section('title')
    edit product
@endsection

@section('script')
    <script>

        $('#brandSelect').selectpicker({
            'title': 'انتخاب برند'
        });

        $('#tagSelect').selectpicker({
            'title': 'انتخاب برچسب'
        });

        let variations=@json($productVariations);
        variations.forEach(variation=>{
            $(`#variationDateOnSaleFrom-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleFrom-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss'
            });

            $(`#variationDateOnSaleTo-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleTo-${variation.id}`,
                englishNumber: true,
                enableTimePicker: true,
                textFormat: 'yyyy-MM-dd HH:mm:ss'
            });
        });

    </script>
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش محصول: {{$product->name}}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{route('admin.products.update',['product'=>$product->id])}}" method="POST">
                @csrf
                @method('put')

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{$product->name}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select id="brandSelect" name="brand_id" class="form-control" data-live-search="true">
                            @foreach($brands as $brand)
                                <option
                                    value="{{ $brand->id }}" {{$brand->id==$product->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{ $product->getRawOriginal('is_active') == 1 ? 'selected' : '' }}>فعال
                            </option>
                            <option value="0" {{ $product->getRawOriginal('is_active') == 1 ? '' : 'selected' }}>
                                غیرفعال
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagSelect">برچسب</label>
                        <select id="tagSelect" name="tag_ids[]" class="form-control" multiple data-live-search="true">
                            @php
                                $productTagIds=$product->tags()->pluck('id')->toArray();
                            @endphp

                            @foreach($tags as $tag)
                                <option
                                    value="{{ $tag->id }}" {{ in_array($tag->id,$productTagIds) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="3">{{ $product->description }}</textarea>

                    </div>

                    {{--div for delivery--}}
                    <div class="col-md-12">
                        <hr>
                        <p>هزینه ارسال :</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال</label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" type="text"
                               value="{{ $product->delivery_amount }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای محصول اضافی</label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product"
                               type="text" value="{{ $product->delivery_amount_per_product }}">
                    </div>

                    {{--attribute&variations section--}}
                    <div class="col-md-12">
                        <hr>
                        <p>ویژگی ها:</p>
                    </div>

                    @foreach($productAttributes as $productAttribute)
                        <div class="form-group col-md-3">
                            <label for="delivery_amount">{{ $productAttribute->attribute->name }}</label>
                            <input class="form-control" type="text" name="attribute_ids[{{ $productAttribute->id}}]"
                                   value="{{$productAttribute->value}}">
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
                                    <input class="form-control" type="text"
                                           name="variation_ids[{{$variation->id}}][price]"
                                           value="{{$variation->price}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>تعداد</label>
                                    <input class="form-control" type="text"
                                           name="variation_ids[{{$variation->id}}][quantity]"
                                           value="{{$variation->quantity}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>شناسه انبار</label>
                                    <input class="form-control" type="text"
                                           name="variation_ids[{{$variation->id}}][sku]" value="{{$variation->sku}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>قیمت حراجی</label>
                                    <input class="form-control" type="text"
                                           name="variation_ids[{{$variation->id}}][sale_price]"
                                           value="{{$variation->sale_price == null ? '' : $variation->sale_price}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>شروع حراج</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend order-2">
                                            <span class="input-group-text" id="variationDateOnSaleFrom-{{$variation->id}}">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="text" id="variationInputDateOnSaleFrom-{{$variation->id}}"
                                               name="variation_ids[{{ $variation->id }}][date_on_sale_from]"
                                               value="{{$variation->date_on_sale_from == null ? '' : verta($variation->date_on_sale_from) }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>پایان حراج</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend order-2">
                                            <span class="input-group-text" id="variationDateOnSaleTo-{{$variation->id}}">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="text" id="variationInputDateOnSaleTo-{{$variation->id}}"
                                               name="variation_ids[{{ $variation->id }}][date_on_sale_to]"
                                               value="{{$variation->date_on_sale_to == null ? '' : verta($variation->date_on_sale_to)}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
