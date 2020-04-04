<?php

namespace App\Proxies;

use App\Models\Image;

class ImageProxy
{
    public function create(string $name): Image
    {
        return Image::create([
            'name' => $name,
        ]);
    }

    public function edit(int $id, bool $use = true): bool
    {
        return Image::query()
            ->findOrFail($id)
            ->fill(['use' => $use])
            ->save();
    }
}
