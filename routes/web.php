<?php

use Vendor\App\Facade\Route;

//Guest routes 
Route::get('/', 'AuthController@showLanding');
Route::middleware('isGuest')->get('/register', 'AuthController@showRegister');
Route::middleware('isGuest')->post('/register','AuthController@register');
Route::middleware('isGuest')->get('/login', 'AuthController@showLogin');
Route::middleware('isGuest')->post('/login','AuthController@login');
Route::middleware('isGuest')->get('/verify-otp', 'AuthController@showVerifyOtp');
Route::middleware('isGuest')->post('/verify-otp', 'AuthController@verifyOtp');
Route::middleware('isGuest')->post('/resend-otp', 'AuthController@resendOtp');
Route::middleware('isGuest')->get('/forgot-password', 'AuthController@showForgotPassword');
Route::middleware('isGuest')->post('/forgot-password','AuthController@forgotPassword');
Route::middleware('isGuest')->get('/reset-password', 'AuthController@showResetPassword');
Route::middleware('isGuest')->post('/reset-password', 'AuthController@resetPassword');

//Auth routes
Route::middleware('isAuth')->get('/logout', 'AuthController@logout');
Route::middleware('isAuth')->get('/dashboard', 'DashboardController@index');
Route::middleware('isAuth')->get('/profile', 'DashboardController@profile');

//Item routes
Route::middleware('isAuth')->get('/browse', 'ItemController@browse');
Route::middleware('isAuth')->get('/items', 'ItemController@myItems');
Route::middleware('isAuth')->get('/items/add', 'ItemController@showAdd');
Route::middleware('isAuth')->post('/items/add', 'ItemController@add');
Route::middleware('isAuth')->get('/items/edit/{id}', 'ItemController@showEdit');
Route::middleware('isAuth')->post('/items/edit/{id}', 'ItemController@edit');
Route::middleware('isAuth')->get('/items/view/{id}', 'ItemController@showDetails');
Route::middleware('isAuth')->post('/items/delete/{id}','ItemController@delete');

// ── Profile update ──
Route::middleware('isAuth')->post('/profile/update', 'DashboardController@updateProfile');
