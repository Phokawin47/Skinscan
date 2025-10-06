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
    <x-app-header />

    <main>
        <div class="container">
            <div class="page-header">
                <h1>ข้อมูลเกี่ยวกับสิว</h1>
                <p>เรียนรู้เกี่ยวกับประเภทของสิว สาเหตุที่ทำให้เกิดสิว และวิธีการรักษาที่มีประสิทธิภาพ ที่จะช่วยให้คุณจัดการกับสิวอย่างถูกวิธี พร้อมทั้งเสริมสร้างการดูแลผิวของคุณให้มีสุขภาพดี</p>
            </div>

            <!-- What is Acne -->
            <div class="what is acne">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <i class="info-icon">i</i>
                        <h2 style="margin: 0;">สิว คืออะไร ?</h2>
                    </span>

                <p>สิวเป็นปัญหาผิวหนังที่พบได้บ่อย ซึ่งเกิดขึ้นเมื่อรูขุมขนอุดตันด้วยน้ำมันและเซลล์ผิวที่ตายแล้ว มักพบได้บ่อยที่สุดบนใบหน้า คอ หน้าอก หลัง และไหล่ แม้ว่าสิวจะพบได้บ่อยในช่วงวัยรุ่นเนื่องจากการเปลี่ยนแปลงของฮอร์โมน แต่ก็สามารถเกิดขึ้นได้กับทุกวัยเช่นเดียวกัน</p>
            </div>

            <!-- Types of Acne -->
            <section class="content-section">
                <h2>ประเภทของสิว</h2>
                <div class="acne-types-grid">
                    <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Ace (สิวทั่วไป)</h3>
                            <span class="severity moderate">Moderate</span>
                        </div>
                        <p>มักปรากฏเป็นจุดแดงหรือตุ่มที่มีการอักเสบบนผิวหนังบริเวณหน้าผาก คาง หรือจมูก</p>
                    </div>

                    <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Blackhead (สิวเสี้ยน)</h3>
                            <span class="severity mild">Mild</span>
                        </div>
                        <p>เป็นจุดดำๆ ที่มักเกิดในบริเวณจมูกหรือหน้าผาก โดยเป็นจุดเล็กๆ ที่มองเห็นได้ชัดเจน</p>
                    </div>

                    <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Whitehead (สิวหัวขาว)</h3>
                            <span class="severity mild">Mild</span>
                        </div>
                        <p>เป็นตุ่มเล็กๆ ที่มีสีขาวอยู่บนผิวหนัง มักจะมองเห็นเป็นเม็ดขาวๆ ที่อยู่ใต้ผิวหนัง</p>
                    </div>

                    <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Purulent (สิวหนอง)</h3>
                            <span class="severity severe">Severe</span>
                        </div>
                        <p>ลักษณะเป็นตุ่มที่มีหัวหนองอยู่ด้านบน มีหนองขาวหรือเหลืองอยู่ภายในและมักจะอักเสบ</p>
                    </div>

                    <!-- <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Pustules (สิวหัวหนอง)</h3>
                            <span class="severity moderate">Moderate</span>
                        </div>
                        <p>ตุ่มที่มีหนองสีขาวหรือเหลืองอยู่ภายใน โดยจะมีการบวมและเจ็บรอบๆ จุดที่มีหนอง</p>
                    </div> -->

                    <div class="acne-type-card">
                        <div class="acne-type-header">
                            <h3>Papular (สิวตุ่มแดง)</h3>
                            <span class="severity moderate">Moderate</span>
                        </div>
                        <p>จะมีลักษณะเป็นตุ่มสีแดงหรือชมพูที่ยกขึ้นมาจากผิวหนัง มักจะรู้สึกเจ็บหากสัมผัส</p>
                    </div>
                </div>
            </section>

            <!-- สาเหตุ  -->
            <div class="cause">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <i class="cause-info-icon">!</i>
                        <h2 style="margin: 0;">สาเหตุในการเกิดสิวที่พบบ่อย</h2>
                    </span>

                <div class="cause-list-wrapper">
                    <div class="cause-bullet">
                        <ul>
                            <li>การผลิตน้ำมันส่วนเกิน</li>
                            <li>รูขุมขนอุดตัน</li>
                            <li>แบคทีเรีย</li>
                            <li>การเปลี่ยนแปลงของฮอร์โมน</li>
                        </ul>
                        <ul>
                            <li>พันธุกรรม</li>
                            <li>ยาบางประเภท</li>
                            <li>อาหาร (ผลิตภัณฑ์จากนมและอาหารที่มีดัชนีน้ำตาลสูง)</li>
                            <li>ความเครียด</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Causes -->
            <section class="content-section">
                <div class="title-row">
                    <i class="fas fa-check-square checkbox-icon"></i>
                    <h2>ตัวเลือกในการรักษา</h2>
                </div>
                <div class="causes-grid">
                    <div class="cause-card">
                        <h3>รักษาโดยการทายา</h3>
                        <ul class="treatment-list">
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Benzoyl Peroxide</div>
                                    <div class="treatment-desc">ช่วยลดการสะสมของแบคทีเรียในรูขุมขนและลดการอักเสบ รวมถึงช่วยทำให้รูขุมขนสะอาด</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Salicylic Acid</div>
                                    <div class="treatment-desc">ช่วยขจัดเซลล์ผิวที่ตายแล้วและลดการอุดตันในรูขุมขน ช่วยลดการเกิดสิวเสี้ยนและสิวอุดตัน</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Retinoids</div>
                                    <div class="treatment-desc">ช่วยในการผลัดเซลล์ผิวและลดการอุดตันในรูขุมขน นอกจากนี้ยังช่วยลดร่องรอยจากสิวได้ด้วย</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Clindamycin</div>
                                    <div class="treatment-desc">ช่วยฆ่าแบคทีเรียในผิวหนังที่เป็นสาเหตุของการเกิดสิว ลดการอักเสบ</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="cause-card">
                        <h3>รักษาโดยการทานยา</h3>
                        <ul class="treatment-list">
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Antibiotics</div>
                                    <div class="treatment-desc">ใช้ในการฆ่าแบคทีเรียที่ทำให้เกิดสิว และช่วยลดการอักเสบ เช่น Tetracycline หรือ Doxycycline</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Hormonal therapy</div>
                                    <div class="treatment-desc">ใช้สำหรับผู้หญิงที่มีสิวจากการเปลี่ยนแปลงของฮอร์โมน เช่น การใช้ยาคุมกำเนิด</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Isotretinoin, Accutane</div>
                                    <div class="treatment-desc">เป็นยาที่มีประสิทธิภาพสูงในการรักษาสิวหนัก ช่วยลดการผลิตน้ำมันในผิวหนังและลดการเกิดสิวอย่างมีประสิทธิภาพ</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="cause-card">
                        <h3>รักษาโดยผู้เชี่ยวชาญ</h3>
                        <ul class="treatment-list">
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Chemical peels</div>
                                    <div class="treatment-desc">การใช้สารเคมีเพื่อขจัดเซลล์ผิวที่ตายแล้วและกระตุ้นการสร้างเซลล์ใหม่ ช่วยลดสิวและรอยแผลเป็นจากสิว</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Microdermabrasion</div>
                                    <div class="treatment-desc">กระบวนการขัดผิวที่ช่วยกำจัดเซลล์ผิวที่ตายแล้วและลดการอุดตันในรูขุมขน</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Light therapy</div>
                                    <div class="treatment-desc">การใช้แสงที่มีความยาวคลื่นเฉพาะเพื่อลดการอักเสบและฆ่าแบคทีเรียในรูขุมขน</div>
                                </div>
                            </li>
                            <li class="treatment-item">
                                <div class="bullet">●</div>
                                <div class="text-group">
                                    <div class="treatment-title">Extraction</div>
                                    <div class="treatment-desc">การดึงสิวที่อุดตันออกจากรูขุมขนโดยแพทย์หรือผู้เชี่ยวชาญ เพื่อลดการอักเสบและป้องกันการเกิดสิวใหม่</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="content-section">
                <div class="section-header2">
                    <i class="fa-regular fa-heart"></i>
                    <span>ส่วนผสมที่มีประสิทธิภาพ</span>
                </div>
                <div class="ingredient-grid">
                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Salicylic Acid (BHA)</h3>
                            <p>ช่วยขจัดเซลล์ผิวที่ตายแล้ว และช่วยลดการอุดตันในรูขุมขน</p>
                        </div>
                        <div class="severity mild">0.5% ถึง 2%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Lipo-Hydroxy Acid (LHA)</h3>
                            <p>ช่วยลดการอุดตันในรูขุมขนและผลัดเซลล์ผิว</p>
                        </div>
                        <div class="severity mild">0.5% ถึง 2%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Niacinamide (Vitamin B5)</h3>
                            <p>ช่วยปรับสีผิวให้สม่ำเสมอ ลดจุดด่างดำ เสริมเกราะป้องกันผิว ลดการอักเสบ และเพิ่มความชุ่มชื้น</p>
                        </div>
                        <div class="severity mild">2% ถึง 5%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Tea Tree Oil</h3>
                            <p>ช่วยลดการอักเสบและช่วยรักษาสิว</p>
                        </div>
                        <div class="severity mild">5% ถึง 10%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Sulfur</h3>
                            <p>ช่วยลดการอุดตันของรูขุมขน และมีคุณสมบัติในการฆ่าเชื้อแบคทีเรียที่ทำให้เกิดสิว</p>
                        </div>
                        <div class="severity mild">3% ถึง 10%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Aloe Vera Extract</h3>
                            <p>ช่วยให้ความชุ่มชื้นแก่ผิว ลดการระคายเคือง และช่วยฟื้นฟูผิวจากการอักเสบ</p>
                        </div>
                        <div class="severity mild">10% ถึง 20%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Centella Asiatica</h3>
                            <p>ช่วยในการฟื้นฟูผิวที่บาดเจ็บจากการอักเสบ หรือรอยแผลเป็นจากสิว</p>
                        </div>
                        <div class="severity mild">1% ถึง 5%</div>
                    </div>

                    <div class="ingredient-card">
                        <div class="ingredient-content">
                            <h3>Panthenol (Vitamin B5)</h3>
                            <p>ช่วยเพิ่มความชุ่มชื้นให้กับผิว ช่วยบรรเทาการระคายเคืองและช่วยฟื้นฟูผิวที่แห้งและเสียหาย</p>
                        </div>
                        <div class="severity mild">1% ถึง 5%</div>
                    </div>
                </div>
            </section>
            <br>
            <section class="content-section">
                <div class="info-box">
                    <div class="info-header">
                        <div class="info-icon2">!</div>
                        <strong class="info-title">หมายเหตุ</strong>
                    </div>
                    <div class="info-description">
                        ข้อมูลนี้มีไว้เพื่อการศึกษาเท่านั้น และไม่ควรแทนที่คำแนะนำทางการแพทย์จากผู้เชี่ยวชาญ
                        ควรปรึกษาแพทย์ผิวหนังหรือผู้ให้บริการด้านสุขภาพเพื่อการวินิจฉัยและคำแนะนำในการรักษาที่เหมาะสม
                        โดยเฉพาะในกรณีที่มีอาการสิวที่รุนแรงหรือเรื้อรัง
                    </div>
                </div>
            </section>
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
