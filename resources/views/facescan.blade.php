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
                    <a href="/Skinscan/home" class="nav-link">Home</a>
                    <a href="/Skinscan/anceinfomation" class="nav-link">Acne Info</a>
                    <a href="/Skinscan/facescan" class="nav-link active">Face Scan</a>
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

    <main>
        <div class="container">
            <section class="skin-scan-section">
                <div class="skin-scan-container">
                    <h1 class="main-title">ระบบสแกนผิวหน้า</h1>
                    <h2 class="sub-title">
                    เริ่มต้นดูแลผิวของคุณอย่างถูกวิธี ด้วยการวิเคราะห์ใบหน้าด้วยระบบ AI
                    </h2>
                    <p class="description">
                    เพียงแค่ถ่ายภาพหรืออัปโหลดรูปใบหน้า ระบบจะดำเนินการวิเคราะห์ทันที
                    เพื่อประเมินประเภทของสิว บริเวณที่พบปัญหา และปัจจัยที่อาจเป็นสาเหตุของการเกิดสิว
                    โดยใช้เทคโนโลยี AI ที่พัฒนาขึ้นเฉพาะสำหรับการตรวจจับและประมวลผลปัญหาผิวอย่างแม่นยำ
                    </p>

                    <div class="divider"></div>

                    <p class="privacy-text">
                    ระบบใช้งานง่าย ปลอดภัย และ <span class="highlight">ไม่บันทึกรูปภาพของคุณ</span>
                    เพื่อความเป็นส่วนตัวสูงสุด <br>
                    พร้อมหรือยัง? ให้ AI ช่วยดูแลผิวคุณในทุกวัน
                    </p>

                    <div class="logo-container">
                        <div class="logo-icon">
                            <img src="{{URL::asset('image/Acne_W.png')}}" alt="AcneScan Logo" class="footer-logo-img">
                        </div>
                        <span class="logo-text">SkinScan</span>
                    </div>
                </div>
            </section>

            <div class="scan-container">
                <!-- Mode Selection -->
                <div id="modeSelection" class="scan-step active">
                    <h2>เริ่มการวิเคราะห์ผิวหน้าของคุณ</h2>
                    <form id="userInfoForm" class="user-info-form">
                        <h3>กรอกข้อมูลเบื้องต้นของคุณ</h3>
                        <label for="age">อายุ:</label>
                        <input type="number" id="age" name="age" min="1" max="90" required>

                        <label for="gender">เพศ:</label>
                        <select id="gender" name="gender" required>
                            <option value="">-- เลือกเพศ --</option>
                            <option value="male">ชาย</option>
                            <option value="female">หญิง</option>
                        </select>

                        <label for="allergy">สารที่แพ้ (หากมี):</label>
                        <input type="text" id="allergy" name="allergy" placeholder="เช่น แอลกอฮอล์, น้ำหอม">

                        <label for="skinType">สภาพผิว:</label>
                        <select id="skinType" name="skinType" required>
                            <option value="">-- เลือกสภาพผิว --</option>
                            <option value="ผิวแห้ง">ผิวแห้ง</option>
                            <option value="ผิวมัน">ผิวมัน</option>
                            <option value="ผิวบอบบาง">ผิวบอบบาง</option>
                            <option value="ผิวผสม">ผิวผสม</option>
                        </select>
                    </form>

                    <div class="scan-methods">
                        <button class="scan-method" onclick="selectScanMode('camera')">
                            <i class="fas fa-camera"></i>
                            <h3>สแกนผ่านกล้อง</h3>
                            <p>ถ่ายภาพสดโดยใช้กล้องของอุปกรณ์ของคุณเพื่อวิเคราะห์ทันที</p>
                        </button>

                        <button class="scan-method" onclick="selectScanMode('upload')">
                            <i class="fas fa-upload"></i>
                            <h3>อัปโหลดรูปภาพ</h3>
                            <p>อัปโหลดรูปถ่ายที่มีอยู่จากอุปกรณ์ของคุณเพื่อวิเคราะห์</p>
                        </button>
                    </div>

                    <div class="tip">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="tip-info-icon">!</i>
                            <h2 style="margin: 0;">เพื่อผลลัพธ์ที่ดีที่สุด</h2>
                        </span>

                        <div class="tip-list-wrapper">
                            <div class="tip-bullet">
                                <ul>
                                    <li>ให้มีแสงสว่างเพียงพอบนใบหน้า</li>
                                    <li>ลบเครื่องสำอางและทำความสะอาดใบหน้า</li>
                                </ul>
                                <ul>
                                    <li>หันหน้าเข้ากล้องโดยตรง</li>
                                    <li>ใช้ภาพความละเอียดสูง</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Camera Mode -->
                <div id="cameraMode" class="scan-step">
                    <div class="scan-header">
                        <h2>Camera Scanner</h2>
                        <button class="btn-cancel" onclick="resetScan()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>

                    <div class="camera-container">
                        <video id="video" autoplay playsinline muted></video>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <div class="camera-overlay">
                            <div class="face-guide">
                                <span>Position your face here</span>
                            </div>
                        </div>
                    </div>

                    <div class="camera-controls">
                        <button class="btn-primary" onclick="capturePhoto()">
                            <i class="fas fa-camera"></i>
                            <span>Capture Photo</span>
                        </button>
                    </div>
                </div>

                <!-- Upload Mode -->
                <div id="uploadMode" class="scan-step">
                    <div class="scan-header">
                        <h2>Upload Photo</h2>
                        <button class="btn-cancel" onclick="resetScan()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>

                    <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-upload"></i>
                        <h3>Click to upload or drag & drop</h3>
                        <p>JPG, PNG, or WEBP (max 10MB)</p>
                    </div>

                    <input type="file" id="fileInput" accept="image/*" style="display: none;" onchange="handleFileUpload(event)">
                </div>

                <!-- Scanning State -->
                <div id="scanningState" class="scan-step">
                    <div class="scanning-content">
                        <div class="scan-image-container">
                            <img id="scanImage" alt="Uploaded face">
                        </div>

                        <div class="scanning-status">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Analyzing your skin...</span>
                        </div>

                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>

                        <p>Our AI is analyzing your skin condition. This may take a few seconds.</p>
                    </div>
                </div>

                <!-- Results -->
                <div id="resultsState" class="scan-step">
                    <div class="results-header">
                        <h2><i class="fas fa-check-circle"></i> Analysis Complete</h2>
                        <button class="btn-secondary" onclick="resetScan()">
                            <i class="fas fa-redo"></i> New Scan
                        </button>
                    </div>

                    <div class="results-content">
                        <div class="results-image">
                            <img id="resultImage" alt="Analyzed face">
                        </div>
                            <!-- แก้ตรงนี้จ้าาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาาา -->
                        <div class="results-details">
                            <div class="recommendations">
                                <h3><i class="fas fa-bolt"></i> Recommended Actions</h3>
                                <ul class="recommendations-list">
                                </ul>
                            </div>

                            <h2 class="section-title">สกินแคร์แนะนำ</h2>
                            <div id="acneTypeCardsContainer"></div>

                            <!-- Modal Template -->
                            <div id="productModal" class="modal">
                                <div class="modal-content">
                                    <span class="close-button" onclick="closeModal()">&times;</span>
                                    <h3 id="modalTitle"></h3>
                                    <div id="modalProducts" class="product-grid"></div>
                                </div>
                            </div>

                            <div class="skincare-grid" id="skincareCards"></div>







                            <div class="disclaimer">
                                <p><strong>Disclaimer:</strong> ผลิตภัณฑ์ดูแลผิวที่ระบบแนะนำ เป็นไปตามข้อมูลการวิเคราะห์เบื้องต้นและไม่ได้ถือเป็นคำวินิจฉัยทางการแพทย์ หากพบอาการระคายเคือง แพ้ หรือผิดปกติใด ๆ หลังการใช้ผลิตภัณฑ์ ควรหยุดใช้ทันที และปรึกษาแพทย์หรือผู้เชี่ยวชาญด้านผิวหนัง เพื่อความปลอดภัยและผลลัพธ์ที่เหมาะสมที่สุดต่อสภาพผิวของคุณ.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
