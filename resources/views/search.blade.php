<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Skinscan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ========== Core Layout ========== */
        .container, .max-w-6xl {
        overflow: visible !important;
        transform: none !important;
        }

        .section-products,
        .products-grid {    
        position: relative;
        overflow: visible !important;
        }

        /* ========== Card Base ========== */
        .product-card {
        position: relative;
        z-index: 0;
        overflow: visible;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        isolation: isolate; /* กัน z-index ซ้อน */
        }

        /* ป้องกันการขยาย layout */
        .product-card:hover {
        z-index: 9999;
        transform: scale(1.05);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
        }

        /* ========== Hide Default Content on Hover ========== */
        .product-body {
        transition: opacity 0.15s linear;
        }
        .product-card:hover .product-body {
        opacity: 0;
        visibility: hidden;
        }

        /* ========== Flyout Overlay (ของจริงที่ลอยขึ้นมา) ========== */
        .product-flyout {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transform: scale(0.95) translateY(10px);
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
        }

        /* ตอน hover แสดง overlay ลอยทับ */
        .product-card:hover .product-flyout {
        opacity: 1;
        transform: scale(1.1) translateY(-20px);
        pointer-events: auto;
        z-index: 200; ;
        }

        /* ========== Short Description Before Hover ========== */
        .product-desc {
        max-height: 3.6em;
        overflow: hidden;
        position: relative;
        }
        .product-desc::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 1.4em;
        background: linear-gradient(to top, #fff, transparent);
        }

        /* Hover → show full */
        .product-card:hover .product-desc {
        max-height: none;
        }
        .product-card:hover .product-desc::after {
        display: none;
        }

        /* ========== Image Zone ========== */
        .product-img {
        height: 9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        }

        .product-card img {
        transition: transform 0.25s ease;
        }
        .product-card:hover img {
        transform: scale(1.08);
        }
                /* ให้ปุ่มเพจอยู่เหนือการ์ดลอย */
        .pagination-wrap { position: relative; z-index: 500; }



    </style>

</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="nav-wrapper">
                <!-- ซ้าย: โลโก้ -->
                <a href="/Skinscan/home" class="logo">
                    <div class="logo-icon">
                    <img src="{{ URL::asset('image/Acne.png') }}" alt="AcneScan Logo" class="footer-logo-img">
                    </div>
                    <span class="logo-text">SkinScan</span>
                </a>

                <!-- กลาง: เมนูหลัก (กึ่งกลางจริง) -->
                <nav class="nav-desktop">
                    <a href="/Skinscan/home" class="nav-link">Home</a>
                    <a href="/Skinscan/anceinfomation" class="nav-link">Acne Info</a>
                    <a href="/Skinscan/facescan" class="nav-link">Face Scan</a>
                    <a href="/Skinscan/search" class="nav-link active">Search Product</a>
                    <a href="/Skinscan/aboutus" class="nav-link">About Us</a>
                </nav>

                <!-- ขวา: ปุ่ม Scan + โปรไฟล์ -->
                <div class="nav-actions">
                    <a href="/Skinscan/facescan" class="cta-button">
                        <i class="fas fa-camera"></i><span>Scan Now</span>
                    </a>

                    {{-- ยังไม่ล็อกอิน: แสดง Login / Sign up --}}
                    @guest
                        <a href="{{ route('login') }}" class="btn-primary btn-sm">
                            <i class="fa-solid fa-user"></i>
                            <span>Login / Sign up</span>
                        </a>
                    @endguest

                    @auth
                    <div class="ms-3 relative z-50">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->first_name.' '.Auth::user()->last_name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
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
                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
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

                    <!-- ปุ่มเมนูมือถือ (ซ่อนไว้บนเดสก์ท็อป) -->
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- เมนูมือถือ -->
            <nav class="nav-mobile" id="mobileNav">
            <a href="/Skinscan/home" class="nav-link-mobile">Home</a>
            <a href="/Skinscan/anceinfomation" class="nav-link-mobile">Acne Info</a>
            <a href="/Skinscan/facescan" class="nav-link-mobile">Face Scan</a>
            <a href="/Skinscan/aboutus" class="nav-link-mobile">About Us</a>
            <a href="/Skinscan/facescan" class="cta-button-mobile">
                <i class="fas fa-camera"></i><span>Scan Now</span>
            </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 md:px-6 lg:px-0 py-10">

        <!-- Page title (pill) -->
        <div class="w-full flex justify-center mb-6">
            <div class="px-6 py-2 rounded-full bg-gray-100 text-gray-800 text-sm font-semibold shadow-sm">
                Search and filter
            </div>
        </div>

        <!-- Card container -->
        <section class="rounded-3xl border border-gray-200 bg-white shadow-sm p-4 md:p-6 section-products">

            <!-- Top search bar -->
            <form method="GET" action="{{ route('search') }}" class="mb-6" id="searchForm">
            <div class="flex items-center gap-2">
                <div class="flex-1 relative">
                <input
                    name="q"                       
                    value="{{ request('q') }}"
                    placeholder="ค้นหาชื่อผลิตภัณฑ์"
                    class="w-full h-11 rounded-full border border-gray-200 pl-5 pr-24 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />

                <button type="button" id="advancedBtn"
                    class="absolute right-11 top-1/2 -translate-y-1/2 text-sm px-3 py-1 rounded-full border border-gray-300 hover:bg-gray-50">
                    Advanced
                </button>

                <button type="submit"          
                    class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full flex items-center justify-center border border-gray-300 hover:bg-gray-50">
                    <i class="fa-solid fa-magnifying-glass text-gray-600"></i>
                </button>
                </div>
            </div>

            <div id="advancedPanel" class="{{ request()->hasAny(['ingredient','acneType']) ? '' : 'hidden' }} rounded-2xl border border-gray-200 p-4 mt-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">ประเภทผิว/ความเหมาะสม (จาก suitability_info)</label>
                    <select name="acneType" class="w-full h-10 rounded-lg border border-gray-300 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">— ทุกประเภท —</option>
                    @foreach(($skinOptions ?? collect()) as $opt)
                        <option value="{{ $opt }}" @selected(request('acneType')===$opt)>{{ $opt }}</option>
                    @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">ส่วนผสม (เช่น BHA, Niacinamide)</label>
                    <input name="ingredient" value="{{ request('ingredient') }}"
                        class="w-full h-10 rounded-lg border border-gray-300 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="พิมพ์เพื่อกรองตามส่วนผสม">
                </div>

                <div class="flex items-end gap-2">
                    <a href="{{ route('search') }}"
                    class="h-10 px-4 rounded-lg border border-gray-300 hover:bg-white inline-flex items-center">ล้างตัวกรอง</a>
                    <button type="submit" class="h-10 px-4 rounded-lg bg-blue-600 text-white hover:bg-blue-700">ค้นหา</button>
                </div>
                </div>
            </div>
            </form>

            <script>
            // just toggle the advanced panel (no JSON filtering anymore)
            document.getElementById('advancedBtn')?.addEventListener('click', () => {
                document.getElementById('advancedPanel')?.classList.toggle('hidden');
            });
            </script>


                <!-- Results grid -->
            @php use Illuminate\Support\Str; @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 products-grid">
                @foreach($products as $p)
                <article class="product-card rounded-2xl border border-gray-200 p-3 md:p-4 bg-white">
                    <div class="product-body">
                    <div class="w-full product-img bg-white flex items-center justify-center rounded-xl border border-gray-100 mb-3 overflow-hidden">
                        <img src="{{ $p->image_url }}" alt="{{ $p->product_name }}" class="object-contain max-h-full"
                            onerror="this.onerror=null;this.src='{{ asset('image/placeholder.png') }}';">
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $p->product_name }}</h3>
                    <div class="text-sm text-gray-700">
                        <div class="mb-1"><span class="font-medium">ส่วนผสมเด่น:</span>
                        {{ optional($p->ingredients)->pluck('ingredient_name')->join(', ') ?? '-' }}
                        </div>
                        <div class="text-gray-600 product-desc">{{ $p->usage_details ?? '' }}</div>
                    </div>
                    </div>

                    <div class="product-flyout p-4">
                    <div class="w-full product-img bg-white flex items-center justify-center rounded-xl border border-gray-100 mb-3 overflow-hidden">
                        <img src="{{ $p->image_url }}" alt="{{ $p->product_name }}" class="object-contain max-h-full">
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">{{ $p->product_name }}</h4>
                    <p class="text-sm mb-1"><span class="font-medium">ส่วนผสมเด่น:</span>
                        {{ optional($p->ingredients)->pluck('ingredient_name')->join(', ') ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-700">{{ $p->usage_details ?? 'ไม่มีรายละเอียดเพิ่มเติม' }}</p>
                    </div>
                </article>
                @endforeach
            </div>
            @if($products->hasPages())
            <div class="mt-6 pagination-wrap">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
        </section>
    </main>

    


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <img src="{{URL::asset('image/Acne_W.png')}}" alt="AcneScan Logo" class="footer-logo-img">
                        </div>
                        <span class="logo-text">AcneScan</span>
                    </div>
                    <p>การวิเคราะห์สิวด้วย AI ขั้นสูง พร้อมคำแนะนำการดูแลผิวเฉพาะบุคคล ดูแลสุขภาพผิวของคุณด้วยเทคโนโลยีการสแกนระดับมืออาชีพ</p>
                </div>

                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="/Skinscan/home">Home</a></li>
                        <li><a href="/Skinscan/anceinfomation">Acne Info</a></li>
                        <li><a href="/Skinscan/facescan">Face Scan</a></li>
                        <li><a href="/Skinscan/aboutus">About Us</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h3>Contact</h3>
                    <div class="contact-info">
                        <p>Phokawin.s@kkumail.com</p>
                        <p>มหาวิทยาลัยขอนแก่น 123 หมู่ 16 <br>ถนนมิตรภาพ ตำบลในเมือง อำเภอเมืองขอนแก่น 40002</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 SkinScan. All rights reserved.</p>
            </div>
        </div>
    </footer>


</body>
</html>
