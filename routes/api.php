<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Crée un lien qui permettra aux clients : React, Vue, Angular, Node, etc... afin d'avoir acces a cette fonctionnalité

//récuperer la list des posts
Route::get('posts', [PostController::class, 'index']);

<<<<<<< HEAD
=======
//ajouter un post | POST | PUT | PATCH

Route::delete('posts/{post}', [PostController::class, 'delete']);

>>>>>>> 06a8c80c1742b3f51e74f4dce9295a631c3da9fd
Route::post('/register',[UserController::class, 'register']);
route::post('/login',[UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

<<<<<<< HEAD
    //CRUD
=======
>>>>>>> 06a8c80c1742b3f51e74f4dce9295a631c3da9fd
    Route::post('posts/create', [PostController::class, 'store']);
    Route::put('posts/edit/{id}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'delete']);

    Route::put('posts/edit/{id}', [PostController::class, 'update']);

    Route::get('/user', function(Request $request){
        return $request->user();
    });
});


