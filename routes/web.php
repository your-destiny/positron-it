<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FeedbackController;
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


Route::get('/', [CategoriesController::class, 'index'])->name('categories');

Route::get('category/{category}', [CategoriesController::class, 'show'])->name('category');

Route::get('book/{book}', [BookController::class, 'show'])->name('book');

Route::get('/feedback', [FeedbackController::class, 'create'])
     ->name('feedback');

Route::post('/feedback', [FeedbackController::class, 'store']);
