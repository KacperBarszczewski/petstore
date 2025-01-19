<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetController::class, 'index'])->name('pets.index');
Route::get('/create', [PetController::class, 'create'])->name('pets.create');
Route::get('pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');

Route::delete('/pets/{id}', [PetController::class, 'delete'])->name('pets.delete');
Route::post('/store', [PetController::class, 'store'])->name('pets.store');
Route::put('pets/{id}', [PetController::class, 'update'])->name('pets.update');
