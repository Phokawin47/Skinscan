<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Skinscan</title>
    <style>
        @import url( {{asset('css/styles.css')}} );
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="nav-wrapper">
                <a href="/Skinscan/home" class="logo">
                    <div class="logo-icon">
                        <img src="{{URL::asset('image/Acne.png')}}" alt="AcneScan Logo" class="footer-logo-img">
                    </div>
                    <span class="logo-text">SkinScan</span>
                </a>

                <nav class="nav-desktop">
                    <a href="/Skinscan/home" class="nav-link active">Home</a>
                    <a href="/Skinscan/anceinfomation" class="nav-link">Acne Info</a>
                    <a href="/Skinscan/facescan" class="nav-link">Face Scan</a>
                    <a href="/Skinscan/aboutus" class="nav-link">About Us</a>
                </nav>

                <a href="/Skinscan/facescan" class="cta-button">
                    <i class="fas fa-camera"></i>
                    <span>Scan Now</span>
                </a>

                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="nav-mobile" id="mobileNav">
                <a href="/Skinscan/home" class="nav-link-mobile">Home</a>
                <a href="/Skinscan/anceinfomation" class="nav-link-mobile">Acne Info</a>
                <a href="/Skinscan/facescan" class="nav-link-mobile">Face Scan</a>
                <a href="/Skinscan/aboutus" class="nav-link-mobile">About Us</a>
                <a href="/Skinscan/facescan" class="cta-button-mobile">
                    <i class="fas fa-camera"></i>
                    <span>Scan Now</span>
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
