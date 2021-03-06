<?php

use App\Http\Controllers\MealFavoriteController;
use App\Http\Controllers\MealRemoveFavoriteController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/search', SearchController::class)->name('search');
    Route::post('/search', SearchController::class);

    Route::group(['prefix' => 'meals', 'as' => 'meals.'], function (): void {
        Route::post('{mealId}/favorite', MealFavoriteController::class)->name('favorite');
        Route::delete('{mealId}/favorite', MealRemoveFavoriteController::class);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
