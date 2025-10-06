<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skinscan</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Header (ใช้ header รวมของโปรเจกต์) -->
    <x-app-header />

    <main></main>

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
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <!-- ซ้าย: รูปสินค้า -->
            <div class="col-md-4">
              <div class="card p-3">
                <h5>รูปผลิตภัณฑ์</h5>
                <input type="file" class="form-control" name="image" id="imageInput">
                <div class="mt-3 text-center">
                  <img id="previewImage" src="https://via.placeholder.com/200" class="img-fluid rounded" alt="preview">
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
            </div>

            <!-- ขวา: รายละเอียด -->
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

                <div class="mb-3">
                  <label class="form-label">สารที่เกี่ยวข้อง</label>
                  <input type="text" name="ingredients" class="form-control" placeholder="เช่น Salicylic Acid, Niacinamide" value="{{ old('ingredients') }}">
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
                                {{-- *** สิ้นสุดส่วนที่แก้ไข Ingredients *** --}}

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
                  <textarea name="description" class="form-control" rows="3" placeholder="เช่น ทาเช้า-เย็น หลีกเลี่ยงรอบดวงตา ...">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
              </div>
            </div>
          </div>
        </form>
      </div>

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

    <footer></footer>
</body>
</html>
</html>
