@extends('admin.layout')
@section('title')
    {{ $title }}
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Tên</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($lienhe))
                                @foreach ($lienhe as $lienhe)
                                    <tr>
                                        <td>{{ $lienhe->email }}</td>
                                        <td>{{ $lienhe->HoTen }}</td>
                                        <td>{{ $lienhe->sdt }}</td>
                                        @if ($lienhe->Diachi == null)
                                            <td>( Trống )</td>
                                        @else
                                            <td>{{ $lienhe->Diachi }}</td>
                                        @endif
                                        <td>{{ $lienhe->moTa }}</td>
                                        <td>{{ date('H:i:s d/m/Y', strtotime($lienhe->created_at)) }}</td>
                                        @if ($lienhe->status == 1)
                                            <td><a href="" class="btn btn-primary">Đã
                                                    duyệt</a></td>
                                        @else
                                            <td><a href="{{ route('lien-he.confirm', $lienhe->id) }}"
                                                    class="btn btn-danger">Chưa duyệt</a></td>
                                        @endif
                                    </tr>
                                @endforeach
                        </tbody>
                    @else
                        <td colspan="" class="text-center">Không có dữ liệu</td>
                        @endif
                    </table>
                    {{-- <div class="d-flex justify-content-end">{{ $lienhe->links() }}</div> --}}
                </div>
            </div>
        </div>


    </div>
@endsection
