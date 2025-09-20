<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Skinscan</title>
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
    {{-- <link rel="javascript" href="{{asset('javascript/script.js')}}"> --}}
    <script src="{{ asset('javascript\script.js') }}"></script>
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
        <section class="about-hero">
            <div class="container">
                <div class="about-hero-content">
                    <div class="logo-icon">
                        <img src="{{URL::asset('image/Acne_W.png')}}" alt="AcneScan Logo" class="footer-logo-img">
                    </div>
                    <h1>เกี่ยวกับ SkinScan</h1>
                    <p>เรามุ่งมั่นที่จะทำให้ทุกคนสามารถเข้าถึงการวิเคราะห์ผิวระดับมืออาชีพได้ง่ายขึ้น ด้วยเทคโนโลยี AI อันล้ำสมัย ผสานกับความเชี่ยวชาญทางด้านผิวหนัง</p>
                </div>
            </div>
        </section>
        <section class="content-section">
            <div class="what is acne" >
                <h2 style="margin: 0;">เรื่องราวของเรา</h2>
                <p>SkinScan ก่อตั้งขึ้นในปี 2023 โดยทีมแพทย์ผิวหนัง นักวิจัยด้าน AI และผู้เชี่ยวชาญด้านนวัตกรรมการดูแลสุขภาพ ซึ่งเล็งเห็นถึงความจำเป็นที่เพิ่มขึ้นในการเข้าถึงการดูแลผิวอย่างมีประสิทธิภาพสำหรับทุกคน โดยเฉพาะเมื่อสิวเป็นปัญหาที่ส่งผลกระทบต่อผู้คนกว่า 85% ในช่วงใดช่วงหนึ่งของชีวิต เราจึงมองเห็นโอกาสในการเชื่อมต่อระหว่างการดูแลโดยผู้เชี่ยวชาญกับความต้องการในการดูแลผิวในชีวิตประจำวันด้วยเทคโนโลยี AI ขั้นสูงของเรา ซึ่งได้รับการฝึกจากภาพที่ผ่านการตรวจสอบโดยแพทย์ผิวหนังมากกว่า 8,481 ภาพ เราสามารถวิเคราะห์สภาพผิวได้อย่างแม่นยำและรวดเร็ว ช่วยให้ผู้ใช้เข้าใจปัญหาผิวของตน และตัดสินใจเลือกแนวทางดูแลผิวได้อย่างมั่นใจ</p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission">
            <div class="container">
                <h2>สิ่งที่เราให้ความสำคัญ</h2>
                <div class="acne-types-grid">
                    <div class="Importance-card">
                        <div class="privacy-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>ความเป็นส่วนตัวต้องมาก่อน</h3>
                        <p>
                            ข้อมูลและรูปภาพของคุณจะถูกเข้ารหัสอย่างปลอดภัย และจะไม่มีการเปิดเผยหรือแบ่งปันใด ๆโดยไม่ได้รับความยินยอมจากคุณอย่างชัดเจน
                        </p>
                    </div>

                    <div class="Importance-card">
                        <div class="privacy-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>ความแม่นยำ</h3>
                        <p>
                            ระบบ AI ของเราได้รับการฝึกจากภาพถ่ายที่ผ่านการตรวจสอบโดยแพทย์ผิวหนังที่มีความเชียวชาญ เพื่อให้ได้ผลลัพธ์ที่เชื่อถือได้
                        </p>

                    </div><div class="Importance-card">
                        <div class="privacy-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>การดูแลที่เข้าถึงได้</h3>
                        <p>
                            เราทำให้การวิเคราะห์ผิวระดับมืออาชีพเป็นสิ่งที่ทุกคนสามารถเข้าถึงได้ ไม่ว่าจะอยู่ที่ใดก็ตาม
                        </p>
                    </div>
                </div>
            </div>
        </section>
            <!-- Doctor section -->
            <section class="doctor-section">
                <div class="section-header">
                    <h2>ทีมผู้เชี่ยวชาญของเรา</h2>
                </div>

                <div class="doctor-card">
                    <img src="doctor.png" alt="ดร. ซาราห์ จอห์นสัน" class="doctor-image" />
                    <div class="doctor-info">
                    <h3>ดร. ซาราห์ จอห์นสัน</h3>
                    <p class="position">
                        ประธานเจ้าหน้าที่ฝ่ายการแพทย์<br>
                        <span class="position-en">(Chief Medical Officer)</span>
                    </p>
                    <p class="description">
                        แพทย์ผิวหนังที่ได้รับใบรับรองจากสภาแพทย์สหรัฐฯ มีประสบการณ์ด้านการรักษาสิวและดูแลสุขภาพผิวมากกว่า 15 ปี
                    </p>
                    </div>
                </div>
            </section>
            <!-- Team section -->
            <section class="doctor-section">
                <div class="section-header">
                    <h2>สมาชิกในทีม</h2>
                </div>

                <!-- ✅ เพิ่ม container ห่อ grid -->
                {{-- <div class="doctor-grid">
                    <!-- สมาชิกทั้ง 10 ตามที่คุณใส่ไว้ -->
                    <div class="doctor-card">
                        <img src="images/member1.jpg" alt="ชนิสรา สอนเหลิม" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>ชนิสรา สอนเหลิม</h3>
                            <p class="position">เมียหมอผ่าตัด</p>
                        </div>
                    </div>

                    <!-- สมาชิก 2 -->
                    <div class="doctor-card">
                        <img src="images/member2.jpg" alt="ทุ่มเท ทุ่มใจ" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>ทุ่มเท ทุ่มใจ</h3>
                            <p class="position">พนักงานทำความสะอาด</p>
                        </div>
                    </div>

                    <!-- สมาชิก 3 -->
                    <div class="doctor-card">
                        <img src="images/member3.jpg" alt="ใยใหม ใยเเมงมุม" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>ใยใหม ใยเเมงมุม</h3>
                            <p class="position">ผู้ช่วยพนักงานทำความสะอาด</p>
                        </div>
                    </div>

                    <!-- สมาชิก 4 -->
                    <div class="doctor-card">
                        <img src="images/member4.jpg" alt="ปิ่นทิพย์ จริงใจ" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>ปิ่นทิพย์ จริงใจ</h3>
                            <p class="position">QA testers</p>
                        </div>
                    </div>

                    <!-- สมาชิก 5 -->
                    <div class="doctor-card">
                        <img src="images/member5.jpg" alt="บัวบาดาล ใต้ทะเลอ่าวไทย" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>บัวบาดาล ใต้ทะเลอ่าวไทย</h3>
                            <p class="position">ลูกประธานบริษัท</p>
                        </div>
                    </div>

                    <!-- สมาชิก 6 -->
                    <div class="doctor-card">
                        <img src="images/member6.jpg" alt="รอนชดาภัทร ทรัพย์ไม่มีรักหมาเด็กทุกทีแต่เธอไม่ลืมคนเก่า" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>รอนชดาภัทร ทรัพย์ไม่มีรักหมาเด็กทุกทีแต่เธอไม่ลืมคนเก่า</h3>
                            <p class="position">Marketing Director</p>
                        </div>
                    </div>

                    <!-- สมาชิก 7 -->
                    <div class="doctor-card">
                        <img src="images/member7.jpg" alt="นัท แต่เพื่อนเรียกนัทนะโซ่" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>นัท แต่เพื่อนเรียกนัทนะโซ่</h3>
                            <p class="position">นายแบบสุดเท่</p>
                        </div>
                    </div>

                    <!-- สมาชิก 8 -->
                    <div class="doctor-card">
                        <img src="images/member8.jpg" alt="วีราทร ข้างถนน" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>วีราทร ข้างถนน</h3>
                            <p class="position">ฮมเลสที่นอนอยู่ข้างๆคลินิก</p>
                        </div>
                    </div>

                    <!-- สมาชิก 9 -->
                    <div class="doctor-card">
                        <img src="images/member9.jpg" alt="แป๋วแหวว  แจ๋วกว่านี้มีอีกมั้ย" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>แป๋วแหวว  แจ๋วกว่านี้มีอีกมั้ย</h3>
                            <p class="position">นักวิจัยการนั่งเฉยๆ ให้ดูเหมือนทำงาน</p>
                        </div>
                    </div>

                    <!-- สมาชิก 10 -->
                    <div class="doctor-card">
                        <img src="images/member10.jpg" alt="ปลาทอง ปราบเซียน" class="doctor-image" />
                        <div class="doctor-info">
                            <h3>ปลาทอง ปราบเซียน</h3>
                            <p class="position">หัวหน้าฝ่ายพัฒนาบุคลากรปราบเซียน</p>
                        </div>
                    </div>
                </div> --}}
            </section>

            <!-- Hero Section -->
            <section class="about-hero">
                <div class="container">
                    <div class="about-hero-content">
                        <h1>พันธกิจของเรา</h1>
                        <p>เรามุ่งมั่นที่จะเสริมพลังให้กับทุกคน ด้วยข้อมูลวิเคราะห์สุขภาพผิวที่เข้าถึงได้ แม่นยำ และขับเคลื่อนด้วย AI เพื่อช่วยให้ตัดสินใจเรื่องการดูแลผิวได้อย่างมีข้อมูลรองรับ และสามารถเชื่อมต่อกับผู้เชี่ยวชาญได้อย่างเหมาะสมเมื่อจำเป็น</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Contact Section -->
        <section class="contact">
            <div class="container">
                <h2>ติดต่อเรา</h2>
                <p>Have questions or feedback? We'd love to hear from you.</p>

                <div class="contact-grid">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>ส่งอีเมลหาเรา</h3>
                        <p>เรายินดีรับฟังทุกความคิดเห็นจากคุณsupport@skinscan.ai</p>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>โทรหาเรา</h3>
                        <p> จันทร์-ศุกร์ เวลา 9.00 น. – 18.00 น. 044-295-186 SKIN-SCAN</p>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>เยี่ยมชมเรา</h3>
                        <p>มหาวิทยาลัยขอนแก่น 123 หมู่ 16 ถนนมิตรภาพ ตำบลในเมือง อำเภอเมืองขอนแก่น 40002</p>
                    </div>
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
