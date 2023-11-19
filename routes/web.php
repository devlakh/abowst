<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AcademicWorkController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingController::class, "splash"])->name("landing.splash");
Route::get('/about', [LandingController::class, "about"])->name("landing.about");
Route::get('/contact', [LandingController::class, "contact"])->name("landing.contact");

Route::get('/login', [UserController::class, "login_page"])->name("user.login_page");
Route::post('/login', [UserController::class, "login"])->name("user.login");
Route::get('/logout', [UserController::class, "logout"])->name("user.logout");


Route::resource("work", AcademicWorkController::class);

Route::get('/results', [SearchController::class, "results"])->name("search.results");
