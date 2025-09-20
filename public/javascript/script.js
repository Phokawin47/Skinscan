// Global variables
let currentPage = 'home';
let currentScanMode = null;
let stream = null;
let scanTimeout = null;

// Page management
function showPage(pageId) {
    // Hide all pages
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active'));

    // Show selected page
    const targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.classList.add('active');
        currentPage = pageId;

        // Update navigation
        updateNavigation(pageId);

        // Close mobile menu if open
        const mobileNav = document.getElementById('mobileNav');
        mobileNav.classList.remove('active');

        // Scroll to top
        window.scrollTo(0, 0);
    }
}

function updateNavigation(activePageId) {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.dataset.page === activePageId) {
            link.classList.add('active');
        }
    });
}

// Mobile menu toggle
function toggleMobileMenu() {
    const mobileNav = document.getElementById('mobileNav');
    const menuBtn = document.querySelector('.mobile-menu-btn i');

    mobileNav.classList.toggle('active');

    if (mobileNav.classList.contains('active')) {
        menuBtn.className = 'fas fa-times';
    } else {
        menuBtn.className = 'fas fa-bars';
    }
}

// Treatment accordion toggle
function toggleTreatment(treatmentId) {
    const content = document.getElementById(treatmentId);
    const header = content.previousElementSibling;
    const icon = header.querySelector('i');

    if (content.classList.contains('active')) {
        content.classList.remove('active');
        icon.className = 'fas fa-chevron-down';
    } else {
        // Close all other treatments
        const allTreatments = document.querySelectorAll('.treatment-content');
        const allIcons = document.querySelectorAll('.treatment-header i');

        allTreatments.forEach(treatment => treatment.classList.remove('active'));
        allIcons.forEach(icon => icon.className = 'fas fa-chevron-down');

        // Open selected treatment
        content.classList.add('active');
        icon.className = 'fas fa-chevron-up';
    }
}

// Face scan functionality
function selectScanMode(mode) {
    currentScanMode = mode;
    // ซ่อน section ด้านบน
    document.querySelector('.skin-scan-section').style.display = 'none';

    // ซ่อนทุก step ก่อน แล้วค่อยเปิดอันที่เลือก
    document.querySelectorAll('.scan-step').forEach(el => el.classList.remove('active'));
    // Hide mode selection
    document.getElementById('modeSelection').classList.remove('active');
    if (mode === 'upload') {
        document.getElementById('uploadMode').classList.add('active');
    }
    else if (mode === 'camera') {
        document.getElementById('cameraMode').classList.add('active');
        startCamera();
    }
}

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'user' }
        });

        const video = document.getElementById('video');
        video.srcObject = stream;
    } catch (error) {
        console.error('Error accessing camera:', error);
        alert('Unable to access camera. Please check permissions or try uploading a photo instead.');
        resetScan();
    }
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function blobToBase64(blob) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onloadend = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(blob);
    });
}


function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.querySelector('.camera-controls');
    const scannersection = document.getElementById("cameraMode");


    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;


    context.drawImage(video, 0, 0);
    video.style.display = "none";
    captureButton.style.display = "none";
    scannersection.style.display = "none";
    document.querySelector('.skin-scan-section').style.display = 'none';

    canvas.toBlob(async (blob) => {
        if (blob) {
            stopCamera();
            const base64Image = await blobToBase64(blob);  // ✅ แปลงก่อนส่ง
            sendImageToAPI(base64Image);
        }
    }, 'image/jpeg', 0.9);


    }

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            startScan(e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

function startScan(imageUrl) {
    let age_input = document.getElementById("age").value;
    let gender_input = document.getElementById("gender").value;
    let skinType_input = document.getElementById("skinType").value;
    if (age_input > 90){
        alert("ข้อมูลไม่ถูกต้อง");
        return;
    }
    if (age_input === "" || gender_input === "" || skinType_input === "") {
        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        return; // หยุดการทำงานหากข้อมูลไม่ครบ
    }

    // Hide current step
    document.getElementById('uploadMode').classList.remove('active');

    // Show scanning state
    document.getElementById('scanningState').classList.add('active');

    // Set the image (แสดงภาพต้นฉบับระหว่างกำลังประมวลผล)
    document.getElementById('scanImage').src = imageUrl;

    // ส่งไปยัง API และแสดงผลลัพธ์
    sendImageToAPI(imageUrl);

}


function showResults(imageUrl) {
    // Hide scanning state
    document.getElementById('scanningState').classList.remove('active');

    // Show results
    document.getElementById('resultsState').classList.add('active');

    // Set result image
    document.getElementById('resultImage').src = imageUrl;
}

function resetScan() {
    // Clear any timeouts
    if (scanTimeout) {
        clearTimeout(scanTimeout);
        scanTimeout = null;
    }
    const captureButton = document.querySelector('.camera-controls');
    const video = document.getElementById('video');
    const scannersection = document.getElementById("cameraMode");


    video.style.display = "";
    captureButton.style.display = "";
    scannersection.style.display = "";
    document.querySelector('.skin-scan-section').style.display = 'block';



    document.querySelectorAll('.scan-step').forEach(el => el.classList.remove('active'));
    document.getElementById('modeSelection').classList.add('active');
    // Stop camera if running

    // Hide all scan steps
    const scanSteps = document.querySelectorAll('.scan-step');
    scanSteps.forEach(step => step.classList.remove('active'));

    // Show mode selection
    document.getElementById('modeSelection').classList.add('active');

    // Reset file input
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.value = '';
    }

    // Reset variables
    currentScanMode = null;
}

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    // Show home page by default
    showPage('home');

    // Add click handlers for drag and drop area
    const uploadArea = document.querySelector('.upload-area');
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--primary)';
            this.style.background = 'rgba(37, 99, 235, 0.05)';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--gray-300)';
            this.style.background = 'transparent';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--gray-300)';
            this.style.background = 'transparent';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        startScan(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.page) {
            showPage(e.state.page);
        }
    });

    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Handle window resize
window.addEventListener('resize', function() {
    // Close mobile menu on resize to desktop
    if (window.innerWidth > 768) {
        const mobileNav = document.getElementById('mobileNav');
        const menuBtn = document.querySelector('.mobile-menu-btn i');

        mobileNav.classList.remove('active');
        menuBtn.className = 'fas fa-bars';
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    stopCamera();
    if (scanTimeout) {
        clearTimeout(scanTimeout);
    }
});


function getUserInput() {
    return {
        age: document.getElementById("age")?.value || "",
        gender: document.getElementById("gender")?.value || "",
        allergy: document.getElementById("allergy")?.value || "",
        skinType: document.getElementById("skinType")?.value || ""
    };
}

let rulesData = null;

fetch("/public/javascript/rules.json")
  .then(res => res.json())
  .then(data => {
    rulesData = data;
    console.log("rules loaded:", rulesData);
  })
  .catch(err => console.error("โหลด rules.json ไม่สำเร็จ:", err));

// ส่งภาพไปยัง API และแสดงผลลัพธ์
const api_predict = (location.hostname === "localhost" || location.hostname === "127.0.0.1") ? "http://127.0.0.1:8000/predict" : "/api/predict";
async function sendImageToAPI(base64Image) {
    const imgTag = document.getElementById("resultImage");
    const userData = getUserInput();

    const payload = {
        image: base64Image,
        age: userData.age,
        gender: userData.gender,
        allergy: userData.allergy,
        skinType: userData.skinType
    };

    try {
        const response = await fetch(api_predict, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            throw new Error("Server returned " + response.status);
        }

        const result = await response.json();
        // console.log(result)
        const resultImageUrl = "data:image/jpeg;base64," + result.image;
        imgTag.src = resultImageUrl;
        imgTag.style.display = "block";
        // ✅ ตรวจสอบว่าไม่มีสิว (Array)
        if (result["rule_response"]["no_detections"]) {
            // แสดงข้อความไม่พบสิวในกล่องแนะนำ
            noresult();
            showResults(resultImageUrl); // ✅ แสดงหน้า results
            return;
        }
        result_push(result);
        product_push(result, rulesData);
        showResults(resultImageUrl);

        return result;
    } catch (err) {
        console.error("Failed to send image:", err);
        alert("เกิดข้อผิดพลาดในการวิเคราะห์ผิว");
    }
}


function result_push(result) {
    const listContainer = document.querySelector(".recommendations-list");
    listContainer.innerHTML = ""; // ล้างรายการเก่า

    const ruleArray = result["rule_response"];

    ruleArray.forEach(acneItem => {
        const acneType = acneItem["ประเภทสิว"];
        const advice = acneItem["คำแนะนำ"];
        const substances = acneItem["สารแนะนำ"];
        const cause = acneItem["สาเหตุ"];
        // เพิ่มหัวข้อสิว
        const headerItem = document.createElement("li");
        headerItem.innerHTML = `<strong><i class="fas fa-exclamation-circle"></i> ประเภทสิว: ${acneType}</strong>`;
        listContainer.appendChild(headerItem);

        if (cause){
            const cause_item = document.createElement("li");
            cause_item.innerHTML = `<i class="fas fa-frown"></i> สาเหตุ: ${cause}`;
            listContainer.appendChild(cause_item)
        }

        // เพิ่มคำแนะนำ
        if (advice) {
            const adviceItem = document.createElement("li");
            adviceItem.innerHTML = `<i class="fas fa-lightbulb"></i> คำแนะนำ: ${advice}`;
            listContainer.appendChild(adviceItem);
        }

        // ✅ แสดงสารแนะนำในบรรทัดเดียว
        if (Array.isArray(substances) && substances.length > 0) {
            const li = document.createElement("li");
            li.innerHTML = `<i class="fas fa-vial"></i> สารแนะนำ: ${substances.join(", ")}`;
            listContainer.appendChild(li);
        }

        // คั่นรายการ
        const divider = document.createElement("hr");
        listContainer.appendChild(divider);
    });
}



function product_push(result, rules) {
  const acneContainer = document.getElementById("acneTypeCardsContainer");
  acneContainer.innerHTML = "";
  acneContainer.className = "acne-type-grid"; // เพิ่ม class grid

  const ruleArray = result["rule_response"];
  const productLookup = createProductLookup(rules["Product"]);

  ruleArray.forEach((acneItem, index) => {
    const acneType = acneItem["ประเภทสิว"];
    const productNames = acneItem["สินค้าแนะนำ"];

    // สร้างการ์ดของสิวแต่ละประเภท
    const card = document.createElement("div");
    card.className = "acne-type-card";
    card.innerHTML = `
      <h3>${acneType}</h3>
      <img src="product_image.png" width="100%" onclick="showProducts(${index})">
      <p>จำนวนสินค้าแนะนำ: ${productNames.length}</p>
    `;
    acneContainer.appendChild(card);
  });


  // เก็บข้อมูลไว้ใช้เปิด modal
  window.__ruleArray = ruleArray;
  window.__productLookup = createProductLookup(rules["Product"]);
}

// เปิด Modal
function showProducts(index) {
const acneItem = window.__ruleArray[index];
  const productNames = acneItem["สินค้าแนะนำ"];
  const acneType = acneItem["ประเภทสิว"];
  const productLookup = window.__productLookup;

  const modal = document.getElementById("productModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalProducts = document.getElementById("modalProducts");

  modalTitle.innerText = `สินค้าแนะนำสำหรับสิวประเภท: ${acneType}`;
  modalProducts.innerHTML = "";

  productNames.forEach(name => {
    const info = productLookup[name];
    if (!info) return;

    const ingredientsList = (info["สาร"] || []).map(i => `<li>${i}</li>`).join("");

    const card = document.createElement("div");
    card.className = "skincare-card";

    card.innerHTML = `
      <img src="${info["img_path"]}" class="product-image" />
      <div class="badge-container">
        <span class="badge blue">${info["ประเภท"]}</span>
        <span class="badge green">${info["เหมาะกับผิว"]}</span>
        <span class="badge pink">${info["เหมาะกับหน้า"]}</span>
      </div>
      <p class="product-name">${name}</p>
      <h4 class="section-subtitle">ส่วนผสมหลัก</h4>
      <ul class="ingredients-list">
        ${ingredientsList}
      </ul>
      <a href="${info["แหล่งข้อมูล"]}" target="_blank" class="read-more">...อ่านเพิ่มเติม</a>
    `;

    modalProducts.appendChild(card);
  });

  modal.style.display = "block";
}


// ปิด Modal
function closeModal() {
  document.getElementById("productModal").style.display = "none";
}


// แปลง array ของ product object ให้กลายเป็น dictionary lookup
function createProductLookup(productArray) {
    const lookup = {};
    productArray.forEach(item => {
        const name = Object.keys(item)[0];
        lookup[name] = item[name];
    });
    return lookup;
}


function noresult(){
    const listContainer = document.querySelector(".recommendations-list");
    listContainer.innerHTML = `
        <li><strong><i class="fas fa-smile"></i> หน้าของคุณไม่พบสิว</strong></li>
    `;

    // ซ่อน container สินค้าแนะนำ (หรือแสดงข้อความไม่มีสินค้า)
    const acneContainer = document.getElementById("acneTypeCardsContainer");
    acneContainer.innerHTML = `
        <div class="no-product-card">
            <p><i class="fas fa-check-circle"></i> ไม่มีสินค้าแนะนำ เนื่องจากไม่พบสิว</p>
        </div>
    `;
    acneContainer.className = "acne-type-grid";
}
