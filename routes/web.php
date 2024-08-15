<?php

use Illuminate\Support\Facades\Route;

Route::get('/{vue_route?}', function () {
    return view('app');
})->where('vue_route', '[\/\w\.-]*');
