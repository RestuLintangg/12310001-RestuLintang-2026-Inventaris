<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsExport;
use App\Exports\UserAdminsExport;
use App\Exports\LendingsExport;
use App\Exports\UserStaffsExport;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('layout');
})->name('layout');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/dashboard', [Controller::class, 'landing'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group( function() {
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::patch('/update/{id}', [CategoryController::class, 'update'])->name('update');
    });

    Route::get('/items/export', function () {
        return Excel::download(new ItemsExport, 'items.xlsx');
    })->name('items.export');

    Route::prefix('/items')->name('items.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::post('/', [ItemController::class, 'store'])->name('store');
        Route::patch('/update/{id}', [ItemController::class, 'update'])->name('update');
    });

    Route::get('/users/admin/export', function () {
        return Excel::download(new UserAdminsExport, 'user_admins.xlsx');
    })->name('user.admin.export');

    Route::get('/users/staff/export', function () {
        return Excel::download(new UserStaffsExport, 'user_staffs.xlsx');
    })->name('user.staff.export');

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
        Route::get('/staff', [UserController::class, 'staffIndex'])->name('staff.index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/reset/{id}', [UserController::class, 'reset'])->name('reset');
    });
});

Route::middleware(['auth', 'role:staff'])->group( function() {
    Route::get('/lendings/export', function () {
        return Excel::download(new LendingsExport, 'lendings.xlsx');
    })->name('lendings.export');

    Route::prefix('lendings')->name('lendings.')->group(function () {
        Route::get('/', [App\Http\Controllers\LendingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\LendingController::class, 'store'])->name('store');
        Route::patch('/lendings/return-item/{id}', [App\Http\Controllers\LendingController::class, 'returnItem'])->name('returnItem');    });

    Route::prefix('/items/staff')->name('items.staff.')->group(function () {
        Route::get('/', [ItemController::class, 'staffIndex'])->name('index');
    });

    Route::prefix('/users/staffs')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'staffsIndex'])->name('staffs.index');
    });
});