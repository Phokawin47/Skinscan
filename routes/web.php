<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProductController;

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

/*
|--------------------------------------------------------------------------
| Skinscan (ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/
Route::middleware($authStack)->group(function () {

    // โฮม
    Route::get('/Skinscan/home', fn () => view('home'))->name('home.idx');

    // ชอร์ตคัท /Skinscan -> /Skinscan/home
    Route::get('/Skinscan', fn () => redirect()->route('home.idx'))->name('redirect.idx');

    // หน้าอื่น ๆ
    Route::get('/Skinscan/anceinfomation', fn () => view('anceinfomation'))->name('anceinfomation.idx');
    Route::get('/Skinscan/facescan', fn () => view('facescan'))->name('facescan.idx');
    Route::get('/Skinscan/aboutus', fn () => view('aboutus'))->name('aboutus.idx');

    // Search (คงทั้ง 2 เส้นทางไว้ตามที่มี)
    Route::get('/Skinscan/search', [ProductController::class, 'index'])->name('search');
    Route::get('/search', [ProductController::class, 'index'])->name('products.search');

    /*
    |----------------------------------------------------------------------
    | Product Management (หลังบ้าน) — จำกัดสิทธิ์ product_manager หรือ admin
    | ใช้ middleware 'role' จากที่สร้างไว้: EnsureUserHasRole
    |----------------------------------------------------------------------
    */
    Route::prefix('/Skinscan/product_management')
        ->middleware('role:product_manager,admin')
        ->group(function () {
            // index -> redirect ไปหน้า create (ตามพฤติกรรมเดิม แต่แก้ให้ถูก)
            Route::get('/', fn () => redirect()->route('product_management.create'))
                ->name('product_management.idx');

            // create (แสดงฟอร์ม)
            Route::get('/create', fn () => view('product_management_create'))
                ->name('product_management.create');

            // store (บันทึกสินค้าใหม่)
            Route::post('/', [ProductController::class, 'store'])->name('product.store');

            // edit (หน้าฟอร์มแก้ไข)
            Route::get('/edit', [ProductController::class, 'edit'])->name('product_management.edit');

            // update / destroy (ใช้งานกับ resource ตัวเดิม)
            Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        });
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
use App\Http\Controllers\Admin\UserAdminController;

Route::middleware(['auth','role:admin'])
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users',            [UserAdminController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit',[UserAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',     [UserAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',  [UserAdminController::class, 'destroy'])->name('users.destroy'); // ถ้าต้องการลบ
    });
