<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use GuzzleHttp\Middleware;

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

//All job listing
Route::get('/', [ListingController::class, 'index']);

//show create job form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store job Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show Edit file
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update job listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete job
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show the website register form
Route::get('/register', [UserController::class, 'create'])->Middleware('guest');

// create new user
Route::post('/users', [UserController::class, 'store']);

// log userout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//login form
Route::get('/login', [UserController::class, 'login'])->name('login')->Middleware('guest');

//login the user
Route::post('/users/auth', [UserController::class, 'auth']);

//Manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->Middleware('auth');
