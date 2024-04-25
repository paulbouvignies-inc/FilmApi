<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// middleware('api') is used to apply the CheckAcceptHeader middleware to all routes in this file

Route::group(['middleware' => 'App\Http\Middleware\checkAcceptHeader'], function () {
    Route::get('/films', [FilmController::class, 'index'])->name('films.index');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store');
    Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
    Route::put('/films/{id}', [FilmController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [FilmController::class, 'destroy'])->name('films.destroy');
    Route::get('/films/{id}/categories', [FilmController::class, 'getFilmCategory'])->name('films.categories');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{id}', [CategoryController::class, 'getCatgory'])->name('categories.films');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    Route::get('/search', [SearchController::class, 'search'])->name('films.search');
});
