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

Route::get("/Skinscan/search",function(){
        return view("search");
})->name("search.idx");

Route::get("/Skinscan/aboutus",function(){
        return view("aboutus");
})->name("aboutus.idx");

Route::get('/Skinscan/search', [ProductController::class, 'index'])->name('search.idx');
