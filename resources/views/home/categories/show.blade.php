@extends('home.layouts.home')

@section('title')
    صفحه فروشگاه
@endsection

@section('script')
    <script>

        function filter() {

            //attributes
            let attributes =@json($attributes);
            attributes.map(attribute => {

                let valueAttribute = $(`.attribute-${attribute.id}:checked`).map(function () {
                    return this.value;
                }).get().join('-');

                if (valueAttribute == "") {
                    $(`#filter-attribute-${attribute.id}`).prop('disabled', true);
                } else {
                    $(`#filter-attribute-${attribute.id}`).val(valueAttribute);
                }

            });


            // variation
            let variation = $('.variation:checked').map(function () {
                return this.value;
            }).get().join('-');

            if (variation == "") {
                $('#filter-variation').prop('disabled', true);
            } else {
                $('#filter-variation').val(variation);
            }

            // sort
            let sortBy = $('#sort-by').val();
            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }

            // search
            let search = $('#search-input').val();
            if (search == "") {
                $('#filter-search').prop('disabled', true);
            } else {
                $('#filter-search').val(search);
            }

            //submit form
            $('#filter-form').submit();
        }

        $('#filter-form').on('submit', function (event) {
            event.preventDefault();
            let currentUrl = '{{ url()->current() }}';
            let url = currentUrl + '?' + decodeURIComponent($(this).serialize());
            $(location).attr('href', url);
        });

        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price-'+ variation.product_id);

            variationPriceDiv.empty();

            if (variation.is_sale){
                let spanNew = $('<span/>', {
                    class: 'new',
                    text : toPersianNum(number_format(variation.sale_price)) + 'تومان '
                });
                let spanOld = $('<span/>', {
                    class: 'old',
                    text : toPersianNum(number_format(variation.price)) + 'تومان '
                });

                variationPriceDiv.append(spanNew);
                variationPriceDiv.append(spanOld);
            }else{
                let spanNew = $('<span/>', {
                    class: 'new',
                    text : toPersianNum(number_format(variation.price)) + 'تومان '
                });

                variationPriceDiv.append(spanNew);
            }

            $('.quantityInput').attr('data-max',variation.quantity);
            // $('.quantityInput').attr('value',1);
            $('.quantityInput').val(1);
        });

        $('#pagination li a').map(function () {
            let decodeUrl=decodeURIComponent($(this).attr('href'));
            if ( $(this).attr('href') !== undefined ){
                $(this).attr('href',decodeUrl);
            }
        });

    </script>
@endsection

@section('content')
    {{--    passed 4 variable from show method of Home/CategoryController to this page: --}}
    {{--        number 1 --> $category --> this return selected category--}}
    {{--        number 2 --> $attributes --> this return attributes of selected category via distinct values--}}
    {{--        number 3 --> $variation --> this return variation of selected category via distinct values--}}
    {{--        number 4 --> $products --> this return products of selected category--}}

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active">فروشگاه</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="shop-area pt-95 pb-100">
        <div class="container">
            <div class="row flex-row-reverse text-right">

                <!-- sidebar -->
                <div class="col-lg-3 order-2 order-sm-2 order-md-1">
                    <div class="sidebar-style mr-30">

                        {{--search--}}
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">جستجو </h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <div class="pro-sidebar-search-form">
                                    <input id="search-input" type="text" placeholder="... جستجو "
                                           value="{{ request()->has('search') ? request()->search : '' }}">

                                    <button type="button" onclick="filter()">
                                        <i class="sli sli-magnifier"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>

                        {{--category--}}
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title"> دسته بندی </h4>
                            <div class="sidebar-widget-list mt-30">
                                <ul>
                                    <li>
                                        {{ $category->parent->name }}
                                    </li>

                                    @foreach($category->parent->children as $childCategory)
                                        <li>
                                            <a href="{{ route('home.categories.show',['category'=>$childCategory->slug]) }}"
                                               class="{{ $category->slug == $childCategory->slug ? 'text-danger' : ''}}">
                                                {{ $childCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>

                        {{--attributes--}}
                        @foreach($attributes as $attribute)
                            <div class="sidebar-widget mt-30">
                                <h4 class="pro-sidebar-title">{{ $attribute->name }}</h4>
                                <div class="sidebar-widget-list mt-20">
                                    <ul>
                                        @foreach($attribute->values as $value)

                                            <li>
                                                <div class="sidebar-widget-list-left">
                                                    <input type="checkbox" value="{{ $value->value }}"
                                                           onchange="filter()" class="attribute-{{$attribute->id}}"
                                                        {{ ( request()->has('attribute.'.$attribute->id) && in_array($value->value,explode('-',request()->attribute[$attribute->id])) ) ? 'checked' : '' }}>

                                                    <a href="#">{{ $value->value }}</a>
                                                    <span class="checkmark"></span>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        {{--variation--}}
                        <div class="sidebar-widget mt-30">
                            <h4 class="pro-sidebar-title">{{ $variation->name }}</h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach($variation->variationValues as $value)
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" class="variation" value="{{ $value->value }}"
                                                       onchange="filter()"
                                                    {{ ( request()->has('variation') && in_array($value->value,explode('-',request()->variation)) ) ? 'checked' : '' }}>
                                                <a href="#">{{ $value->value }}</a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>

                <!-- content -->
                <div class="col-lg-9 order-1 order-sm-1 order-md-2">
                    <!-- shop-top-bar -->
                    <div class="shop-top-bar" style="direction: rtl;">

                        <div class="select-shoing-wrap">
                            <div class="shop-select">
                                <select onchange="filter()" id="sort-by">
                                    <option value="default"> مرتب سازی</option>
                                    <option
                                        value="max" {{ ( request()->has('sortBy') && request()->sortBy == 'max' ) ? 'selected' : '' }} >
                                        بیشترین قیمت
                                    </option>
                                    <option
                                        value="min" {{ ( request()->has('sortBy') && request()->sortBy == 'min' ) ? 'selected' : '' }} >
                                        کم ترین قیمت
                                    </option>
                                    <option
                                        value="latest" {{ ( request()->has('sortBy') && request()->sortBy == 'latest' ) ? 'selected' : '' }} >
                                        جدیدترین
                                    </option>
                                    <option
                                        value="oldest" {{ ( request()->has('sortBy') && request()->sortBy == 'oldest' ) ? 'selected' : '' }} >
                                        قدیمی ترین
                                    </option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">

                            <div class="row ht-products" style="direction: rtl;">

                                <!--Product Start-->
                                @foreach($products as $product)
                                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                                            <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                                <div class="ht-product-inner">
                                                    <div class="ht-product-image-wrap">
                                                        <a href="product-details.html" class="ht-product-image">
                                                            <img
                                                                src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                                                alt="{{ $product->name }}"/>
                                                        </a>
                                                        <div class="ht-product-action">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" data-toggle="modal"
                                                                       data-target="#modal-{{ $product->id }}">
                                                                        <i class="sli sli-magnifier"></i>
                                                                        <span
                                                                            class="ht-product-action-tooltip"> مشاهده سریع</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="sli sli-heart"></i>
                                                                        <span class="ht-product-action-tooltip"> افزودن به علاقه مندی ها </span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="sli sli-refresh"></i>
                                                                        <span class="ht-product-action-tooltip"> مقایسه</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="ht-product-content">
                                                        <div class="ht-product-content-inner">
                                                            <div class="ht-product-categories">
                                                                <a href="#">{{ $product->category->name }}</a>
                                                            </div>
                                                            <h4 class="ht-product-title text-right">
                                                                <a href="product-details.html">{{ $product->name }}</a>
                                                            </h4>

                                                            <div class="ht-product-price">
                                                                @if ($product->quantity_check)
                                                                    @if ($product->sale_check)
                                                                        <span class="new">
                                                                            {{ number_format($product->sale_check->sale_price) }}
                                                                            تومان
                                                                         </span>
                                                                        <span class="old">
                                                                            {{ number_format($product->sale_check->price) }}
                                                                            تومان
                                                                        </span>
                                                                    @else
                                                                        <span class="new">
                                                                            {{ number_format($product->price_check->price) }}
                                                                            تومان
                                                                         </span>
                                                                    @endif
                                                                @else
                                                                    <div class="not-in-stock">
                                                                        <p class="text-white">عدم موجودی</p>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="ht-product-ratting-wrap">
                                                                <div
                                                                    data-rating-stars="5"
                                                                    data-rating-readonly="true"
                                                                    data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                <!--Product End-->

                            </div>

                        </div>

                        <div id="pagination" class="pro-pagination-style text-center mt-30">
                            {{ $products->withQueryString()->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <form id="filter-form">

        {{--input for attributes values--}}
        @foreach($attributes as $attribute)
            <input id="filter-attribute-{{$attribute->id}}" name="attribute[{{$attribute->id}}]" type="hidden">
        @endforeach

        {{--input for variationValues--}}
        <input id="filter-variation" name="variation" type="hidden">

        {{--input for sort value--}}
        <input id="filter-sort-by" name="sortBy" type="hidden">

        {{--input for search value--}}
        <input id="filter-search" name="search" type="hidden">

    </form>

    <!-- Modal -->
    @foreach($products as $product)
        <div class="modal fade" id="modal-{{ $product->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            {{--contentModal--}}
                            <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                                <div class="product-details-content quickview-content">

                                    <h2 class="text-right mb-4">{{ $product->name }}</h2>

                                    <div class="product-details-price variation-price-{{ $product->id }}">
                                        @if ($product->quantity_check)
                                            @if ($product->sale_check)
                                                <span class="new">
                                                    {{ number_format($product->sale_check->sale_price) }}
                                                    تومان
                                                </span>
                                                <span class="old">
                                                    {{ number_format($product->sale_check->price) }}
                                                    تومان
                                                </span>
                                            @else
                                                <span class="new">
                                                    {{ number_format($product->price_check->price) }}
                                                    تومان
                                                </span>
                                            @endif
                                        @else
                                            <div class="not-in-stock">
                                                <p class="text-white">عدم موجودی</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pro-details-rating-wrap">
                                        <div
                                            data-rating-stars="5"
                                            data-rating-readonly="true"
                                            data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                        </div>
                                        <span class="mx-3">|</span>
                                        <span>3 دیدگاه</span>
                                    </div>

                                    <p class="text-right">
                                        {{ $product->description }}
                                    </p>

                                    <div class="pro-details-list text-right">
                                        <ul class="text-right">
                                            @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                                <li>{{ $attribute->attribute->name }}: {{ $attribute->value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>


                                    @if ($product->quantity_check)
                                        @php
                                            if ($product->sale_check) {
                                                $variationProductSelected=$product->sale_check;
                                            }else{
                                                $variationProductSelected=$product->price_check;
                                            }
                                        @endphp
                                        <div class="pro-details-size-color text-right">
                                            <div class="pro-details-size w-50">
                                                <span>{{ $product->variations()->with('attribute')->first()->attribute->name }}</span>
                                                <select class="form-control variation-select">
                                                    @foreach($product->variations()->where('quantity','>',0)->get() as $variation)
                                                        <option value="{{ json_encode($variation->only(['id','quantity','product_id','is_sale','sale_price','price'])) }}"
                                                            {{ $variation->id == $variationProductSelected->id ? 'selected' : '' }}>
                                                            {{ $variation->value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="pro-details-quality">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box quantityInput"
                                                       data-max="5" type="text" name="qtybutton" value="1"/>
                                            </div>
                                            <div class="pro-details-cart">
                                                <a href="#">افزودن به سبد خرید</a>
                                            </div>
                                            <div class="pro-details-wishlist">
                                                <a title="Add To Wishlist" href="#"><i class="sli sli-heart"></i></a>
                                            </div>
                                            <div class="pro-details-compare">
                                                <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="not-in-stock mb-3">
                                            <p class="text-white">عدم موجودی</p>
                                        </div>
                                    @endif


                                    <div class="pro-details-meta">
                                        <span>دسته بندی :</span>
                                        <ul>
                                            <li><a href="#">{{ $product->category->name }}
                                                    - {{ $product->category()->with('parent')->first()->parent->name }}</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="pro-details-meta">
                                        <span>تگ ها :</span>
                                        <ul>
                                            @foreach($product->tags as $tag)
                                                <li><a href="#">{{ $tag->name }}{{ $loop->last ? '' : '،' }} </a></li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            {{--imagesModal--}}
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="tab-content quickview-big-img">
                                    <div id="pro-primary-{{ $product->id }}" class="tab-pane fade show active">
                                        <img
                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                            alt="{{ $product->primary_image }}"/>
                                    </div>
                                    @foreach($product->images as $image)
                                        <div id="pro-{{ $image->id }}" class="tab-pane fade">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                                 alt="{{ $image->image }}"/>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Thumbnail Large Image End -->
                                <!-- Thumbnail Image End -->
                                <div class="quickview-wrap mt-15">
                                    <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                        <a class="active" data-toggle="tab" href="#pro-primary-{{ $product->id }}"><img
                                                src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                                alt="{{ $product->primary_image }}"/></a>
                                        @foreach($product->images as $image)
                                            <a data-toggle="tab" href="#pro-{{ $image->id }}"><img
                                                    src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                                    alt="{{ $image->image }}"/></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal end -->
@endsection
