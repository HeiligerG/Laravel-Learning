<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ratingMapping = [
            1 => 'bad',
            2 => 'not good',
            3 => 'ok',
            4 => 'good',
            5 => 'really good'
        ];
    }
}
