<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class san_pham extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) {
        return [
          'id' => $this->id,
          'tensp' => $this->ten,
          'giaVon' => $this->giaVon,
          'giaBan' => $this->giaBan,
          'donVi' => $this->donVi,
          'giaKM'=>$this->khuyenMai,
          'soLuong' => $this->soLuong,
          'khoiLuong' => $this->khoiLuong,
          'theTich' => $this->theTich,
          'anHien' => $this->anHien,
          'idCh' => $this->idCh,
          'idNcc' => $this->idNcc,
          'idDm' => $this->idDm,
          'idTh' => $this->idTh,
          'idLoai' => $this->idLoai,
          'maSp' => $this->maSp,
          'ngayTao' => $this->ngayTao
        ];
      }
}
