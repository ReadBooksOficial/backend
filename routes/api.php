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
Route::post('/user/register', [UserApiController::class, 'register']);

Route::get('/user/books/{id}', [LivroApiController::class, 'getBooksByUserId']);

Route::get('/google-books/by-name/{name}', [GoogleBookApiController::class, 'getBooksByName']);
