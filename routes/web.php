<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BuySellController;

// -----------------------------------------------
// Public Routes
// -----------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// -----------------------------------------------
// Authenticated Routes
// -----------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Shop Selection
    Route::get('/shop/select', [ShopController::class, 'select'])->name('shop.select');
    Route::post('/shop/switch', [ShopController::class, 'switch'])->name('shop.switch');
});

// -----------------------------------------------
// Staff & Above
// -----------------------------------------------
Route::middleware(['auth', 'role:staff|shop_admin|super_admin'])->group(function () {
  // ── Sales History ─────────────────────────────
Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/',              [SaleController::class, 'index'])->name('index');
    Route::get('/{sale}/receipt',[SaleController::class, 'receipt'])->name('receipt');
    Route::post('/{sale}/email', [SaleController::class, 'emailReceipt'])->name('email-receipt');
});

// ── POS ───────────────────────────────────────
Route::prefix('pos')->name('pos.')->group(function () {
    Route::get('/',              [SaleController::class, 'pos'])->name('index');
    Route::post('/',             [SaleController::class, 'store'])->name('store');
    Route::get('/{sale}/summary',[SaleController::class, 'summary'])->name('summary');
});

// ── Repairs ───────────────────────────────────
Route::prefix('repairs')->name('repairs.')->group(function () {
    Route::get('/',                    [RepairController::class, 'index'])->name('index');
    Route::get('/create',              [RepairController::class, 'create'])->name('create');
    Route::post('/',                   [RepairController::class, 'store'])->name('store');
    Route::get('/warranty-search',     [RepairController::class, 'warrantySearch'])->name('warranty-search');
    Route::get('/{repair}',            [RepairController::class, 'show'])->name('show');
    Route::get('/{repair}/edit',       [RepairController::class, 'edit'])->name('edit');
    Route::put('/{repair}',            [RepairController::class, 'update'])->name('update');
    Route::delete('/{repair}',         [RepairController::class, 'destroy'])->name('destroy');
    Route::get('/{repair}/receipt',    [RepairController::class, 'receipt'])->name('receipt');
    Route::post('/{repair}/email',     [RepairController::class, 'emailReceipt'])->name('email-receipt');
    Route::post('/{repair}/payment',   [RepairController::class, 'addPayment'])->name('add-payment');
    Route::delete('/{repair}/payment/{payment}', [RepairController::class, 'deletePayment'])->name('delete-payment');
    Route::patch('/{repair}/status',   [RepairController::class, 'updateStatus'])->name('update-status');
    Route::patch('/{repair}/device/{device}/status', [RepairController::class, 'updateDeviceStatus'])->name('update-device-status');
});
    // ── AJAX — Products & Categories ─────────────



    Route::prefix('api')->group(function () {

    Route::get('/categories',  [ProductController::class, 'categories'])->name('categories.search');
    Route::get('/brands',      [ProductController::class, 'brands'])->name('brands.filter');
    Route::get('/products',    [ProductController::class, 'search'])->name('products.search');

    Route::get('/customers/search',           [CustomerController::class, 'search'])->name('customers.search');
    Route::get('/customers/{customer}/stats', [CustomerController::class, 'stats'])->name('customers.stats');
    Route::post('/customers',                 [CustomerController::class, 'store'])->name('customers.store');

    // ── Vouchers AJAX ─────────────────────────
    Route::post('/vouchers/validate', [VoucherController::class, 'validateVoucher'])->name('vouchers.validate');
    Route::get('/vouchers',           [VoucherController::class, 'list'])->name('vouchers.list');
    // ── Repair Types AJAX ─────────────────────────
Route::get('/repair-types',  [RepairController::class, 'repairTypes'])->name('repair-types.search');
Route::get('/products/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
    Route::get('/products',              [ProductController::class, 'search'])->name('products.search');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
});



    // ── Customers ─────────────────────────────────
    Route::get('/customers',              [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}',   [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{customer}',[CustomerController::class, 'destroy'])->name('customers.destroy');

    // ── Buy & Sell (placeholder) ──────────────────
    // ── Buy & Sell ────────────────────────────────────
    Route::get('/buy-sell',                        [BuySellController::class, 'index'])->name('buy-sell.index');
    Route::get('/buy-sell/create',                 [BuySellController::class, 'create'])->name('buy-sell.create');
    Route::post('/buy-sell/buy',                   [BuySellController::class, 'buy'])->name('buy-sell.buy');
    Route::get('/buy-sell/{device}/sell',          [BuySellController::class, 'sellPage'])->name('buy-sell.sell-page');
    Route::post('/buy-sell/{device}/sell',         [BuySellController::class, 'sell'])->name('buy-sell.sell');
    Route::delete('/buy-sell/{device}',            [BuySellController::class, 'destroy'])->name('buy-sell.destroy');
});

// -----------------------------------------------
// Shop Admin & Above
// -----------------------------------------------
Route::middleware(['auth', 'role:shop_admin|super_admin'])->group(function () {
    Route::get('/products',               [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/report',         [ProductController::class, 'report'])->name('products.report');
    Route::get('/products/create',         [ProductController::class, 'create'])->name('products.create');
    Route::post('/products',               [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',      [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',   [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/vouchers', function () {
        return view('dashboard');
    })->name('vouchers.index');

    Route::get('/settings', function () {
        return view('dashboard');
    })->name('settings.index');

    Route::get('/reports', function () {
        return view('dashboard');
    })->name('reports.index');

    // ── Categories ────────────────────────────────
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/',                  [CategoryController::class, 'index'])->name('index');
    Route::get('/create',            [CategoryController::class, 'create'])->name('create');
    Route::post('/',                 [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}/edit',   [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}',        [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}',     [CategoryController::class, 'destroy'])->name('destroy');
});

// ── Brands ────────────────────────────────────
Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/',              [BrandController::class, 'index'])->name('index');
    Route::get('/create',        [BrandController::class, 'create'])->name('create');
    Route::post('/',             [BrandController::class, 'store'])->name('store');
    Route::get('/{brand}/edit',  [BrandController::class, 'edit'])->name('edit');
    Route::put('/{brand}',       [BrandController::class, 'update'])->name('update');
    Route::delete('/{brand}',    [BrandController::class, 'destroy'])->name('destroy');
});

    // ── Vouchers ──────────────────────────────────
Route::prefix('vouchers')->name('vouchers.')->group(function () {
    Route::get('/',                [VoucherController::class, 'index'])->name('index');
    Route::get('/create',          [VoucherController::class, 'create'])->name('create');
    Route::post('/',               [VoucherController::class, 'store'])->name('store');
    Route::get('/{voucher}/edit',  [VoucherController::class, 'edit'])->name('edit');
    Route::put('/{voucher}',       [VoucherController::class, 'update'])->name('update');
    Route::delete('/{voucher}',    [VoucherController::class, 'destroy'])->name('destroy');
    Route::get('/{voucher}/print',  [VoucherController::class, 'printVoucher'])->name('print');
    Route::post('/{voucher}/email', [VoucherController::class, 'emailVoucher'])->name('email');
});


// ── Products ──────────────────────────────────
// ── Products ──────────────────────────────────
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',                        [ProductController::class, 'index'])->name('index');
    Route::get('/create',                  [ProductController::class, 'create'])->name('create');
    Route::post('/',                       [ProductController::class, 'store'])->name('store');
    Route::get('/stock',                   [StockController::class,   'index'])->name('stock');
    Route::get('/report',                  [ProductController::class, 'report'])->name('report');
    Route::get('/autocomplete',            [ProductController::class, 'autocomplete'])->name('autocomplete');
    Route::get('/{product}/edit',          [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}',               [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}',            [ProductController::class, 'destroy'])->name('destroy');
    Route::post('/{product}/topup',        [StockController::class,   'topup'])->name('topup');
    Route::get('/{product}/movements',     [StockController::class,   'movements'])->name('movements');
});


});

// -----------------------------------------------
// Super Admin Only
// -----------------------------------------------
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // ── Shops ─────────────────────────────────────────────
    Route::get('/shops',                          [ShopController::class, 'index'])->name('shops.index');
    Route::get('/shops/create',                   [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops',                         [ShopController::class, 'store'])->name('shops.store');
    Route::get('/shops/{shop}',                   [ShopController::class, 'show'])->name('shops.show');
    Route::get('/shops/{shop}/edit',              [ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/shops/{shop}',                   [ShopController::class, 'update'])->name('shops.update');
    Route::delete('/shops/{shop}',                [ShopController::class, 'destroy'])->name('shops.destroy');
    Route::post('/shops/{shop}/assign-user',      [ShopController::class, 'assignUser'])->name('shops.assign.user');
    Route::delete('/shops/{shop}/users/{user}',   [ShopController::class, 'removeUser'])->name('shops.remove.user');

    // ── Users ─────────────────────────────────────────────
    Route::get('/users',                          [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create',                   [UserController::class, 'create'])->name('users.create');
    Route::post('/users',                         [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',              [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',                   [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',                [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users_stub', function () {
        return view('dashboard');
    })->name('users.index');
});

require __DIR__ . '/auth.php';