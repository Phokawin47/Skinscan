<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\UserAdminController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Auth + Jetstream stack (สำหรับหน้าหลังล็อกอินทั่วไป)
|--------------------------------------------------------------------------
*/
$authStack = [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
];

/*
|--------------------------------------------------------------------------
| Onboarding (ต้องล็อกอินก่อน แต่ยกเว้นหน้าปกติอื่น ๆ)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
});

Route::middleware([
    'auth:sanctum', // หรือ 'auth' เฉยๆ หากไม่ได้ใช้ Sanctum
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // **ย้ายเส้นทาง Product Management เข้ามาในกลุ่มนี้**

});

/*
|--------------------------------------------------------------------------
| Skinscan (Public)
|--------------------------------------------------------------------------
*/
Route::get('/Skinscan/home', fn () => view('home'))->name('home.idx');
Route::get('/Skinscan', fn () => redirect()->route('home.idx'))->name('redirect.idx');
Route::get('/Skinscan/anceinfomation', fn () => view('anceinfomation'))->name('anceinfomation.idx');
Route::get('/Skinscan/facescan', fn () => view('facescan'))->name('facescan.idx');
Route::get('/Skinscan/aboutus', fn () => view('aboutus'))->name('aboutus.idx');
Route::get('/Skinscan/search', [ProductController::class, 'index'])->name('search');
Route::get('/search', [ProductController::class, 'index'])->name('products.search');

/*
|--------------------------------------------------------------------------
| Product Management (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:product_manager,admin'])
    ->prefix('/Skinscan/product_management')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('product_management.create'))->name('product_management.idx');
        Route::get('/create', [ProductController::class, 'create'])->name('product_management.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit', [ProductController::class, 'edit'])->name('product_management.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

/*
|--------------------------------------------------------------------------
| Dashboard (Jetstream default) – คงไว้กรณีอื่นใช้งาน
|--------------------------------------------------------------------------
*/
Route::middleware($authStack)->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN (หลังบ้าน) — จำกัดสิทธิ์ admin เท่านั้น
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users',            [UserAdminController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit',[UserAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',     [UserAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',  [UserAdminController::class, 'destroy'])->name('users.destroy');
    });
