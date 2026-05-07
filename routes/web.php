<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\TransactionApiController;

// ====== AUTH ======
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ====== KASIR ======
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
});

// ====== ADMIN ======
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/export/csv', [AdminController::class, 'exportCSV'])->name('admin.export.csv');
    
});

// ====== API (diakses oleh JS kasir) ======
Route::middleware(['auth'])->prefix('api')->group(function () {
    // Produk
    Route::get('/products',          [ProductApiController::class, 'index']);
    Route::post('/products',         [ProductApiController::class, 'store']);
    Route::put('/products/{id}',     [ProductApiController::class, 'update']);
    Route::post('/products/{id}/restock', [ProductApiController::class, 'restock']);

    // Transaksi
    Route::post('/transactions',     [TransactionApiController::class, 'store']);
    Route::get('/transactions',      [TransactionApiController::class, 'index']);
});

use App\Http\Controllers\AdvertisingOrderController;

Route::prefix('advertising')->name('advertising.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdvertisingOrderController::class, 'index'])->name('index');
    Route::get('/create', [AdvertisingOrderController::class, 'create'])->name('create');
    Route::post('/', [AdvertisingOrderController::class, 'store'])->name('store');
    Route::get('/{order}', [AdvertisingOrderController::class, 'show'])->name('show');
    Route::patch('/{order}/status', [AdvertisingOrderController::class, 'updateStatus'])->name('status');
    Route::get('/{order}/invoice', [AdvertisingOrderController::class, 'invoice'])->name('invoice');
});