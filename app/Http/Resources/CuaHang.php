<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuaHang extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return['ID'=>$this->id,'TenCH'=>$this->ten_ch,
        'DIACHI'=>$this->diaChi,'IDLCH'=>$this->idLoaiCh,
        'CR'=>$this->created_at,'UD'=>$this->updated_at,];
    }
}
