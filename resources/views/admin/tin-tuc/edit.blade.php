@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cập nhật Tin</h1>


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
            <form method="POST" action="">
                @csrf
                @method('PUT') 
        
                <div class="form-group">
                    <label for="tieuDe">Tiêu Đề:</label>
                    <input type="text" class="form-control" id="tieuDe" name="tieuDe" required value="">
                </div>
        
                <div class="form-group">
                    <label for="loaiTin">Loại Tin:</label>
                    <select class="form-control" id="loaiTin" name="loaiTin" required>
                        {{-- @if (!empty($post))
                            @foreach($post as $key=>$item)
                                <option value="{{ $item->id }}" {{ $item->id == $item->loaiTinId ? 'selected' : '' }}>{{ $item->ten }}</option>
                            @endforeach
                        @else
                            <option>Không có dữ liệu</option>
                        @endif --}}
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="tomTat">Tóm Tắt:</label>
                    <textarea class="form-control" id="tomTat" name="tomTat" rows="3" required></textarea>
                </div>
        
                <div class="form-group">
                    <label for="noiDung">Nội Dung:</label>
                    <textarea class="form-control" id="noiDung" name="noiDung" rows="6" required></textarea>
                </div>
        
                <button type="submit" class="btn btn-primary">Cập Nhật Tin Tức</button>
            </form>
        </div>
    </div>

    
</div>
@endsection
@section('js-custom')
    <script>
        ClassicEditor
            .create(document.querySelector('#noiDung'))
            .catch(error =>{
                console.error(error);
            })
    </script>
@endsection