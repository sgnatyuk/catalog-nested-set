<?php

namespace App\Http\Controllers;

use App\Actions\Product\UploadImageAction;
use App\DTO\Product\UploadImageDTO;
use App\Http\Requests\UploadImage;
use App\Services\ImageService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

final class ProductImageUploadController
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function __invoke(UploadImage $request, UploadImageAction $uploadImageAction): JsonResponse
    {
        $uploadImageDTO = new UploadImageDTO(
            $request->file('image')
        );

        $result = $uploadImageAction->execute($uploadImageDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        $body = $result->getBody();

        return new JsonResponse(
            [
                'image' => $this->imageService->fit($body['name'], 128, 128),
            ],
            Response::HTTP_CREATED,
            [
                'X-Created-Resource-Id' => $body['id'],
            ]);
    }
}
