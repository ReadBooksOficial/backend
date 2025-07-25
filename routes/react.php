<?php

use App\Http\Controllers\V2\BooksController;
use App\Http\Controllers\V2\GoogleBooksController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['check_user_token_api'])->group(function () {
    Route::group(['prefix' => 'google-books'], function(){
        Route::get('/by-name/{name}', [GoogleBooksController::class, 'getBooksByName']);
        Route::get('/{id}', [GoogleBooksController::class, 'getBookById']);
        Route::get('/add-to-read/{id}', [GoogleBooksController::class, 'addToRead'])->middleware('auth:api', 'check_user_token');
    });
});

Route::group(['prefix' => 'books'], function(){
    Route::get('/', [BooksController::class, 'index'])->middleware('check_user_token_api');
    Route::get('/{uuid}', [BooksController::class, 'find']);
    Route::post('/{uuid}', [BooksController::class, 'update'])->middleware('check_user_token_api');
    Route::delete('/{uuid}', [BooksController::class, 'delete'])->middleware('check_user_token_api');
});
