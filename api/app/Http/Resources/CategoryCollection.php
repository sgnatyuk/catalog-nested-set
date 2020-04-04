<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Category;

/**
 * @mixin Category
 * @property int depth;
 * @property int products_count;
 */
class CategoryCollection extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => str_repeat('--', $this->depth) . ' ' . $this->title,
            'productsCount' => $this->products_count,
            'createdAt'     => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
