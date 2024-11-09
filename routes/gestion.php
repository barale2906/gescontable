<?php

use Illuminate\Support\Facades\Route;

Route::get('/clientes', function () {
            return view('index.gestion.clientes');
        })->middleware('can:cl_clientes')->name('clientes');

Route::get('/proveedor', function () {
            return view('index.gestion.proveedor');
        })->middleware('can:cl_proveedor')->name('proveedor');

Route::get('/programacion', function () {
            return view('index.gestion.programacion');
        })->middleware('can:cl_programacion')->name('programacion');

Route::get('/google', function () {
            return view('index.gestion.google');
        })->middleware('can:cl_clientes')->name('google');
