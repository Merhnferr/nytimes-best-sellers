<?php

use App\Http\Controllers\v1\BestSellerController;
use Illuminate\Support\Facades\Route;

Route::get('bestSellers/history', BestSellerController::class);
