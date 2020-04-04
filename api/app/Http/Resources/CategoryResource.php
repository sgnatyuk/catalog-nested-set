<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Category;

/**
 * @mixin Category
 */
class CategoryResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'parentId' => $this->parent_id,
            'title'    => $this->title,
            'content'  => $this->content,
        ];
    }
}
