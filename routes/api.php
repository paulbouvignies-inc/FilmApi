<?php

use App\Http\Controllers\FilmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// middleware('api') is used to apply the CheckAcceptHeader middleware to all routes in this file

Route::group(['middleware' => 'App\Http\Middleware\checkAcceptHeader'], function () {
    Route::get('/films', [FilmController::class, 'index'])->name('films.index');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store');
    Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
    Route::put('/films/{id}', [FilmController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [FilmController::class, 'destroy'])->name('films.destroy');
});
