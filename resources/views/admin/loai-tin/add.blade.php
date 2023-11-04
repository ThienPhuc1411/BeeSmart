@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Thêm Danh Mục Tin</h1>


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
            <form method="POST" action="{{route('post-type.add')}}">
                @csrf
                <div class="form-group">
                    <label for="ten">Tên danh mục:</label>
                    <input type="text" class="form-control" id="ten" name="ten">
                    @error('ten')
                        <div class="badge" style="color:red" role="alert">
                        <strong>* {{$message}}</strong></div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>

    
</div>
@endsection