<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\PromosController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\AboutUsController::class, 'index'])->name('about-us');
Route::post('/about-us/upload', [App\Http\Controllers\AboutUsController::class, 'addAboutUsImage']);
Route::delete('/about-us/delete/{id}', [AboutUsController::class, 'deleteAboutUsImage']);
Route::get('/about-us/images', [AboutUsController::class, 'getUploadedImages']);
Route::post('/about-us/content', [App\Http\Controllers\AboutUsController::class, 'updateAboutUsContent']);
Route::get('/about-us/get-content', [App\Http\Controllers\AboutUsController::class, 'getContent']);
Route::resource('promos', PromosController::class)->names('promos');

