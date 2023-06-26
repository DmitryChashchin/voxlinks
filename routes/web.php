<?php

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('todos')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/{todo}', [TodoController::class, 'show'])->name('todo.show');
    Route::post('/', [TodoController::class, 'store'])->name('todo.store');
    Route::put('/{customer}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/{customer}', [TodoController::class, 'destroy'])->name('todo.destroy');
});

Route::get('/tags', function () {
    $tags = Tag::all();
    return response()->json($tags);
})->name('tags.index');




