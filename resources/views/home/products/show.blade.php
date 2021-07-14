@extends('home.layouts.home')

@section('title')
    صفحه محصولات
@endsection

@section('script')
    <script>
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
    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ی اصلی</a>
                    </li>
                    <li class="active">محصولات</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="product-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                    <div class="product-details-content ml-30">
                        <h2 class="text-right">{{ $product->name }}</h2>
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
                            <span>{{ $product->approvedComments()->count() }} دیدگاه</span>
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
                            <div class="pro-details-size-color">
                                <div class="pro-details-size text-right">
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
                                <div class="pro-details-cart btn-hover">
                                    <a href="#"> افزودن به سبد خرید </a>
                                </div>
                                <div class="pro-details-wishlist">
                                    @auth
                                        @if ($product->checkUserWishlist(auth()->id()))
                                            <a href="{{ route('home.wishlist.remove',['product'=>$product->id]) }}">
                                                <i class="fas fa-heart" style="color: red"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('home.wishlist.add',['product'=>$product->id]) }}">
                                                <i class="sli sli-heart"></i>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('home.wishlist.add',['product'=>$product->id]) }}">
                                            <i class="sli sli-heart"></i>
                                        </a>
                                    @endauth
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

                <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                                 data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}" alt="{{ $product->primary_image }}"/>

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a data-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}"
                               data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}">
                                <img width="90" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$product->primary_image) }}" alt="{{ $product->primary_image }}">
                            </a>
                            @foreach($product->images as $image)
                                <a data-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}"
                                   data-zoom-image="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}">
                                    <img width="90" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH').$image->image) }}" alt="{{ $image->image }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="comments" class="description-review-area pb-95">
        <div class="container">
            <div class="row" style="direction: rtl;">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="{{ count($errors) > 0 ? '' :'active' }}" data-toggle="tab" href="#des-details1"> توضیحات </a>
                            <a data-toggle="tab" href="#des-details3"> اطلاعات بیشتر </a>
                            <a class="{{ count($errors) > 0 ? 'active' :'' }}" data-toggle="tab" href="#des-details2">
                                دیدگاه
                                ({{ $product->approvedComments()->count() }})
                            </a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane {{ count($errors) > 0 ? '' :'active' }}">
                                <div class="product-description-wrapper">
                                    <p class="text-right">
                                        {{ $product->description }}
                                    </p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper text-right">
                                    <ul class="text-right">
                                        @foreach($product->attributes()->with('attribute')->get() as $attribute)
                                            <li><span> {{ $attribute->attribute->name }} : </span>{{ $attribute->value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane {{ count($errors) > 0 ? 'active' :'' }}">

                                <div class="review-wrapper">
                                    @foreach($product->approvedComments as $approvedComment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="{{ $approvedComment->user->avatar == null ? asset('/images/home/user.png') : $approvedComment->user->avatar }}"
                                                     alt="{{$approvedComment->user->avatar}}">
                                            </div>
                                            <div class="review-content w-100 text-right">
                                                <p class="text-right">
                                                    {{ $approvedComment->text }}
                                                </p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4> {{ $approvedComment->user->name == null ? 'کاربر گرامی' : $approvedComment->user->name }} </h4>
                                                    </div>
                                                    <div
                                                        data-rating-stars="5"
                                                        data-rating-readonly="true"
                                                        data-rating-value="{{ ceil($approvedComment->user->rates->where('product_id',$product->id)->avg('rate')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="ratting-form-wrapper text-right">
                                    <span> نوشتن دیدگاه </span>

                                    <div class="my-3" id="dataReadonlyReview"
                                         data-rating-stars="5"
                                         data-rating-value="0"
                                         data-rating-input="#rateInput">
                                    </div>

                                    @include('home.sections.errors')

                                    <div class="ratting-form">
                                        <form action="{{ route('home.comments.store',['product'=>$product->id]) }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label> متن دیدگاه : </label>
                                                        <textarea name="text"></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="rate" id="rateInput" value="0">
                                                <div class="col-lg-12">
                                                    <div class="form-submit">
                                                        <input type="submit" value="ارسال">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#"><img src="{{ asset('images/home/banner-7.png') }}" alt="banner-7.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
