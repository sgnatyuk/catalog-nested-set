<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('home', [
    'as'   => 'home',
    'uses' => Controllers\HomeController::class . '@index',
]);
Route::get('home/{category}/products', [
    'as'   => 'home.products',
    'uses' => Controllers\HomeController::class . '@getProducts',
]);

Route::apiResource('products', Controllers\ProductController::class);
Route::apiResource('categories', Controllers\CategoryController::class);

Route::post('product_images', [
    'as'   => 'product_images.upload',
    'uses' => Controllers\ProductImageUploadController::class,
]);
