<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Categorycontroller;
use App\Http\Controllers\InventController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

// Dashboard - hanya untuk user yang login
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashController::class, 'index'])->name('dashboard');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management - hanya untuk Admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});

// Product Management - untuk Manager dan Admin
Route::middleware(['auth', ManagerMiddleware::class])->group(function () {
    Route::resource('products', ProductController::class);

});

// kategori
Route::middleware('auth')->group(function () {
    Route::get('/category', [Categorycontroller::class, 'index'])->name('category');
    Route::get('/addcategory', [Categorycontroller::class, 'create'])->name('addcategory');
    Route::post('/addcategory', [Categorycontroller::class, 'store'])->name('store');
    Route::delete('/deletecategory{id}', [Categorycontroller::class, 'destroy'])->name('deletecategory');


});
//inventory
Route::middleware('auth')->group(function () {
    Route::get('/inventory', [InventController::class, 'index'])->name('invent');
    Route::put('/produk/update-all', [InventController::class, 'update'])->name('updateAll');
    Route::delete('/inventdelete{id}', [InventController::class, 'destroy'])->name('delete');

});


// Hanya include login dan logout, tanpa register
require __DIR__.'/auth.php';