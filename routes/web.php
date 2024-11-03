<?php

use App\Http\Controllers\AddressController;
use App\Http\Middleware\OtpVerified;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('login');
    });

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/otp-verified', function (Request $request) {
        $request->session()->put('otp_verified', true);
        return response()->json(['success' => true]);
    });

    Route::match(['get', 'post'], '/index', [AddressController::class, 'index'])
        ->middleware(OtpVerified::class);
    Route::post('/index/create', [AddressController::class, 'storeAddress'])
        ->middleware(OtpVerified::class);
});
