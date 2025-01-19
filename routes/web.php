<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetController::class, 'index'])->name('pets.index');

Route::get('/create', [PetController::class, 'create']);
Route::delete('/pets/{id}', [PetController::class, 'delete'])->name('pets.delete');;