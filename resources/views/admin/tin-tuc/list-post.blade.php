@extends('admin.layout')
@section('title')
    {{$title}}
@endsection
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Loại Tin</h1>


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
                                <th>STT</th>
                                <th>Danh Mục</th>
                                <th>Tiêu Đề</th>
                                <th>Hình ảnh</th>
                                <th>Tóm tắt</th>
                                <th>Ngày Đăng</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        @if (!empty($post))
                            @foreach ($post as $key=>$item)
                                <tbody class="text-center">
                                    <td>{{ $item->tenDm }}</td>
                                    <td>{{$item->tieuDe}}</td>
                                    <td>{{asset($item->urlHinh)}}</td>
                                    <td>{{$item->tomTat}}</td>
                                    <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                                    @if ($item->anHien == 1)
                                        <td>
                                            <div>
                                                <a href="{{route('post.hide',$item->id)}}" class="btn btn-primary">Đang hiện</a>
                                            </div>
                                        </td>
                                    @else
                                    <td>
                                        <div>
                                            <a href="{{route('post.show',$item->id)}}" class="btn btn-warning">Đang ẩn</a>
                                        </div>
                                    </td>
                                    @endif
                                    <td>
                                        <div><a href="{{route('post.edit',$item->id)}}" ><i class="fa-solid fa-pencil" style="color:blue"></i></a></div>
                                        
                                        <div><a href="{{route('post.delete',$item->id)}}" onclick="return confirm('Bạn có chắc muốn xóa')"><i class="fa-solid fa-trash"  style="color:red"></i></a></div>
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
