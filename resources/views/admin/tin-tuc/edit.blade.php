@extends('admin.layout')
@section('title')
    {{ $title }}
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
                <form method="POST" action="{{route('post.edit',$post->id)}}">
                    @csrf

                    <div class="form-group">
                        <label for="tieuDe">Tiêu Đề:</label>
                        <input type="text" class="form-control" id="tieuDe" name="tieuDe"  value="{{old('tieuDe') ?? $post->tieuDe}}">
                        @error('tieuDe')
                            <div class="badge" style="color:red" role="alert">
                                <strong>* {{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="loaiTin">Loại Tin:</label>
                        <select class="form-control" id="loaiTin" name="idDmTin" >
                            <option value="">Chọn loại tin</option>
                            @foreach ($cate as $item)
                                <option value="{{$item->id}}"{{old('idDmTin') == $item->id || $post->idDmTin == $item->id ? 'selected' : false }}> {{$item->ten}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="urlHinh">Hình ảnh</label>
                        <input type="file" class="form-control" id="urlHinh" name="urlHinh" >
                        @error('urlHinh')
                            <div class="badge" style="color:red" role="alert">
                                <strong>* {{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tomTat">Tóm Tắt:</label>
                        <textarea class="form-control" id="tomTat" name="tomTat" rows="3" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="noiDung">Nội Dung:</label>
                        <textarea class="form-control" id="noiDung" name="noiDung" rows="6" ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>
            </div>
        </div>

        <select name="" id="">
            <option value="" selected></option>
        </select>


    </div>
@endsection
@section('js-custom')
    <script>
        ClassicEditor
            .create(document.querySelector('#noiDung'))
            .catch(error => {
                console.error(error);
            })
    </script>
@endsection
