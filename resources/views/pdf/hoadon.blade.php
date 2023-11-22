<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('ad/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Hóa Đơn {{$cuaHang->tenCh}}/h2>
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">STT</th>
                    <th scope="col">Mã Hóa Đơn</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Tổng giảm giá</th>
                    <th scope="col">Ngày Tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hoadon as $key=>$data)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $data->maHd }}</td>
                    <td>{{ number_format($data->tongTien,0,'','.') }}</td>
                    <td>{{ number_format($data->tongGiamGia,0,'','.') }}</td>
                    <td>{{ date('d/m/Y',strtotime($data->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('ad/js/bootstrap.bundle.min.js') }}" type="text/js"></script>
</body>
</html>
