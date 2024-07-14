<?php

use Illuminate\Support\Facades\Route;

Route::get('/clientes', function () {
            return view('index.cliente.clientes');
        })->middleware('can:cl_clientes')->name('clientes');

Route::get('/calendario', function () {
            return view('index.cliente.calendario');
        })->middleware('can:cl_calendario')->name('calendario');

Route::get('/programacion', function () {
            return view('index.cliente.programacion');
        })->middleware('can:cl_programacion')->name('programacion');
