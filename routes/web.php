<?php

use App\Http\Controllers\LidController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',[LidController::class, 'create'])->name('lid.add');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/lids',[LidController::class, 'index'])->name('lid.index');
    Route::get('/lids/edit/{id}',[LidController::class, 'edit']);
    Route::patch('/lid/edit/status',[LidController::class, 'editStatus']);
    Route::post('/lid/store',[LidController::class, 'store'])->name('lid.store');
    Route::patch('/lid/update/{id}',[LidController::class, 'update']);
    Route::delete('/lid/delete/{id}',[LidController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
