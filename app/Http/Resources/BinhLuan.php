<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BinhLuan extends JsonResource
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
            'idTin' => $this->idTin,
            'ngayDang' => $this->ngayDang,
            'noiDung' => $this->noiDung,
            'email' => $this->email,
            'hoTen' => $this->hoTen
        ];
    }
}
