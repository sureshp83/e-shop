<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Controller;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth::routes();

Route::post('check/unique/{table}/{column}/{id}', [Controller::class, 'checkUnique'])->name('checkUnique');

Route::prefix('admin')->group(function(){

    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('adminShowLoginForm');

    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('adminLogin');

    Route::post('login', [AdminAuthController::class,'login'])->name('adminPostLogin');

    Route::get('forgot-password', [AdminForgotPasswordController::class, 'forgotPassword'])->name('adminForgotPassword');

    Route::middleware(['auth:admin'])->group(function(){
        //Dashboard
        Route::get('dashboard', [AdminDashboardController::class,'showDashboard'])->name('adminDashboard');
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('adminLogout');
       
        // Edit profile
        
        Route::get('profile', [AdminProfileController::class, 'showProfile'])->name('editAdminProfile');
        Route::post('profile', [AdminProfileController::class, 'updateProfile'])->name('updateAdminProfile');

        // Users
        Route::resource('users', AdminUserController::class);
        Route::post('users/search', [AdminUserController::class,'search'])->name('users.search');
        Route::post('users/status/{user}', [AdminUserController::class,'changeStatus'])->name('users.status');

        // categories
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/search', [AdminCategoryController::class,'search'])->name('categories.search');
        Route::post('categories/status/{category}', [AdminCategoryController::class,'changeStatus'])->name('categories.status');

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/search', [AdminProductController::class,'search'])->name('products.search');
        Route::post('products/status/{product}', [AdminProductController::class, 'changeStatus'])->name('products.status');

    });
    

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
