<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// ⬇️ เพิ่ม use ให้มิดเดิลแวร์ของคุณ
use App\Http\Middleware\EnsureUserHasRole;
// (ถ้ามีอันอื่น เช่น EnsureProfileCompleted ก็ use ได้)
// use App\Http\Middleware\EnsureProfileCompleted;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->web(append: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    ->withMiddleware(function (Middleware $middleware) {
        // ⬇️ สร้าง alias สำหรับเรียกใช้ใน routes ->middleware('role:...')
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
            // 'profile.completed' => EnsureProfileCompleted::class, // ถ้ามี
        ]);

        // ตัวอย่างถ้าอยากผูกเข้ากลุ่ม web อัตโนมัติ:
        // $middleware->appendToGroup('web', EnsureProfileCompleted::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
