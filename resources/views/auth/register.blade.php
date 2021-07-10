@extends('home.layouts.home')

@section('title')
    صفحه عضویت
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ثبت نام </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg2">
                                <h4> عضویت </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="post">
                                            @csrf
                                            <input name="name" placeholder="نام" class="@error('name') mb-1 @enderror" type="text" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="input-error-validation">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror

                                            <input name="email" placeholder="ایمیل" class="@error('email') mb-1 @enderror" type="email" value="{{ old('email') }}">
                                            @error('email')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror

                                            <input type="password" name="password" class="@error('password') mb-1 @enderror" placeholder="رمز عبور">
                                            @error('password')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror

                                            <input type="password" name="password_confirmation" class="@error('password-confirmation') mb-1 @enderror" placeholder="تکرار رمز عبور">
                                            @error('password-confirmation')
                                            <div class="input-error-validation">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror

                                            <div class="button-box">
                                                <button type="submit">عضویت</button>
                                                <a href="{{ route('provider.login',['provider'=>'google']) }}" class="btn btn-google btn-block mt-4">
                                                    <i class="sli sli-social-google"></i>
                                                    ایجاد اکانت با گوگل
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
