<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ให้เพจลูกกำหนดหัวข้อเองได้: @section('title','Admin • Users') --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite (Tailwind/Jetstream etc.) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ เพจลูกสามารถ @push('styles') เพื่อใส่ Bootstrap/CDN/CSS เพิ่มได้ --}}
    @stack('styles')

    <!-- Livewire Styles -->
    @livewireStyles
  </head>

  <body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
      {{-- ถ้าไม่ต้องการเมนูของ Jetstream ให้ปิดบรรทัดด้านล่าง แล้วใช้ <x-app-header /> ของคุณ --}}
      {{-- @livewire('navigation-menu') --}}
      <x-app-header />

      <!-- Page Heading -->
      @hasSection('header')
        <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield('header')
          </div>
        </header>
      @elseif (isset($header))
        <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
          </div>
        </header>
      @endif

      <!-- Page Content -->
      <main>
        @isset($slot)
          {{-- โหมด component layout (เช่น <x-app-layout>) --}}
          {{ $slot }}
        @else
          {{-- โหมด blade layout ปกติ (เช่น @extends('layouts.app')) --}}
          @yield('content')
        @endisset
      </main>
    </div>

    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts

    {{-- ✅ เพจลูกสามารถ @push('scripts') เพื่อใส่ Bootstrap.bundle หรือ JS อื่น ๆ ได้ --}}
    @stack('scripts')
  </body>
</html>
