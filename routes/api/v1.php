<?php

use App\Http\Controllers\v1\BestSellerController;
use Illuminate\Support\Facades\Route;

Route::get('best-sellers/history', BestSellerController::class);
