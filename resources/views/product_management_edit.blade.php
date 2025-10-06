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
            // ===== ตัดคำ/ย่อ-ขยาย ข้อความรายละเอียด =====
            var charLimit = 100;

            $('.usage-details').each(function() {
                var fullText = $(this).text();
                if (fullText.length > charLimit) {
                    var truncatedText = fullText.substring(0, charLimit) + '...';
                    $(this).data('full-text', fullText);
                    $(this).data('truncated-text', truncatedText);
                    $(this).text(truncatedText);
                    $(this).after('<a href="javascript:void(0);" class="read-more-btn"> ดูเพิ่มเติม</a>');
                }
            });

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

            // ===== เปิด Modal แก้ไข =====
            $('#editProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var productId = button.data('id');
                var usageDetails = button.data('usage-details');
                var suitabilityInfo = button.data('suitability-info');

                var modal = $(this);
                modal.find('#edit-product-id').val(productId);
                modal.find('#edit-usage-details').val(usageDetails);
                modal.find('#edit-suitability-info').val(suitabilityInfo);
            });

            // ===== บันทึกข้อมูล =====
            $('#saveChangesBtn').on('click', function () {
                var productId = $('#edit-product-id').val();
                var usageDetails = $('#edit-usage-details').val();
                var suitabilityInfo = $('#edit-suitability-info').val();

                $.ajax({
                    url: '/products/' + productId,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT',
                        usage_details: usageDetails,
                        suitability_info: suitabilityInfo
                    },
                    success: function (response) {
                        var productCard = $('#product-' + response.product_id);
                        productCard.find('.usage-details').text(response.usage_details);
                        productCard.find('.suitability-info').text(response.suitability_info);

                        var editButton = productCard.find('.edit-btn');
                        editButton.data('usage-details', response.usage_details);
                        editButton.data('suitability-info', response.suitability_info);

                        $('#editProductModal').modal('hide');
                        alert('บันทึกข้อมูลสำเร็จ!');
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                        console.log(xhr.responseText);
                    }
                });
            });

            // ===== ลบสินค้า =====
            $('#product-list').on('click', '.delete-btn', function () {
                var productId = $(this).data('id');
                var productCard = $('#product-' + productId);

                if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?')) {
                    $.ajax({
                        url: '/products/' + productId,
                        type: 'POST',
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
    </section>

    <footer></footer>
</body>
</html>
