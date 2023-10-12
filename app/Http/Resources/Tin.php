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
        return['ID'=>$this->id,'TD'=>$this->tieuDe,'TT'=>$this->tomTat,
        'ND'=>$this->noiDung,'IDDM'=>$this->idDmTin,'IDUS'=>$this->idUsers,
        'AH'=>$this->anHien,'CR'=>$this->created_at,'UD'=>$this->updated_at,];
    }
}
