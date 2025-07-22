<?php

use App\Http\Controllers\V2\BooksController;
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

Route::middleware(['check_user_token_api'])->group(function () {
    Route::group(['prefix' => 'books'], function(){
        Route::get('/', [BooksController::class, 'index']);
        Route::get('/{id}', [BooksController::class, 'getBookById']);
    });
});


// Route::post('/login', [UserApiController::class, 'login']);
// Route::post('/user', [UserApiController::class, 'register']);
// // Route::put('/user', [UserApiController::class, 'update'])->middleware('auth:api');

// Route::get('/users/pacoca/{user_name}', [LivroApiController::class, 'getBooksByUserIdToPacoca']);

// Route::group(['prefix' => 'books'], function(){
//     Route::get('/', [BooksController::class, 'index']);//deletar conta
//     Route::get('/by-user-id/{id}', [LivroApiController::class, 'getBooksByUserId']);
//     Route::get('/by-name/{name}', [LivroApiController::class, 'getBooksByName'])->middleware('auth:api', 'check_user_token');
//     Route::get('/{id}', [LivroApiController::class, 'getBookById'])->middleware('auth:api', 'check_user_token');
//     Route::delete('/{id}', [LivroApiController::class, 'delete'])->middleware('auth:api', 'check_user_token');
//     Route::patch('/{id}', [LivroApiController::class, 'update'])->middleware('auth:api', 'check_user_token');
// });

// Route::group(['prefix' => 'google-books'], function(){
//     Route::get('/by-name/{name}', [GoogleBookApiController::class, 'getBooksByName']);
//     Route::get('/{id}', [GoogleBookApiController::class, 'getBookById']);
//     Route::get('/add-to-read/{id}', [GoogleBookApiController::class, 'addToRead'])->middleware('auth:api', 'check_user_token');
// });

// Route::get('/', function(){
//     return response()->json("Ola Mundo",200);
// });


// Route::fallback(function(){
//     return response()->json(['error' => 'Rota não encontrada.'], 404);
// });

