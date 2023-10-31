@extends('admin.layout')
@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Khách hàng</h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                @if (session('msg'))
                    <a href="#" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                    </a>
                @endif


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Quận</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        @foreach ($users as $users)
                            <tbody>
                                <td>{{ $users->HoTen }}</td>
                                <td>{{ $users->email }}</td>
                                <td>{{ $users->sdt }}</td>
                                @if ($users->Diachi == null)
                                    <td>( Trống )</td>
                                @else
                                    <td>{{ $users->Diachi }}</td>
                                @endif

                                <td>{{ $users->quan }}</td>
                                <td>
                                    @if ($users->status == 1)
                                        <p><a href="{{ route('user.block', $users->id) }}"onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')"
                                                class="btn btn-primary btn-icon-split">
                                                <span class="text" style="width:120px">Hoạt Động</span>
                                            </a>
                                        </p>
                                    @else
                                        <p><a href="{{ route('user.unblock', $users->id) }}"onclick="return confirm('Bạn có chắc muốn bỏ khóa tài khoản này?')"
                                                class="btn btn-warning btn-icon-split">
                                                <span class="text" style="width:120px">Đang khóa</span>
                                            </a>
                                        </p>
                                    @endif


                                </td>
                            </tbody>
                        @endforeach

                        {{-- <tfoot>
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Cửa hàng</th>
                            <th>Thời hạn</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </tfoot> --}}

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
