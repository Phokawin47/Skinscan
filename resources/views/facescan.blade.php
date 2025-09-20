<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Skinscan</title>
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/face-scan.css')}}">
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
    <main>
        <h1>TEST</h1>
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
