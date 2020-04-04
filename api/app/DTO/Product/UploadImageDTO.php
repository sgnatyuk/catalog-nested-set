<?php

namespace App\DTO\Product;

use Illuminate\Http\UploadedFile;

final class UploadImageDTO
{
    public UploadedFile $image;

    public function __construct(UploadedFile $image)
    {
        $this->image = $image;
    }
}
