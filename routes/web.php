<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Роуты аутентификации/авторизации пользователя
Auth::routes();

// Перенаправление на страницу входа
Route::get('/', function () {
    return redirect()->route('login');
});

// Роуты для заметок
Route::group(['prefix' => 'notes', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [NoteController::class, 'index'])->name('note.index');
    Route::get('/create', [NoteController::class, 'create'])->name('note.create');
    Route::post('/', [NoteController::class, 'store'])->name('note.store');
    Route::get('/{note}', [NoteController::class, 'show'])->name('note.show');
    Route::put('/{note}', [NoteController::class, 'update'])->name('note.update');
    Route::delete('/{note}', [NoteController::class, 'destroy'])->name('note.delete');
});


// Выход из профиля
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');




