<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::post('posts/{post}/disapprove', [PostController::class, 'disapprove'])->name('posts.disapprove');
    Route::resource('posts', PostController::class);
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

});
require __DIR__.'/auth.php';
