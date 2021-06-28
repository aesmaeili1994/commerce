@extends('admin.layouts.admin')

@section('title')
    index tag
@endsection

@section('content')
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست برچسب ها ({{$tags->total()}})</h5>
                <div>
                    <a href="{{route('admin.tags.create')}}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        ایجاد برچسب
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($tags as $key=>$tag)
                        <tr>
                            <th>{{ $tags->firstItem() + $key }}</th>
                            <th>{{ $tag->name }}</th>

                            <th>
                                <a href="{{ route('admin.tags.show',['tag'=>$tag->id]) }}" class="btn btn-sm btn-outline-success">نمایش</a>
                                <a href="{{ route('admin.tags.edit',['tag'=>$tag->id]) }}" class="btn btn-sm btn-outline-info mr-3">ویرایش</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{$tags->render()}}
            </div>

        </div>
    </div>

@endsection
