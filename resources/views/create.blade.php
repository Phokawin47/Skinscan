<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Product Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
</body>
</html>
