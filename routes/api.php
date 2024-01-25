<?php

use Illuminate\Support\Facades\Route;


// ========== controllers ============ //
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;

// ========== controllers ============ //


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Public Routes Started (No authentication required)
Route::post('/Register', [UserController::class, 'register']);

Route::post('/Login', [UserController::class, 'login']);

Route::post('/sent-reset-password-email', [PasswordResetController::class, 'sent_reset_password_email']);

Route::post('/Reset-Password/{token}', [PasswordResetController::class, 'ResetPassword']);


// Public Routes Ended (No authentication required)



// Partially Protected Routes Started
// Retrieve all blogs
Route::get('/Blogs', [BlogController::class, 'index']);

// Retrieve a specific blog by ID
Route::get('/Blogs/{id}', [BlogController::class, 'show']);

// Search for blog posts by author's name
Route::get('Search/{author}', [BlogController::class, 'search']);
// Partially Protected Routes Ended






// Protected Routes (Require authentication via Sanctum middleware)
Route::middleware(['auth:sanctum'])->group(function () {

    // Create a new blog post
    Route::post('Create', [BlogController::class, 'store']);

    // Update an existing blog post by ID
    Route::put('Update/{id}', [BlogController::class, 'update']);

    // Delete a blog post by ID
    Route::delete('Delete/{id}', [BlogController::class, 'destroy']);

    // User Profile 
    Route::get('Profile', [UserController::class, 'logged_user']);

    //Change Password
    Route::post('ChangePassword', [UserController::class, 'change_password']);

    // Logout
    Route::post('/Logout', [UserController::class, 'logout']);
});

// Protected Routes (Require authentication via Sanctum middleware)