<?php

use Illuminate\Support\Facades\Route;

Route::get('/roles', function () {
            return view('index.configuracion.roles');
        })->middleware('can:cf_roles')->name('roles');

Route::get('/users', function () {
            return view('index.configuracion.users');
        })->middleware('can:cf_users')->name('users');

Route::get('/params', function () {
            return view('index.configuracion.params');
        })->middleware('can:cf_params')->name('params');
