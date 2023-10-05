<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoaiCuaHang extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return['ID'=>$this->id,'Ten'=>$this->ten,
        'CR'=>$this->created_at,'UD'=>$this->updated_at,];
    }
}
