<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hóa Đơn</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
    {{-- <link href="{{ asset('ad/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        *{
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>
    <div class="container mt-2">
        <h2 class="text-center mb-3">Hoa Don {{$cuaHang->tenCh}}</h2>
        <table class="table table-bordered mb-5" style="border: 1px solid black; border-collapse:collapse">
            <thead style="border: 1px solid black;">
                <tr class="table-danger" style="border: 1px solid black; background-color:grey">
                    <th scope="col" class="text-center" style="border: 1px solid black;">STT</th>
                    <th scope="col" class="text-center" style="border: 1px solid black;">Ma Hoa Don</th>
                    <th scope="col" class="text-center" style="border: 1px solid black;">Tong Tien</th>
                    <th scope="col" class="text-center" style="border: 1px solid black;">Tong Giam Gia</th>
                    <th scope="col" class="text-center" style="border: 1px solid black;">Ngay Tao</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hoadon as $key=>$data)
                <tr>
                    <th scope="row" class="text-center p-1" style="border: 1px solid black;">{{ $key+1 }}</th>
                    <td scope="row" class="text-center p-1" style="border: 1px solid black;">{{ $data->maHd }}</td>
                    <td scope="row" class="text-end p-1" style="border: 1px solid black;">{{ number_format($data->tongTien,0,'','.') }}</td>
                    <td scope="row" class="text-end p-1" style="border: 1px solid black;">{{ number_format($data->tongGiamGia,0,'','.') }}</td>
                    <td scope="row" class="text-end p-1" style="border: 1px solid black;">{{ date('d/m/Y',strtotime($data->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <script src="{{ asset('ad/js/bootstrap.bundle.min.js') }}" type="text/js"></script> --}}
</body>
</html>
