<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pets.index');
});

Route::get('/create', function () {
    return view('pets.create');
});
