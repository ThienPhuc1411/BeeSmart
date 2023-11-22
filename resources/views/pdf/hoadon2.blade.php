<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <h1 class="text-center"> Hoa don {{ $cuaHang->tenCh }}</h1>
    <table class="table table-bordered"  >
        <thead>
            <tr class="table-light text-center">
                <th scope="col" width="5%">STT</th>
                <th scope="col" width="25%">Mã hóa đơn</th>
                <th scope="col" width="25%">Tổng tiền</th>
                <th scope="col" width="25%">Tổng giảm giá</th>
                <th scope="col" width="10%">Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hoadon as $key=>$item)
                <tr>
                    <th scope="row" style="color:red">{{$key+1}}</th>
                    <td>{{$item->maHd}}</td>
                    <td class="text-end">{{number_format($item->tongTien,0,'','.')}}</td>
                    <td class="text-end">{{number_format($item->tongGiamGia,0,'','.')}}</td>
                    <td>{{date('d/m/Y',strtotime($item->created_at))}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
