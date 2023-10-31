@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Khách hàng</h1>


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
                        @if (!empty($loaiCh))
                            @foreach ($loaiCh as $loaiCh)
                                <tbody class="text-center">
                                    <td>{{ $loaiCh->ten }}</td>
                                    <td>{{ date('d-m-Y',strtotime($loaiCh->created_at)) }}</td>
                                    <td>{{ date('d-m-Y',strtotime($loaiCh->updated_at)) }}</td>
                                    <td>
                                        <div><a href="{{route('store-type.edit',$loaiCh->id)}}" ><i class="fa-solid fa-pencil" style="color:blue"></i></a></div>
                                        
                                        <div><a href="{{route('store-type.delete',$loaiCh->id)}}" onclick="return confirm('Bạn có chắc muốn xóa')"><i class="fa-solid fa-trash"  style="color:red"></i></a></div>
                                    </td>
                                    
                                </tbody>
                            @endforeach
                        @else
                            <td colspan="" class="text-center">Không có dữ liệu</td>
                        @endif
                    </table>
                    {{-- <div class="d-flex justify-content-end">{{ $loaiCh->links() }}</div> --}}
                </div>
            </div>
        </div>

        
    </div>
@endsection
