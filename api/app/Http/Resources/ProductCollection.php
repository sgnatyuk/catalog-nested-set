<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Product;

/**
 * @mixin Product
 */
class ProductCollection extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'categoryTitle' => $this->category->title,
            'createdAt'     => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
