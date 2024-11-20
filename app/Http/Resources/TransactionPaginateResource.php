<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionPaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            "data" => TransactionResource::collection($this->items()),
            'pagination' => [
                'total'         => $this->total(),
                'per_page'      => $this->perPage(),
                'current_page'  => $this->currentPage(),
                'last_page'     => $this->lastPage(),
                'from'          => $this->firstItem(),
                'to'            => $this->lastItem()
            ]
        ];
    }
}
