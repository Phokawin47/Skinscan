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
    </header>
    <main>
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
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row">
                        <!-- ส่วนซ้าย: รูปสินค้า -->
                        <div class="col-md-4">
                            <div class="card p-3">
                                <h5>รูปผลิตภัณฑ์</h5>
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
                                    <input type="text" name="name" class="form-control" placeholder="เช่น เซรั่มบำรุง..." value="{{ old('name') }}">
                                </div>

                                {{-- *** ส่วนที่แก้ไข: แบรนด์ (ดึงจากตาราง brands) *** --}}
                                <div class="mb-3">
                                    <label class="form-label">แบรนด์</label>
                                    <select name="selected_brand_id" id="brandSelect" class="form-select">
                                        <option value="">-- เลือกแบรนด์ --</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->brand_id }}"
                                                {{ old('selected_brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                        <option value="other_brand"
                                            {{ old('selected_brand_id') == 'other_brand' ? 'selected' : '' }}>
                                            อื่นๆ (ระบุ)
                                        </option>
                                    </select>
                                    @error('selected_brand_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ช่องกรอกแบรนด์อื่นๆ (ซ่อนไว้ตอนแรก) --}}
                                <div class="mb-3" id="newBrandInputContainer" style="display: {{ old('selected_brand_id') == 'other_brand' ? 'block' : 'none' }};">
                                    <label class="form-label">ระบุแบรนด์อื่นๆ</label>
                                    <input type="text" name="new_brand_name" id="newBrandInput" class="form-control" placeholder="ชื่อแบรนด์ใหม่" value="{{ old('new_brand_name') }}">
                                    @error('new_brand_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Brand *** --}}

                                {{-- *** ส่วนที่แก้ไข: สารที่เกี่ยวข้อง (Checkboxes) *** --}}
                                <div class="mb-3">
                                    <label class="form-label d-block">สารที่เกี่ยวข้อง</label>
                                    <div class="form-check-group">
                                        @foreach ($ingredients as $ingredient)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="selected_ingredients[]"
                                                       id="ingredient-{{ $ingredient->ingredient_id }}" value="{{ $ingredient->ingredient_id }}"
                                                       {{ in_array($ingredient->ingredient_id, old('selected_ingredients', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ingredient-{{ $ingredient->ingredient_id }}">
                                                    {{ $ingredient->ingredient_name }}
                                                </label>
                                            </div>
                                        @endforeach

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="selected_ingredients[]"
                                                   id="otherIngredientCheckbox" value="other_ingredient"
                                                   {{ in_array('other_ingredient', old('selected_ingredients', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="otherIngredientCheckbox">
                                                สารอื่นๆ (ระบุ)
                                            </label>
                                        </div>
                                    </div>
                                    @error('selected_ingredients')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ช่องกรอกสารอื่นๆ (ซ่อนไว้ตอนแรก) --}}
                                <div class="mb-3" id="newIngredientInputContainer" style="display: {{ in_array('other_ingredient', old('selected_ingredients', [])) ? 'block' : 'none' }};">
                                    <label class="form-label">ระบุสารอื่นๆ</label>
                                    <input type="text" name="new_ingredient_name" id="newIngredientInput" class="form-control" placeholder="ชื่อสารใหม่" value="{{ old('new_ingredient_name') }}">
                                    @error('new_ingredient_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Ingredients *** --}}

                                {{-- *** ส่วนที่แก้ไข: ประเภทสกินแคร์ (ดึงจาก product_categories และเป็น Select Dropdown) *** --}}
                                <div class="mb-3">
                                    <label class="form-label">ประเภทสกินแคร์</label>
                                    <select name="selected_product_category_id" class="form-select">
                                        <option value="">-- เลือกประเภทสกินแคร์ --</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option value="{{ $productCategory->category_id }}"
                                                {{ old('selected_product_category_id') == $productCategory->category_id ? 'selected' : '' }}>
                                                {{ $productCategory->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_product_category_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Product Categories *** --}}

                                {{-- *** ส่วนที่แก้ไข: ความเหมาะสมสำหรับผิวหน้า (ดึงจาก suitability_info ในตาราง products) *** --}}
                                <div class="mb-3">
                                    <label class="form-label">ความเหมาะสมสำหรับผิวหน้า</label>
                                    <select name="suitability_info" class="form-select">
                                        <option value="">-- เลือกความเหมาะสมสำหรับผิวหน้า --</option>
                                        @foreach ($suitabilityOptions as $option)
                                            <option value="{{ $option }}"
                                                {{ old('suitability_info') == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('suitability_info')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Suitability Info *** --}}

                                {{-- *** ส่วนที่แก้ไข: ประเภทผิว (ดึงจาก skin_types และเป็น Select Dropdown) *** --}}
                                <div class="mb-3">
                                    <label class="form-label">ประเภทผิว</label>
                                    <select name="selected_skin_type_id" class="form-select">
                                        <option value="">-- เลือกประเภทผิว --</option>
                                        @foreach ($skinTypes as $skinType)
                                            <option value="{{ $skinType->skin_type_id }}"
                                                {{ old('selected_skin_type_id') == $skinType->skin_type_id ? 'selected' : '' }}>
                                                {{ $skinType->skin_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_skin_type_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Skin Types *** --}}

                                <div class="mb-3">
                                    <label class="form-label">รายละเอียด / วิธีการใช้</label>
                                    <textarea name="description" class="form-control" rows="3"
                                            placeholder="เช่น ทาเช้า-เย็น หลีกเลี่ยงรอบดวงตา ...">{{ old('description') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submitButton">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Preview รูป และ JavaScript สำหรับ "สารอื่นๆ" และ "แบรนด์อื่นๆ" -->
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

        // JavaScript สำหรับตัวเลือก "สารอื่นๆ"
        const otherIngredientCheckbox = document.getElementById('otherIngredientCheckbox');
        const newIngredientInputContainer = document.getElementById('newIngredientInputContainer');
        const newIngredientInput = document.getElementById('newIngredientInput');

        function toggleNewIngredientInput() {
            if (otherIngredientCheckbox && otherIngredientCheckbox.checked) {
                newIngredientInputContainer.style.display = 'block';
                newIngredientInput.setAttribute('required', 'required');
            } else {
                newIngredientInputContainer.style.display = 'none';
                newIngredientInput.removeAttribute('required');
                newIngredientInput.value = '';
            }
        }

        if (otherIngredientCheckbox) {
            otherIngredientCheckbox.addEventListener('change', toggleNewIngredientInput);
        }
        document.addEventListener('DOMContentLoaded', toggleNewIngredientInput);


        // *** JavaScript ใหม่สำหรับ "แบรนด์อื่นๆ" ***
        const brandSelect = document.getElementById('brandSelect');
        const newBrandInputContainer = document.getElementById('newBrandInputContainer');
        const newBrandInput = document.getElementById('newBrandInput');

        function toggleNewBrandInput() {
            if (brandSelect && brandSelect.value === 'other_brand') {
                newBrandInputContainer.style.display = 'block';
                newBrandInput.setAttribute('required', 'required');
            } else {
                newBrandInputContainer.style.display = 'none';
                newBrandInput.removeAttribute('required');
                newBrandInput.value = ''; // ล้างค่าในช่องกรอกเมื่อซ่อน
            }
        }

        if (brandSelect) {
            brandSelect.addEventListener('change', toggleNewBrandInput);
        }
        document.addEventListener('DOMContentLoaded', toggleNewBrandInput); // เรียกใช้ครั้งแรกเพื่อจัดการค่า old()
        // *** สิ้นสุด JavaScript สำหรับ "แบรนด์อื่นๆ" ***


        // JavaScript ป้องกันการส่งฟอร์มซ้ำซ้อน
        document.getElementById('productForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
            document.getElementById('submitButton').innerText = 'กำลังบันทึก...';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <footer>
    </footer>

</body>
</html>