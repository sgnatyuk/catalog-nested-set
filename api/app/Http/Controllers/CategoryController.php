<?php

namespace App\Http\Controllers;

use App\Actions\Category\CreateAction;
use App\Actions\Category\DestroyAction;
use App\Actions\Category\EditAction;
use App\DTO\Category\CreateDTO;
use App\DTO\Category\DestroyDTO;
use App\DTO\Category\EditDTO;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController
{
    public function index()
    {
        return CategoryCollection::collection(Category::tree());
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreRequest $request, CreateAction $createAction)
    {
        $createDTO = new CreateDTO(
            $request->input('title'),
            $request->input('content')
        );

        $result = $createAction->execute($createDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_CREATED, [
            'X-Created-Resource-Id' => $result->getBody()['categoryId'],
        ]);
    }

    public function update(UpdateRequest $request, Category $category, EditAction $editAction)
    {
        $editDTO = new EditDTO(
            $category,
            $request->input('parentId'),
            $request->input('title'),
            $request->input('content'),
        );

        $result = $editAction->execute($editDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(Category $category, DestroyAction $destroyAction)
    {
        $destroyDTO = new DestroyDTO($category);

        $result = $destroyAction->execute($destroyDTO);

        if ($result->getException() instanceof \Throwable) {
            throw $result->getException();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
