<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/kak-ara', [ChatController::class, 'kakAra'])->name('chat.ara');
    Route::get('/chat/kak-reza', [ChatController::class, 'kakReza'])->name('chat.reza');
    Route::post('/chat/kak-ara/send', [ChatController::class, 'sendAra'])->name('chat.ara.send');
    Route::post('/chat/kak-reza/send', [ChatController::class, 'sendReza'])->name('chat.reza.send');
    Route::delete('/chat/kak-ara/reset', [ChatController::class, 'resetAra'])->name('chat.ara.reset');
    Route::delete('/chat/kak-reza/reset', [ChatController::class, 'resetReza'])->name('chat.reza.reset');

    Route::get('/chat/custom', [ChatController::class, 'custom'])->name('chat.custom');
    Route::post('/chat/custom/send', [ChatController::class, 'sendCustom'])->name('chat.custom.send');
    Route::delete('/chat/custom/reset', [ChatController::class, 'resetCustom'])->name('chat.custom.reset');

    Route::get('/chat/create-character', [ChatController::class, 'createCharacter'])->name('chat.create-character');
    Route::post('/chat/create-character', [ChatController::class, 'storeCharacter'])->name('chat.store-character');
    Route::put('/chat/create-character', [ChatController::class, 'updateCharacter'])->name('chat.update-character');
    Route::delete('/chat/delete-character', [ChatController::class, 'deleteCharacter'])->name('chat.delete-character');
});

require __DIR__.'/auth.php';
