<?php
include '../../config/config.php';
include '../../config/database.php';
include '../../config/Helper.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In hoá đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .main-logo { width: 322px; height: 100px; }
    </style>
</head>

<?php
// Lấy order-id từ URL (MaDonDatHang)
$orderID = $_GET['order-id'] ?? '';

// 1. Lấy hóa đơn dựa trên MaDonDatHang
$sqlInvoice = "SELECT h.MaHoaDon, h.MaDonDatHang, h.TongTien, h.GhiChu,
                      d.TenTaiKhoan, d.MaGiamGia, d.GiamGia, d.CreatedAt, d.TrangThai,
                      u.TenDayDu AS Fullname, u.SDT AS Phone, u.Email, u.DiaChi
               FROM hoadon h
               JOIN dondathang d ON h.MaDonDatHang = d.MaDonDatHang
               JOIN users u ON d.TenTaiKhoan = u.TenTaiKhoan
               WHERE h.MaDonDatHang = '$orderID'";

$invoice = Database::GetData($sqlInvoice, ['row' => 0]);

if (!$invoice) {
    die('<div class="alert alert-danger text-center">Hóa đơn không tồn tại.</div>');
}

// 2. Lấy chi tiết hóa đơn từ MaHoaDon
$MaHoaDon = $invoice['MaHoaDon'];

// Lấy giá khuyến mãi nếu có
$sqlItems = "SELECT MaSP, TenSP, SL, Gia, NgayBatDauBH, NgayKetThucBH
             FROM chitiethoadon
             WHERE MaHoaDon = '$MaHoaDon'";
$items = Database::GetData($sqlItems);
?>

<body>
<div class="container">
    <div class="text-primary text-center pb-5">
        <h4><b>Cửa hàng bán phụ kiện Thế giới oto</b></h4>
        <img class="main-logo" src="<?='/Salonoto/assets/img/logo.png'?>" alt="Logo">
    </div>

    <h3 class="text-primary text-center pb-5"><b>HOÁ ĐƠN</b></h3>

    <!-- Thông tin khách hàng -->
    <div class="pb-5">
        <h5 class="text-primary"><b>THÔNG TIN KHÁCH HÀNG</b></h5>
        <p><b>Họ và tên:</b> <?= $invoice['Fullname'] ?? '-' ?></p>
        <p><b>Số điện thoại:</b> <?= $invoice['Phone'] ?? '-' ?></p>
        <p><b>Email:</b> <?= $invoice['Email'] ?? '-' ?></p>
        <p><b>Địa chỉ:</b> <?= $invoice['DiaChi'] ?? '-' ?></p>
        <p><b>Ngày lập:</b> <?= $invoice['CreatedAt'] ? Helper::DateTime($invoice['CreatedAt'], true) : '-' ?></p>
    </div>

    <!-- Chi tiết hóa đơn -->
    <div class="pb-5">
        <h5 class="text-primary"><b>CHI TIẾT HOÁ ĐƠN</b></h5>
        <table class="table table-hover table-bordered">
            <thead class="table-success">
                <tr>
                    <th>Mã Sản phẩm</th>
                    <th>Tên Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Ngày bắt đầu BH</th>
                    <th>Ngày kết thúc BH</th>
                </tr>
            </thead>
            <tbody>
                    <?php if ($items): ?>
                        <?php foreach ($items as $item): 
                            $GiaThanhToan = $item['Gia'];
                            $ThanhTien = $GiaThanhToan * $item['SL'];
                        ?>
                            <tr>
                                <th><?= $item['MaSP'] ?? '-' ?></th>
                                <td><?= $item['TenSP'] ?? '-' ?></td>
                                <td><?= Helper::Currency($GiaThanhToan) ?></td>
                                <td><?= $item['SL'] ?? 0 ?></td>
                                <td><?= Helper::Currency($ThanhTien) ?></td>
                                <td><?= $item['NgayBatDauBH'] ? Helper::DateTime($item['NgayBatDauBH'], true) : '-' ?></td>
                                <td><?= $item['NgayKetThucBH'] ? Helper::DateTime($item['NgayKetThucBH'], true) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                    <?php endif; ?>
            </tbody>
        </table>

        <!-- Mã giảm giá & Giảm giá -->
        <div class="mb-3 text-end">
            <p><b>Mã giảm giá:</b> <?= !empty($invoice['MaGiamGia']) ? $invoice['MaGiamGia'] : '-' ?></p>
            <p><b>Giảm giá:</b> <?= !empty($invoice['GiamGia']) ? Helper::Currency($invoice['GiamGia']) : '0 ₫' ?></p>
        </div>

        <!-- Tổng tiền -->
        <div class="text-end">
            <p><b>Tổng tiền:</b> <?= Helper::Currency($invoice['TongTien'] ?? 0) ?></p>
            <p><b>Phí vận chuyển:</b> 0 ₫</p>
            <?php if (($invoice['TrangThai'] ?? '') == 'DaHoanThanh'): ?>
                <img style="height: 150px;" src="<?='/Salonoto/assets/img/paid-logo.jpg'?>" alt="Đã thanh toán">
            <?php endif; ?>
        </div>
    </div>

    <div class="text-center mb-5">
        <button onclick="window.print();" class="btn btn-primary btn-lg"><b>In hoá đơn</b></button>
    </div>
</div>
</body>
</html>
