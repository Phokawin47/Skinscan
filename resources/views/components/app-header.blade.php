<header class="header">
    <div class="container">
        <div class="nav-wrapper">
            <!-- ซ้าย: โลโก้ -->
            <a href="{{ route('home.idx') }}" class="logo">
                <div class="logo-icon">
                    <img src="{{ URL::asset('image/Acne.png') }}" alt="AcneScan Logo" class="footer-logo-img">
                </div>
                <span class="logo-text">SkinScan</span>
            </a>

            <!-- กลาง: เมนูหลัก -->
            <nav class="nav-desktop">
                <a href="{{ route('home.idx') }}" class="nav-link {{ request()->routeIs('home.idx') ? 'active' : '' }}">Home</a>
                <a href="{{ route('anceinfomation.idx') }}" class="nav-link {{ request()->routeIs('anceinfomation.idx') ? 'active' : '' }}">Acne Info</a>
                <a href="{{ route('facescan.idx') }}" class="nav-link {{ request()->routeIs('facescan.idx') ? 'active' : '' }}">Face Scan</a>
                <a href="{{ route('search') }}" class="nav-link {{ request()->routeIs('search') ? 'active' : '' }}">Search Product</a>
                <a href="{{ route('aboutus.idx') }}" class="nav-link {{ request()->routeIs('aboutus.idx') ? 'active' : '' }}">About Us</a>
            </nav>

            <!-- ขวา: ปุ่ม Scan + โปรไฟล์ -->
            <div class="nav-actions">
                <a href="{{ route('facescan.idx') }}" class="cta-button">
                    <i class="fas fa-camera"></i><span>Scan Now</span>
                </a>

                {{-- ยังไม่ล็อกอิน --}}
                @guest
                    <a href="{{ route('login') }}" class="btn-primary btn-sm">
                        <i class="fa-solid fa-user"></i><span>Login / Sign up</span>
                    </a>
                @endguest

                {{-- ล็อกอินแล้ว --}}
                @auth
                    <div class="ms-3 relative z-50">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}"
                                             alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                                            {{ Auth::user()->first_name.' '.Auth::user()->last_name }}
                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                                <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>

                                {{-- ===== Admin (เฉพาะ role: admin) ===== --}}
                                @if(auth()->user()->hasRole('admin'))
                                    <div class="border-t border-gray-200"></div>
                                    <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>
                                    <x-dropdown-link href="{{ route('admin.users.index') }}">Users</x-dropdown-link>
                                    {{-- เพิ่มเมนูแอดมินอื่น ๆ ได้ที่นี่ --}}
                                @endif

                                {{-- ===== Product Management (admin & product_manager) ===== --}}
                                @if(auth()->user()->hasRole(['product_manager','admin']))
                                    <div class="border-t border-gray-200"></div>
                                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Product Management') }}</div>
                                    <x-dropdown-link href="{{ route('product_management.create') }}">{{ __('Manage') }}</x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

                <!-- ปุ่มเมนูมือถือ -->
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- เมนูมือถือ -->
        <nav class="nav-mobile" id="mobileNav">
            <a href="{{ route('home.idx') }}" class="nav-link-mobile">Home</a>
            <a href="{{ route('anceinfomation.idx') }}" class="nav-link-mobile">Acne Info</a>
            <a href="{{ route('facescan.idx') }}" class="nav-link-mobile">Face Scan</a>
            <a href="{{ route('aboutus.idx') }}" class="nav-link-mobile">About Us</a>
            <a href="{{ route('facescan.idx') }}" class="cta-button-mobile">
                <i class="fas fa-camera"></i><span>Scan Now</span>
            </a>
        </nav>
    </div>
</header>

{{-- สคริปต์ toggle (ย้ายไป app.js ก็ได้) --}}
<script>
    window.toggleMobileMenu = function() {
        const el = document.getElementById('mobileNav');
        if (!el) return;
        el.style.display = (el.style.display === 'block') ? 'none' : 'block';
    }
</script>
