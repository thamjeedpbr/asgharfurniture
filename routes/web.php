<?php

use App\Http\Controllers\Api\GraphController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('generate-graph', [GraphController::class, 'getGraph']);
Route::get('generate-graphs', [GraphController::class, 'getGraph']);
