@extends('admin.layout')
@section('title')
    {{ $title }}
@endsection
@section('container')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Danh Mục Tin</h1>


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
                                <th>Tên tin</th>
                                <th>Nội dung</th>
                                <th>Ngày xóa</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (!empty($binhLuan))
                                @foreach ($binhLuan as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->tenTin }}</td>
                                        <td>{{ $item->noiDung }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->deleted_at)) }}</td>
                                        <td>
                                            <p>
                                                <a href="{{ route('cmt.force-delete', $item->id) }}"
                                                    class="btn btn-danger">Xóa
                                                    vĩnh viễn</a>
                                            </p>
                                            <p>
                                                <a href="{{ route('cmt.restore', $item->id) }}" class="btn btn-success">Khôi
                                                    phục</a>
                                            </p>
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
                    {{-- <div class="d-flex justify-content-end">{{ $loaitin->links() }}</div> --}}
                </div>
            </div>
        </div>


    </div>
@endsection
