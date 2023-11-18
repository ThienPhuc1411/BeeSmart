@extends('admin.layout')
@section('title')
    {{ $title }}
@endsection
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cập nhật Loại sản phẩm</h1>


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
                <form method="POST" action="{{ route('product-type.edit', $loaiSp->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="ten">Tên loại sản phẩm:</label>
                        <input type="text" class="form-control" id="ten" name="ten"
                            value="{{ old('ten') ?? $loaiSp->ten }}">
                        @error('ten')
                            <div class="badge" style="color:red" role="alert">
                                <strong>* {{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>


    </div>
@endsection
