<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if($this->app->environment('production')) {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/#home', function () {
    return view('welcome');
})->name('home');

Route::get('/#about', function () {
    return view('welcome');
})->name('about');

Route::get('/#services', function () {
    return view('welcome');
})->name('services');

Route::get('/#portfolio', function () {
    return view('welcome');
})->name('portfolio');

Route::get('/#team', function () {
    return view('welcome');
})->name('team');

Route::get('/#contact', function () {
    return view('welcome');
})->name('contact');

Route::get('/guest', [App\Http\Controllers\ContactController::class, 'index'])->name('guest.index')->secure();
Route::post('/guest', [App\Http\Controllers\ContactController::class, 'store'])->name('guest.store')->secure();
