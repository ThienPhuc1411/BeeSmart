@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Thêm Loại cửa hàng</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">Có lỗi xảy ra vui lòng kiểm tra lại thông tin đã nhập</div>                
            @endif

        </div>
        <div class="card-body">
            
        </div>
    </div>

    
</div>
@endsection