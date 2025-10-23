<?php

use App\Http\Middleware\EnsureWebAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\ChuTroController;
use App\Http\Controllers\ChuTro\ProfileController;
use App\Http\Controllers\Tenant\TenantDashboardController;
use App\Http\Controllers\Tenant\TenantInvoiceController;
use App\Http\Controllers\Tenant\TenantPaymentController;
use App\Http\Controllers\Tenant\TenantProfileController;

/*
|--------------------------------------------------------------------------
| 🌐 PUBLIC ROUTES (Trang công khai)
|--------------------------------------------------------------------------
| Trang chủ, danh sách bài đăng, chi tiết phòng
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('khach-thue.dashboard'));
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/bai-dang', [PublicController::class, 'listing'])->name('listing');
Route::get('/bai-dang/{id}', [PublicController::class, 'detail'])->name('room.detail');


/*
|--------------------------------------------------------------------------
| 👤 AUTH ROUTES (Đăng nhập / Đăng ký / Đăng xuất)
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');


Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);

Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 🏠 CHỦ TRỌ (OWNER PANEL)
|--------------------------------------------------------------------------
| Các route dành riêng cho chủ trọ — yêu cầu đăng nhập
|--------------------------------------------------------------------------
*/
Route::middleware([EnsureWebAuthenticated::class])
    ->prefix('chu-tro')
    ->name('chu-tro.')
    ->group(function () {
        Route::redirect('/', '/chu-tro/dashboard')->name('index');

        Route::get('/dashboard', [ChuTroController::class, 'dashboard'])->name('dashboard');

        // Alias để home.blade.php không lỗi
        Route::get('/create', fn() => redirect()->route('chu-tro.bai-dang.create'))->name('create');

        // CRUD Bài đăng
        Route::get('/bai-dang', [ChuTroController::class, 'index'])->name('bai-dang.index');
        Route::get('/bai-dang/tao', [ChuTroController::class, 'create'])->name('bai-dang.create');
        Route::post('/bai-dang', [ChuTroController::class, 'store'])->name('bai-dang.store');

        Route::get('/bai-dang/{id}/sua', [ChuTroController::class, 'edit'])->name('bai-dang.edit');
        Route::put('/bai-dang/{id}', [ChuTroController::class, 'update'])->name('bai-dang.update');
        Route::delete('/bai-dang/{id}', [ChuTroController::class, 'destroy'])->name('bai-dang.destroy');

        // Ảnh bài đăng
        Route::post('/bai-dang/{id}/anh', [ChuTroController::class, 'upload'])->name('bai-dang.upload');

        /*
        |--------------------------------------------------------------------------
        | 👤 HỒ SƠ CÁ NHÂN
        |--------------------------------------------------------------------------
        */
        Route::get('/ho-so', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/ho-so', [ProfileController::class, 'update'])->name('profile.update');
    });



/*
|--------------------------------------------------------------------------
| 🧍 KHÁCH THUÊ (TENANT PANEL)
|--------------------------------------------------------------------------
*/
Route::middleware([EnsureWebAuthenticated::class])
    ->prefix('khach-thue')
    ->name('khach-thue.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('khachthue.dashboard'))->name('dashboard');

        // === Hóa đơn / Thanh toán của Khách thuê ===
        Route::get('/hoa-don',            [TenantPayment::class, 'index'])->name('payments.index'); // dùng bởi invoices.blade.php
        Route::get('/hoa-don/{id}',       [TenantPayment::class, 'show'])->name('payments.show');   // dùng bởi invoices.blade.php
        Route::post('/hoa-don/{id}/pay',  [TenantPayment::class, 'pay'])->name('payments.pay');     // dùng bởi payments.blade.php (nút "Thanh toán ngay")
    });

/*
|--------------------------------------------------------------------------
| 🧑‍💼 ADMIN DASHBOARD (tùy chọn)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    });
