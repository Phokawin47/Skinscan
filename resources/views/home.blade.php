<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Skinscan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

                    <a href="{{route('home.idx')}}" class="nav-link active">Home</a>
                    <a href="{{route('anceinfomation.idx')}}" class="nav-link">Acne Info</a>
                    <a href="{{route('facescan.idx')}}" class="nav-link">Face Scan</a>
                    <a href="{{route('search')}}" class="nav-link">Search Product</a>
                    <a href="{{route('aboutus.idx')}}" class="nav-link">About Us</a>
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
                                <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Product Management') }}</div>
                                    <x-dropdown-link href="{{ route('product_management.idx') }}">{{ __('Manage') }}</x-dropdown-link>
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
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <span class="text-primary">วิเคราะห์</span>ปัญหาสิวอย่างล้ำลึกด้วย AI

                    </h1>
                    <p class="hero-description">
                        รับการวิเคราะห์สภาพผิวของคุณด้วยเทคโนโลยี AI อัพโหลดภาพถ่ายใบหน้าของคุณ <br>เพื่อรับคำแนะนำเฉพาะบุคคล พร้อมแนวทางการดูแลรักษาที่เหมาะกับคุณที่สุด                    </p>

                    <div class="hero-buttons">
                        <a href="/Skinscan/facescan" class="btn-primary">
                            <i class="fas fa-camera"></i>
                            <span>Start Your Scan</span>
                        </a>
                        <a href="/Skinscan/anceinfomation" class="btn-secondary">
                            <span>Learn About Acne</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div class="section-header">
                    <h2>ทำไมต้องเลือก SkinScan?</h2>
                    <p>แพลตฟอร์มของเราผสานเทคโนโลยีล้ำสมัยเข้ากับความเชี่ยวชาญด้านผิวหนัง <br>เพื่อมอบการวิเคราะห์สภาพผิวที่แม่นยำและเชื่อถือได้สำหรับคุณ</p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>การสแกนด้วยระบบ AI อัจฉริยะ</h3>
                        <p>เทคโนโลยีล้ำสมัยเพื่อการวิเคราะห์สภาพผิวอย่างแม่นยำและละเอียดลึกในทุกมิติ</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>ความเป็นส่วนตัวได้รับการปกป้อง</h3>
                        <p>ภาพถ่ายของคุณเราจะไม่เก็บไว้ และข้อมูลของคุณจะถูกจัดเก็บอย่างปลอดภัย เพราะเรายึดมั่นในความเป็นส่วนตัวและการรักษาความลับของคุณเป็นสำคัญ</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>การวิเคราะห์ด้วยระบบ AI อัจฉริยะ</h3>
                        <p>รับการวิเคราะห์และคำแนะนำในระดับมืออาชีพจากผู้เชี่ยวชาญด้านผิวหนัง โดยตรงเพื่อผลลัพธ์ที่แม่นยำและเชื่อถือได้</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How to use Section -->
        <section class="features">
            <div class="container">
                <div class="section-header">
                    <h2>SkinScan ใช้งานอย่างไร ? </h2>
                    <p>วิเคราะห์สภาพผิวของคุณได้ง่าย ๆ ใน 3 ขั้นตอน</p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-1"></i>
                        </div>
                        <h3>อัปโหลดรูปใบหน้าของคุณ</h3>
                        <p>อัปโหลดภาพที่มีอยู่แล้วเพื่อเริ่มการวิเคราะห์</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-2"></i>
                        </div>
                        <h3>วิเคราะห์ด้วยระบบ AI อัจฉริยะ</h3>
                        <p>ระบบ AI ขั้นสูงของเราจะวิเคราะห์สภาพผิวของคุณ พร้อมระบุประเภทของสิวอย่างแม่นยำ</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-solid fa-3"></i>
                        </div>
                        <h3>รู้ผลลัพธ์ทันที</h3>
                        <p>รับการวิเคราะห์อย่างละเอียด พร้อมคำแนะนำในการดูแลและรักษาที่เหมาะกับสภาพผิวของคุณโดยเฉพาะ</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta">
            <div class="container">
                <div class="cta-content">
                    <h2>พร้อมหรือยังที่จะวิเคราะห์ผิวของคุณ ?</h2>
                    <p>ระบบ AI ขั้นสูงของเราจะวิเคราะห์สภาพผิวของคุณ <br>พร้อมระบุประเภทของสิวอย่างแม่นยำ</p>
                    <a href="/Skinscan/facescan" class="btn-white">
                        <i class="fas fa-camera"></i>
                        <span>Get Your Face Scan</span>
                    </a>
                </div>
            </div>
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
