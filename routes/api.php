<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // panggil AuthController
use App\Http\Controllers\AdminController; //panggil AdminController
use App\Http\Controllers\UserController; //panggil UserController
use App\Http\Controllers\RecipeController; //panggil RecipeController

// guest route
Route::post('register', [AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('recipes',[RecipeController::class,'show_recipes']);
Route::post('recipes/get-recipe',[RecipeController::class,'recipe_by_id']);
Route::post('recipes/rating',[RecipeController::class,'rating']);

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// admin route
// route untuk admin, dimana terdapat middleware admin juga prefix awalan url "admin"

Route::middleware(['admin.api'])->prefix('admin')->group(function() {

    Route::get('dashboard',[AdminController::class,'dashboard']);

    Route::post('register',[AdminController::class,'register']);
    Route::get('register',[AdminController::class,'show_register']);
    Route::get('register/{id}',[AdminController::class,'show_register_by_id']);
    Route::put('register/{id}',[AdminController::class, 'update_register']);
    Route::delete('register/{id}',[AdminController::class,'delete_register']);

    Route::get('activation-account/{id}',[AdminController::class,'activation_account']);
    Route::get('deactivation-account/{id}',[AdminController::class,'deactivation_account']);

    Route::post('create-recipe',[AdminController::class,'create_recipe']);
    Route::post('update-recipe/{id}',[AdminController::class,'update_recipe']);
    Route::delete('delete-recipe/{id}',[AdminController::class,'delete_recipe']);
    Route::get('publish/{id}',[AdminController::class,'publish_recipe']);
    Route::get('unpublish/{id}',[AdminController::class,'unpublish_recipe']);
});

/**
 * user routes
 * route untuk admin, dimana terdapat middleware user dan juga prefix awalan url "user"
 */

 Route::middleware(['user.api'])->prefix('user')->group(function() {
    Route::post('submit-recipe',[UserController::class,'create_recipe']);
 });