<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skinscan - จัดการผลิตภัณฑ์</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
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
                <h4 class="mb-4 text-center">สินค้าทั้งหมด</h4>
                
                @if($products->count() > 0)
                    <div class="row" id="product-list">
                        @foreach($products as $product)
                        <div class="col-md-4 mb-4" id="product-{{ $product->product_id }}">
                            <div class="card h-100">
                                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                    <p class="card-text">
                                        <strong>รายละเอียด:</strong><br>
                                        <span class="usage-details">{{ $product->usage_details }}</span>
                                    </p>
                                    <p class="card-text">
                                        <strong>ความเหมาะสม:</strong><br>
                                        <span class="suitability-info">{{ $product->suitability_info }}</span>
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-warning edit-btn"
                                            data-id="{{ $product->product_id }}"
                                            data-usage-details="{{ $product->usage_details }}"
                                            data-suitability-info="{{ $product->suitability_info }}">
                                        <i class="fas fa-edit"></i> แก้ไข
                                    </button>
                                    <button class="btn btn-danger delete-btn" data-id="{{ $product->product_id }}">
                                        <i class="fas fa-trash"></i> ลบ
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center">
                        <p class="text-muted">ยังไม่มีสินค้าในระบบ</p>
                        <a href="{{ route('product_management.create') }}" class="btn btn-primary">เพิ่มสินค้าแรก</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer></footer>

    <!-- Modal สำหรับแก้ไขข้อมูล -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                            <textarea class="form-control" id="edit-usage-details" name="usage_details" rows="9"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-suitability-info" class="form-label">ความเหมาะสม</label>
                            <textarea class="form-control" id="edit-suitability-info" name="suitability_info" rows="3"></textarea>
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
        // ตัดคำ/ย่อ-ขยาย ข้อความรายละเอียด
        var charLimit = 100;

        function truncateText(element) {
            var fullText = element.data('full-text') || element.text();
            element.data('full-text', fullText);

            if (fullText.length > charLimit) {
                var truncatedText = fullText.substring(0, charLimit) + '...';
                element.data('truncated-text', truncatedText);

                if (element.next('.read-more-btn').text() === ' ย่อ') {
                     element.text(fullText);
                } else {
                     element.text(truncatedText);
                }

                if (element.next('.read-more-btn').length === 0) {
                    element.after('<a href="javascript:void(0);" class="read-more-btn text-primary"> ดูเพิ่มเติม</a>');
                } else {
                    element.next('.read-more-btn').text(element.text().length > charLimit ? ' ดูเพิ่มเติม' : ' ย่อ');
                }
            } else {
                element.text(fullText);
                if (element.next('.read-more-btn').length > 0) {
                    element.next('.read-more-btn').remove();
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

        // เปิด Modal แก้ไข
        $(document).on('click', '.edit-btn', function() {
            var productId = $(this).data('id');
            var usageDetails = $(this).data('usage-details');
            var suitabilityInfo = $(this).data('suitability-info');

            // Clear and set values
            $('#edit-product-id').val(productId);
            $('#edit-usage-details').prop('readonly', false).prop('disabled', false).val(usageDetails);
            $('#edit-suitability-info').prop('readonly', false).prop('disabled', false).val(suitabilityInfo);
            
            $('#editProductModal').modal('show');
        });

        // บันทึกข้อมูล
        $('#saveChangesBtn').on('click', function () {
            var productId = $('#edit-product-id').val();
            var usageDetails = $('#edit-usage-details').val();
            var suitabilityInfo = $('#edit-suitability-info').val();

            // Disable button to prevent double submission
            $(this).prop('disabled', true).text('กำลังบันทึก...');

            $.ajax({
                url: '/products/' + productId,
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
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
                    truncateText(productCard.find('.usage-details'));
                },
                error: function (xhr) {
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                },
                complete: function() {
                    $('#saveChangesBtn').prop('disabled', false).text('บันทึก');
                }
            });
        });

        // ลบสินค้า
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
                            productCard.fadeOut('slow', function() { 
                                $(this).remove(); 
                                
                                // Check if no products left
                                if ($('#product-list .col-md-4').length === 0) {
                                    $('#product-list').html(
                                        '<div class="col-12 text-center">' +
                                        '<p class="text-muted">ยังไม่มีสินค้าในระบบ</p>' +
                                        '<a href="{{ route("product_management.create") }}" class="btn btn-primary">เพิ่มสินค้าแรก</a>' +
                                        '</div>'
                                    );
                                }
                            });
                            
                            // Show success message
                            $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                              response.message +
                              '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                              '</div>').prependTo('.container').delay(3000).fadeOut();
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