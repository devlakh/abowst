<?php

use App\Http\Controllers\AcademicWorkController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/work/grabCardsPartial', [AcademicWorkController::class, "grabCardsPartial"])->name("work.grabCardsPartial");
Route::post('/search/query', [SearchController::class, "query"])->name("search.query");

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
