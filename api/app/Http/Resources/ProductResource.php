<?php

namespace App\Http\Resources;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Product;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'categoryId' => $this->category_id,
            'imageId'    => $this->image_id,
            'title'      => $this->title,
            'content'    => $this->content,
            'image'      => ImageService::i()->fit($this->image->name, 128, 128),
        ];
    }
}
