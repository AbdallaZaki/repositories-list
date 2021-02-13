<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\V1\RepositoriesService\SearchController;

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

Route::namespace('Api\V1')->prefix('v1')->group( function () {
    Route::get('/search', [SearchController::class, 'index'])->name('search.service');
});
