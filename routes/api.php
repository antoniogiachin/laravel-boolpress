<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// api verra chiamata alla rotta /api/posts -> stessa rotta che do ad axios
Route::get('/posts', 'Api\PostController@index');

//alla chiamata di post/{slug} dinamico viene richiamata la rotta
Route::get('/posts/{slug}', 'Api\PostController@show');

//rotta per chiamata post legati a categoria
Route::get('/category/{id}', 'Api\CategoryController@show');

// rotta post per contact
Route::post('/contacts', 'Api\ContactController@store');
