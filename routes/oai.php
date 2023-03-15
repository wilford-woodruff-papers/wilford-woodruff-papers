<?php

/*
|--------------------------------------------------------------------------
| OAI PMH Routes
|--------------------------------------------------------------------------
|
| Here is where you can register OAI PMH routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "oai" middleware group.
|
*/

Route::get('/', \App\Http\Controllers\OAI\OaiController::class)->name('oai');
