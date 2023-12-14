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
        // dd($row);
        return new SanPham([
            'ten' => $row['ten'],
            'maSp' => $row['ma_san_pham'],
            'giaVon' => $row['gia_von'],
            'giaBan' => $row['gia_ban'],
            'soLuong' => $row['so_luong'],
            'donVi' => $row['don_vi'],
            'theTich' => $row['the_tich'],
            'khoiLuong' => $row['khoi_luong'],
            'ngayTao' => Carbon::now()->format("Y-m-d"),
        ]);
    }
}
