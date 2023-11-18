@extends('admin.layout')
@section('title')
    {{ $title }}
@endsection
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Loại sản phẩm</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                @if (session('msg'))
                    {{-- <a href="#" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                    </a> --}}
                    <div class="alert alert-success">{{ session('msg') }}</div>
                @endif


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>Tên Loại</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (!empty($loaiSp))
                                @foreach ($loaiSp as $loaiSp)
                                    <tr>
                                        <td>{{ $loaiSp->ten }}</td>
                                        <td>{{ date('d-m-Y', strtotime($loaiSp->created_at)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($loaiSp->updated_at)) }}</td>
                                        <td>
                                            <div><a href="{{ route('product-type.edit', $loaiSp->id) }}"><i
                                                        class="fa-solid fa-pencil" style="color:blue"></i></a></div>

                                            <div><a href="{{ route('product-type.delete', $loaiSp->id) }}"
                                                    onclick="return confirm('Bạn có chắc muốn xóa')"><i
                                                        class="fa-solid fa-trash" style="color:red"></i></a></div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="" class="text-center">Không có dữ liệu</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{-- <div class="d-flex justify-content-end">{{ $loaiSp->links() }}</div> --}}
                </div>
            </div>
        </div>


    </div>
@endsection
