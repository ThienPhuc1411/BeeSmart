<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Tin extends JsonResource
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
            'tieuDe' => $this->tieuDe,
            'tomTat' => $this->tomTat,
            'noiDung' => $this->noiDung,
            'idDmTin' => $this->idDmTin,
            'idUsers' => $this->idUsers,
            'anHien' => $this->anHien,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'slug' => $this->slug
        ];
    }
}
