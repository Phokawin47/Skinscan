<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});


Route::get("/Skinscan",function(){
    return redirect('/Skinscan/home');
    })->name("redirect.idx");

Route::get("/Skinscan/home",function(){
    return view("home");
})->name("home.idx");

Route::get("/Skinscan/anceinfomation",function(){
    return view("anceinfomation");
})->name("anceinfomation.idx");

Route::get("/Skinscan/facescan",function(){
    return view("facescan");
})->name("facescan.idx");

Route::get('/Skinscan/search', [ProductController::class, 'index'])->name('search'); // replaces the closure
Route::get('/search', [ProductController::class, 'index'])->name('products.search'); // optional alias

Route::get("/Skinscan/aboutus",function(){
        return view("aboutus");
})->name("aboutus.idx");

// Fix error router product_management
Route::get("/Skinscan/product_management", function(){
    return redirect('/Skinscan/product_management/create'); view("product_management_create");
})->name("product_management.idx");

// Product Management Create
Route::get("/Skinscan/product_management/create", function(){
        return view("product_management_create");
})->name("product_management_creat.idx");
Route::post('/product', [ProductController::class, 'store'])->name('product.store');


// Product Management Edit
Route::get('/Skinscan/product_management/edit', [ProductController::class, 'edit'])->name('product_management_edit.idx');
Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');

Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // <-- เพิ่มบรรทัดนี้

// Scan section


