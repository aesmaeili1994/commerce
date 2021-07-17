@extends('admin.layouts.admin')

@section('title')
    index coupons
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست کوپن ها ({{$coupons->total()}})</h5>
                <div>
                    <a href="{{route('admin.coupons.create')}}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        ایجاد کوپن
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>کد</th>
                        <th>نوع</th>
                        <th>تاریخ انقضا</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($coupons as $key=>$coupon)
                        <tr>
                            <th>{{ $coupons->firstItem() + $key }}</th>
                            <th>{{ $coupon->name }}</th>
                            <th>{{ $coupon->code }}</th>
                            <th>{{ $coupon->type }}</th>
                            <th>{{ verta($coupon->expired_at) }}</th>
                            <th>
                                <div class="d-inline-block" style="width: max-content">
                                    <a href="{{ route('admin.coupons.show',['coupon'=>$coupon->id]) }}" class="btn btn-sm btn-outline-success">نمایش</a>
                                    <a href="{{ route('admin.coupons.edit',['coupon'=>$coupon->id]) }}" class="btn btn-sm btn-outline-info">ویرایش</a>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{$coupons->render()}}
            </div>

        </div>
    </div>

@endsection
