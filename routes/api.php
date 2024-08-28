<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\LivroApiController;
use App\Http\Controllers\Api\GoogleBookApiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserApiController::class, 'login']);
Route::post('/user', [UserApiController::class, 'register']);
Route::put('/user', [UserApiController::class, 'update'])->middleware('auth:sanctum');
Route::get('/user/books/{id}', [LivroApiController::class, 'getBooksByUserId']);

Route::get('/book/{id}', [LivroApiController::class, 'getBookById']);
Route::delete('/book/{id}', [LivroApiController::class, 'delete'])->middleware('auth:sanctum');

Route::get('/google-books/by-name/{name}', [GoogleBookApiController::class, 'getBooksByName']);
Route::get('/google-books/{id}', [GoogleBookApiController::class, 'getBookById']);
Route::get('/google-books/add-to-read/{id}', [GoogleBookApiController::class, 'addToRead'])->middleware('auth:sanctum');


Route::fallback(function(){
    return response()->json(['error' => 'Rota não encontrada.'], 404);
});

