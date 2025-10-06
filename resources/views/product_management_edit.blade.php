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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Skinscan</title>
    {{-- *** สำคัญ: CSRF Token สำหรับ AJAX requests *** --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- ใช้ Header รวม เพื่อไม่หลุดเราต์อีก -->
    <x-app-header />

    <main></main>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-buttons">
                    <!-- เปลี่ยนชื่อเราต์ให้ถูกต้อง -->
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
            <h4 class="mb-4 text-center">สินค้าทั้งหมด</h4>
            <div class="row" id="product-list">
                @foreach($products as $product)
                <div class="col-md-4 mb-4" id="product-{{ $product->product_id }}">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->product_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <p class="card-text">
                                รายละเอียด:
                                <span class="usage-details">{{ $product->usage_details }}</span>
                            </p>
                            <p class="card-text">
                                ความเหมาะสม:
                                <span class="suitability-info">{{ $product->suitability_info }}</span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-warning edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProductModal"
                                    data-id="{{ $product->product_id }}"
                                    data-usage-details="{{ $product->usage_details }}"
                                    data-suitability-info="{{ $product->suitability_info }}">
                                แก้ไข
                            </button>
                            <button class="btn btn-danger delete-btn" data-id="{{ $product->product_id }}">ลบ</button>
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
                @endforeach
            </div>
        </div>

        <!-- Modal สำหรับแก้ไขข้อมูล -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">แก้ไขข้อมูลสินค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <input type="hidden" id="edit-product-id" name="product_id">
                            <div class="mb-3">
                                <label for="edit-usage-details" class="form-label">รายละเอียด</label>
                                <textarea class="form-control" id="edit-usage-details" name="usage_details" rows="9" required></textarea>
            <div class="container mt-4">
                <h4 class="mb-4 text-center">สินค้าทั้งหมด</h4>
                <div class="row" id="product-list">
                    @foreach($products as $product)
                    <div class="col-md-4 mb-4" id="product-{{ $product->product_id }}">
                        <div class="card h-100">
                            {{-- ใช้ $product->image_url เพื่อให้เรียกใช้ Accessor ใน Product Model --}}
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text">รายละเอียด: <span class="usage-details">{{ $product->usage_details }}</span></p>
                                <p class="card-text">ความเหมาะสม: <span class="suitability-info">{{ $product->suitability_info }}</span></p>
                            </div>
                            <div class="mb-3">
                                <label for="edit-suitability-info" class="form-label">ความเหมาะสม</label>
                                <textarea class="form-control" id="edit-suitability-info" name="suitability_info" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer>
        {{-- ... footer content ... --}}
    </footer>

    <!-- Modal สำหรับแก้ไขข้อมูล - ควรวางไว้ก่อนปิดแท็ก </body> เพื่อการแสดงผลที่ถูกต้อง -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">แก้ไขข้อมูลสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="edit-product-id" name="product_id">
                        <div class="mb-3">
                            <label for="edit-usage-details" class="form-label">รายละเอียด</label>
                            <textarea class="form-control" id="edit-usage-details" name="usage_details" rows="9" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-suitability-info" class="form-label">ความเหมาะสม</label>
                            <textarea class="form-control" id="edit-suitability-info" name="suitability_info" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">บันทึก</button>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function () {

        // =================================================================
        // ===== โค้ดสำหรับทำ "ดูเพิ่มเติม / ย่อ" (Read More / Less) =====
        // =================================================================
        var charLimit = 100; // กำหนดจำนวนตัวอักษรสูงสุดที่จะแสดง

        // ฟังก์ชันสำหรับย่อข้อความ
        function truncateText(element) {
            var fullText = element.data('full-text') || element.text(); // ดึง fullText จาก data attribute หรือจาก text() ปัจจุบัน
            element.data('full-text', fullText); // เก็บ fullText ไว้เสมอ

            if (fullText.length > charLimit) {
                var truncatedText = fullText.substring(0, charLimit) + '...'; // สร้างข้อความที่ถูกย่อ
                element.data('truncated-text', truncatedText); // เก็บ truncatedText ไว้

                // อัปเดตข้อความที่แสดง
                if (element.next('.read-more-btn').text() === ' ย่อ') { // ถ้าปัจจุบันเป็น "ย่อ" คือกำลังแสดงข้อความเต็มอยู่
                     element.text(fullText);
                } else { // เป็น "ดูเพิ่มเติม" หรือยังไม่มีปุ่ม ให้แสดงข้อความที่ถูกย่อ
                     element.text(truncatedText);
                }


                if (element.next('.read-more-btn').length === 0) { // ถ้ายังไม่มีปุ่ม ให้เพิ่ม
                    element.after('<a href="javascript:void(0);" class="read-more-btn"> ดูเพิ่มเติม</a>');
                } else { // ถ้ามีแล้ว ให้เปลี่ยนเป็น ดูเพิ่มเติม
                    element.next('.read-more-btn').text(element.text().length > charLimit ? ' ดูเพิ่มเติม' : ' ย่อ');
                }
            } else { // ถ้าข้อความไม่ยาวพอ ไม่ต้องย่อ
                element.text(fullText); // แสดงข้อความเต็ม
                if (element.next('.read-more-btn').length > 0) {
                    element.next('.read-more-btn').remove(); // ลบปุ่มถ้ามี
                }
            }
        }


        // เรียกใช้ฟังก์ชันย่อข้อความเมื่อโหลดหน้า
        $('.usage-details').each(function() {
            truncateText($(this));
        });


        // จัดการ Event Click บนลิงก์ "ดูเพิ่มเติม / ย่อ"
        $('#product-list').on('click', '.read-more-btn', function () {
            var detailsSpan = $(this).prev('.usage-details');

            if ($(this).text() === ' ดูเพิ่มเติม') {
                detailsSpan.text(detailsSpan.data('full-text'));
                $(this).text(' ย่อ');
            } else {
                detailsSpan.text(detailsSpan.data('truncated-text'));
                $(this).text(' ดูเพิ่มเติม');
            }
        });


        // --- โค้ดสำหรับ Modal แก้ไข ---
        $('#editProductModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('id');
            // ดึงข้อมูล *เต็ม* จาก data attribute ของปุ่มแก้ไข
            var usageDetails = button.data('usage-details');
            var suitabilityInfo = button.data('suitability-info');

            var modal = $(this);
            modal.find('#edit-product-id').val(productId);
            modal.find('#edit-usage-details').val(usageDetails);
            modal.find('#edit-suitability-info').val(suitabilityInfo);
        });

        // --- โค้ดสำหรับปุ่ม "บันทึก" ใน Modal ---
        $('#saveChangesBtn').on('click', function () {
            var productId = $('#edit-product-id').val();
            var usageDetails = $('#edit-usage-details').val();
            var suitabilityInfo = $('#edit-suitability-info').val();

            $.ajax({
                url: '/products/' + productId,
                type: 'PUT', // **แก้ไข: เปลี่ยนเป็น 'PUT'**
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    usage_details: usageDetails,
                    suitability_info: suitabilityInfo
                },
                success: function (response) {
                    var productCard = $('#product-' + response.product_id);
                    // อัปเดตข้อความบนการ์ด
                    productCard.find('.usage-details').text(response.usage_details);
                    productCard.find('.suitability-info').text(response.suitability_info);

                    // อัปเดต data attributes ของปุ่มแก้ไข เพื่อให้ข้อมูลใน Modal ถูกต้องเมื่อเปิดอีกครั้ง
                    var editButton = productCard.find('.edit-btn');
                    editButton.data('usage-details', response.usage_details);
                    editButton.data('suitability-info', response.suitability_info);

                    $('#editProductModal').modal('hide');
                    alert('บันทึกข้อมูลสำเร็จ!');

                    // **สำคัญ:** หลังจากแก้ไขข้อมูลแล้ว ต้องเรียกใช้ฟังก์ชันย่อ/ขยายข้อความใหม่อีกครั้ง
                    // เรียกใช้กับ element ที่เพิ่งถูกแก้ไขโดยตรง
                    truncateText(productCard.find('.usage-details'));

                    // location.reload(); // คอมเมนต์ออกชั่วคราวเพื่อดีบัก ไม่ต้องโหลดหน้าใหม่ทั้งหมด
                },
                error: function (xhr) {
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                    console.log(xhr.responseText); // **ดูใน Console (F12) เพื่อหาข้อผิดพลาดที่แท้จริง**
                }
            });
        });

        // --- โค้ดสำหรับปุ่ม "ลบ" ---
        $('#product-list').on('click', '.delete-btn', function () {
            var productId = $(this).data('id');
            var productCard = $('#product-' + productId);

            if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?')) {
                $.ajax({
                    url: '/products/' + productId,
                    type: 'POST', // สำหรับ DELETE Laravel ก็ต้องการ _method: 'DELETE' ผ่าน POST
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function (response) {
                        if (response.success) {
                            productCard.fadeOut('slow', function() { $(this).remove(); });
                            alert(response.message);
                        } else {
                            alert('เกิดข้อผิดพลาด: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
