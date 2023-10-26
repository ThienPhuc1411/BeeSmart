<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HDCTResource;

class HoaDonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ma_hoa_don' => $this->maHd,
            'tong_tien' => $this->tongTien,
            'tong_giam_gia' => $this->tongGiamGia,
            'id_cua_hang' => $this->idCh,
            'cua_hang' => $this->cuaHang->tenCh,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'hdct' => HDCTResource::collection($this->hoaDonCT)
        ];
    }
}
