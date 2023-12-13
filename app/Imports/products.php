<?php

namespace App\Imports;

use App\Models\SanPham;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;;

class products implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SanPham([
            'ten' => $row['Tên'],
            'maSp' => $row['Mã Sản Phẩm'],
            'giaVon' => $row['Giá vốn'],
            'giaBan' => $row['Giá bán'],
            'soLuong' => $row['Số Lượng'],
            'donVi' => $row['Đơn Vị'],
            'theTich' => $row['Thể Tích'],
            'khoiLuong' => $row['Khối Lượng'],
            // 'idCh' => $idCh,
            'ngayTao' => Carbon::now()->format("Y-m-d"),
        ]);
    }
}
