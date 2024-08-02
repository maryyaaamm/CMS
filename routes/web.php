<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PostController::class, 'welcome']);
Route::middleware('auth')->prefix('admin')->group(function() {
    Route::get('users', [UserController::class, 'index'])->name('posts.manageuser');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
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
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
    Route::get('/feed', [PostController::class, 'feed'])->name('posts.feed');

});
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

require __DIR__.'/auth.php';
