// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ค่อยโหลดสคริปต์ของคุณทีหลัง (ถ้ามัน error, Alpine ก็เริ่มไปแล้ว)
import './script';
