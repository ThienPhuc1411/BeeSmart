@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Danh mục tin</h1>


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
                                <th>Tên Loại Tin</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        @if (!empty($data))
                            @foreach ($data as $item)
                                <tbody class="text-center">
                                    <td>{{ $item->ten }}</td>
                                    <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                                    <td>{{ date('d-m-Y',strtotime($item->updated_at)) }}</td>
                                    @if ($item->anHien == 1)
                                        <td>
                                            <div>
                                                <a href="{{route('post-type.hide',$item->id)}}" class="btn btn-primary">Đang hiện</a>
                                            </div>
                                        </td>
                                    @else
                                    <td>
                                        <div>
                                            <a href="{{route('post-type.show',$item->id)}}" class="btn btn-warning">Đang ẩn</a>
                                        </div>
                                    </td>
                                    @endif
                                    <td>
                                        <div><a href="{{route('post-type.edit',$item->id)}}" ><i class="fa-solid fa-pencil" style="color:blue"></i></a></div>
                                        
                                        <div><a href="{{route('post-type.delete',$item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa')"><i class="fa-solid fa-trash"  style="color:red"></i></a></div>
                                    </td>
                                    
                                </tbody>
                            @endforeach
                        @else
                            <td colspan="" class="text-center">Không có dữ liệu</td>
                        @endif
                    </table>
                    {{-- <div class="d-flex justify-content-end">{{ $item->links() }}</div> --}}
                </div>
            </div>
        </div>

        
    </div>
@endsection
