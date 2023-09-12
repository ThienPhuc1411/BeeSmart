@extends('admin.layout')
@section('container')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Tin</h1>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">

                <a href="#" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">ahihi</span>
                </a>
            

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>

                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>

                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <td>Tên</td>
                            <td>Email</td>
                            <td>Địa Chỉ</td>

                            <td>Ngày Tạo</td>
                            <td><p><a href=" "onclick="return confirm('Bạn có chắc muốn bỏ vào thùng rác?')" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text" style="width:120px">Thùng Rác</span>
                                    </a></p>
                                    <p><a href="" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text" style="width:120px">Cập nhật</span>
                                    </a></p>
                            </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
