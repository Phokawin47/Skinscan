<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skinscan - เพิ่มผลิตภัณฑ์</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <x-app-header />

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-buttons">
                        <a href="{{ route('product_management.create') }}" class="btn-primary">
                            <span>Add</span>
                        </a>
                        <a href="{{ route('product_management.edit') }}" class="btn-secondary">
                            <span>Products</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <h4 class="mb-4 text-center">เพิ่มผลิตภัณฑ์ใหม่</h4>
                
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row">
                        <!-- ส่วนซ้าย: รูปสินค้า -->
                        <div class="col-md-4">
                            <div class="card p-3">
                                <h5>รูปผลิตภัณฑ์</h5>
                                <input type="file" class="form-control" name="image" id="imageInput" required>
                                <div class="mt-3 text-center">
                                    <img id="previewImage" src="https://via.placeholder.com/200" class="img-fluid rounded" alt="preview">
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
                                    <input type="text" name="name" class="form-control" placeholder="เช่น เซรั่มบำรุง..." value="{{ old('name') }}" required>
                                </div>

                                <!-- แบรนด์ -->
                                <div class="mb-3">
                                    <label class="form-label">แบรนด์</label>
                                    <select name="selected_brand_id" id="brandSelect" class="form-select" required>
                                        <option value="">-- เลือกแบรนด์ --</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->brand_id }}" {{ old('selected_brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                        <option value="other_brand" {{ old('selected_brand_id') == 'other_brand' ? 'selected' : '' }}>
                                            อื่นๆ (ระบุ)
                                        </option>
                                    </select>
                                    @error('selected_brand_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Ingredients *** --}}

                                <!-- ช่องกรอกแบรนด์อื่นๆ -->
                                <div class="mb-3" id="newBrandInputContainer" style="display: {{ old('selected_brand_id') == 'other_brand' ? 'block' : 'none' }};">
                                    <label class="form-label">ระบุแบรนด์อื่นๆ</label>
                                    <input type="text" name="new_brand_name" id="newBrandInput" class="form-control" placeholder="ชื่อแบรนด์ใหม่" value="{{ old('new_brand_name') }}">
                                    @error('new_brand_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- สารที่เกี่ยวข้อง -->
                                <div class="mb-3">
                                    <label class="form-label d-block">สารที่เกี่ยวข้อง</label>
                                    <div class="form-check-group" style="max-height: 200px; overflow-y: auto;">
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

                                <!-- ช่องกรอกสารอื่นๆ -->
                                <div class="mb-3" id="newIngredientInputContainer" style="display: {{ in_array('other_ingredient', old('selected_ingredients', [])) ? 'block' : 'none' }};">
                                    <label class="form-label">ระบุสารอื่นๆ</label>
                                    <input type="text" name="new_ingredient_name" id="newIngredientInput" class="form-control" placeholder="ชื่อสารใหม่" value="{{ old('new_ingredient_name') }}">
                                    @error('new_ingredient_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ประเภทสกินแคร์ -->
                                <div class="mb-3">
                                    <label class="form-label">ประเภทสกินแคร์</label>
                                    <select name="selected_product_category_id" class="form-select" required>
                                        <option value="">-- เลือกประเภทสกินแคร์ --</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option value="{{ $productCategory->category_id }}" {{ old('selected_product_category_id') == $productCategory->category_id ? 'selected' : '' }}>
                                                {{ $productCategory->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_product_category_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ความเหมาะสมสำหรับผิวหน้า -->
                                <div class="mb-3">
                                    <label class="form-label">ความเหมาะสมสำหรับผิวหน้า</label>
                                    <select name="suitability_info" class="form-select" required>
                                        <option value="">-- เลือกความเหมาะสมสำหรับผิวหน้า --</option>
                                        @foreach ($suitabilityOptions as $option)
                                            <option value="{{ $option }}" {{ old('suitability_info') == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('suitability_info')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ประเภทผิว -->
                                <div class="mb-3">
                                    <label class="form-label">ประเภทผิว</label>
                                    <select name="selected_skin_type_id" class="form-select">
                                        <option value="">-- เลือกประเภทผิว --</option>
                                        @foreach ($skinTypes as $skinType)
                                            <option value="{{ $skinType->skin_type_id }}" {{ old('selected_skin_type_id') == $skinType->skin_type_id ? 'selected' : '' }}>
                                                {{ $skinType->skin_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_skin_type_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">รายละเอียด / วิธีการใช้</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="เช่น ทาเช้า-เย็น หลีกเลี่ยงรอบดวงตา ..." required>{{ old('description') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" id="submitButton">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer></footer>

    <script>
        // Preview รูป
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

        // JavaScript สำหรับ "แบรนด์อื่นๆ"
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
                newBrandInput.value = '';
            }
        }

        if (brandSelect) {
            brandSelect.addEventListener('change', toggleNewBrandInput);
        }
        document.addEventListener('DOMContentLoaded', toggleNewBrandInput);

        // ป้องกันการส่งฟอร์มซ้ำ
        document.getElementById('productForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
            document.getElementById('submitButton').innerText = 'กำลังบันทึก...';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>