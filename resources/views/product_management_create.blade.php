<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Skinscan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

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

                <!-- ขวา: ปุ่ม Scan + โปรไฟล์ -->
                <div class="nav-actions">
                     <nav {{--class="nav-desktop"--}}>
                        <a href="{{route('product_management_creat.idx')}}" class="nav-link active">Product Management</a>
                    </nav>

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
                                    <x-dropdown-link href="{{ route('product_management_creat.idx') }}">{{ __('Manage') }}</x-dropdown-link>
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
        </div>
    <main>
    </main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-buttons">
                        <a href="{{route('product_management_creat.idx')}}" class="btn-primary">
                            <span>Add</span>
                        </a>
                        <a href="{{route('product_management_edit.idx')}}" class="btn-secondary">
                            <span>Products</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container mt-4">
                {{-- **แก้ไขจุดที่ 1:** <form> ต้องครอบทั้งสองส่วนเพื่อให้ส่งรูปภาพได้ --}}
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- ส่วนซ้าย: รูปสินค้า -->
                        <div class="col-md-4">
                            <div class="card p-3">
                                <h5>รูปผลิตภัณฑ์</h5>
                                {{-- ย้าย input มาอยู่ใน form แล้ว --}}
                                <input type="file" class="form-control" name="image" id="imageInput">
                                <div class="mt-3 text-center">
                                    <img id="previewImage" src="https://via.placeholder.com/200"
                                        class="img-fluid rounded" alt="preview">
                                </div>
                            </div>
                        </div>

                        <!-- ส่วนขวา: รายละเอียดสินค้า -->
                        <div class="col-md-8">
                            <div class="card p-4">
                                <h5>รายละเอียดผลิตภัณฑ์</h5>

                                {{-- **แก้ไขจุดที่ 2:** เพิ่มโค้ดสำหรับแสดงข้อผิดพลาด --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">ชื่อผลิตภัณฑ์</label>
                                    {{-- **แก้ไขจุดที่ 3:** เพิ่ม old() เพื่อจำค่าเดิม --}}
                                    <input type="text" name="name" class="form-control" placeholder="เช่น เซรั่มบำรุง..." value="{{ old('name') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">สารที่เกี่ยวข้อง</label>
                                    <input type="text" name="ingredients" class="form-control" placeholder="เช่น Salicylic Acid, Niacinamide" value="{{ old('ingredients') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">ประเภทสกินแคร์</label>
                                    <select name="type" class="form-select">
                                        <option value="Cleanser" {{ old('type') == 'Cleanser' ? 'selected' : '' }}>Cleanser (ทำความสะอาด)</option>
                                        <option value="Serum" {{ old('type') == 'Serum' ? 'selected' : '' }}>Serum</option>
                                        <option value="Moisturizer" {{ old('type') == 'Moisturizer' ? 'selected' : '' }}>Moisturizer</option>
                                        <option value="Sunscreen" {{ old('type') == 'Sunscreen' ? 'selected' : '' }}>Sunscreen</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">ความเหมาะสมสำหรับผิวหน้า</label>
                                    <select name="skin_type" class="form-select">
                                        <option value="ทุกสภาพผิว" {{ old('skin_type') == 'ทุกสภาพผิว' ? 'selected' : '' }}>ซับโดย/ทุกสภาพผิว</option>
                                        <option value="ผิวมัน" {{ old('skin_type') == 'ผิวมัน' ? 'selected' : '' }}>ผิวมัน</option>
                                        <option value="ผิวแห้ง" {{ old('skin_type') == 'ผิวแห้ง' ? 'selected' : '' }}>ผิวแห้ง</option>
                                        <option value="ผิวแพ้ง่าย" {{ old('skin_type') == 'ผิวแพ้ง่าย' ? 'selected' : '' }}>ผิวแพ้ง่าย</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">ประเภทผิว</label>
                                    <select name="category" class="form-select">
                                        <option value="มัน" {{ old('category') == 'มัน' ? 'selected' : '' }}>มัน</option>
                                        <option value="แห้ง" {{ old('category') == 'แห้ง' ? 'selected' : '' }}>แห้ง</option>
                                        <option value="ผสม" {{ old('category') == 'ผสม' ? 'selected' : '' }}>ผสม</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">รายละเอียด / วิธีการใช้</label>
                                    <textarea name="description" class="form-control" rows="3"
                                            placeholder="เช่น ทาเช้า-เย็น หลีกเลี่ยงรอบดวงตา ...">{{ old('description') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </form> {{-- ปิด <form> ตรงนี้ --}}
            </div>

            <!-- Preview รูป -->
            <script>
                document.getElementById("imageInput").addEventListener("change", function(event) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e){
                            document.getElementById("previewImage").src = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        </section>



    <footer>
    </footer>

</body>
</html>

