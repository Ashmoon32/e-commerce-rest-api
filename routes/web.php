<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello';
});


Route::get('/love', function () {
    return view('love');
});