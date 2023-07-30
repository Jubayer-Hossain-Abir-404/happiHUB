<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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
// public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// for admin public routes
Route::post('/admin/register', [AdminController::class, 'adminrRegister']);
Route::post('/admin/login', [AdminController::class, 'adminLogin']);


// protected routes for user
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// auth admin 
Route::group(['middleware' => ['auth:admins']], function () {
    Route::get('/user/view', [AdminController::class, 'viewUser']);
    Route::post('/user/{id}/update', [AdminController::class, 'userUpdate']);
    Route::post('/user/{id}/destroy', [AdminController::class, 'userDestroy']);
    Route::post('/admin/logout', [AdminController::class, 'adminLogout']);
    Route::post('/user/filter', [AdminController::class, 'userFilter']);
});






