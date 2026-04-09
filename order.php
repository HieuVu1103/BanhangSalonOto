<?php
// Bắt đầu bộ nhớ đệm để tránh lỗi headers
ob_start();

require_once 'header.php'; // header.php đã chứa session_start() và CSS/JS
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/Helper.php';

// Kiểm tra đăng nhập
$username = $_SESSION['TenTaiKhoan'] ?? '';
if (!$username) {
    echo "<script>alert('Vui lòng đăng nhập để tạo đơn đặt hàng!'); window.location='sign.php';</script>";
    exit;
}

// Lấy thông tin user
$userInfo = Database::GetData("SELECT TenDayDu, SDT, DiaChi FROM Users WHERE TenTaiKhoan='$username'");
$user = $userInfo[0] ?? null;
if (!$user) {
    echo "<script>alert('Người dùng không tồn tại!'); window.location='index.php';</script>";
    exit;
}

// Lấy giỏ hàng của user
$cartItems = Database::GetData("
    SELECT g.MaSP, g.SL, s.TenSP, IFNULL(s.GiaKhuyenMai, s.Gia) AS Gia, s.ThoiGianBaoHanh
    FROM GioHang g
    JOIN SanPham s ON g.MaSP = s.MaSP
    WHERE g.TenTaiKhoan = '$username'
");

if (!$cartItems || count($cartItems) == 0) {
    echo "<script>alert('Giỏ hàng trống, không thể tạo đơn hàng!'); window.location='index.php';</script>";
    exit;
}

// Tính tổng tiền
$TongTien = 0;
foreach($cartItems as $item){
    $TongTien += $item['Gia'] * $item['SL'];
}

$errorMsg = "";

// Xử lý submit tạo đơn
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $GhiChu = addslashes($_POST['GhiChu'] ?? '');
    $MaGiamGia = trim($_POST['MaGiamGia'] ?? '');
    $GiamGia = 0;

    // Xử lý mã giảm giá
    if ($MaGiamGia !== '') {
        $voucher = Database::GetData("SELECT * FROM MaGiamGia WHERE MaGiamGia='$MaGiamGia' AND HanSuDung >= CURDATE() AND SoLanSuDung > 0");
        if ($voucher && count($voucher) > 0) {
            $voucher = $voucher[0];
            if ($voucher['Kieu'] == 'AMOUNT') {
                $GiamGia = $voucher['GiaTri'];
            } elseif ($voucher['Kieu'] == 'PERCENT') {
                $GiamGia = $TongTien * $voucher['GiaTri'] / 100;
            }
            $TongTien = max(0, $TongTien - $GiamGia);
        } else {
            $errorMsg = "Mã giảm giá không hợp lệ hoặc đã hết hạn!";
        }
    }

    if ($errorMsg === "") {
        // Tạo đơn
        $TrangThai = 'ChoXuLy';
        $sql = "INSERT INTO dondathang (TenTaiKhoan, TongTien, TrangThai, GhiChu, MaGiamGia, GiamGia)
                VALUES ('$username', $TongTien, '$TrangThai', '$GhiChu', ".($MaGiamGia ? "'$MaGiamGia'" : "NULL").", $GiamGia)";
        $insertOrder = Database::NonQuery($sql);

        if ($insertOrder) {
            $MaDonDatHangID = Database::GetData("SELECT MAX(MaDonDatHang) as ID FROM dondathang WHERE TenTaiKhoan='$username'", ['cell'=>'ID']);

            // Thêm chi tiết đơn
            foreach($cartItems as $item){
                $MaSP = $item['MaSP'];
                $SL = $item['SL'];
                $DonGia = $item['Gia']; // đã xử lý khuyến mãi nếu có
                $ThoiGianBH = intval($item['ThoiGianBaoHanh'] ?? 0);
                $NgayBatDauBH = date('Y-m-d H:i:s');
                $NgayKetThucBH = date('Y-m-d H:i:s', strtotime("+$ThoiGianBH year", strtotime($NgayBatDauBH)));

                $sqlDetail = "INSERT INTO chitietdondathang (MaSP, MaDonDatHang, SL, DonGia, NgayBatDauBH, NgayKetThucBH)
                            VALUES ($MaSP, $MaDonDatHangID, $SL, $DonGia, '$NgayBatDauBH', '$NgayKetThucBH')";
                Database::NonQuery($sqlDetail);
            }

            // Xóa giỏ hàng
            Database::NonQuery("DELETE FROM GioHang WHERE TenTaiKhoan='$username'");

            // Chuyển sang trang thanh toán
            header("Location: pay.php?MaDonDatHang=$MaDonDatHangID");
            exit;
        } else {
            $errorMsg = "Lỗi khi tạo đơn đặt hàng!";
        }
    }
}

ob_end_flush(); // gửi output ra
?>


<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Tạo đơn đặt hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="product-content-right">
            <div class="woocommerce">

                <?php if ($errorMsg != ""): ?>
                    <div class="alert alert-danger"><?= $errorMsg ?></div>
                <?php endif; ?>

                <div class="alert alert-warning mb-4">
                    <strong><i class="fa fa-clock-o"></i> Lưu ý quan trọng:</strong> 
                    Đơn hàng sẽ tự động bị hủy nếu bạn không thanh toán trong vòng <strong>15 phút</strong> kể từ khi tạo đơn.
                    Vui lòng hoàn tất thanh toán sớm nhất có thể.
                </div>

                <!-- Thông tin người đặt -->
                <div class="payment-card mb-4">
                    <h2>Thông tin người đặt</h2>
                    <p><strong>Tên đầy đủ:</strong> <?= htmlspecialchars($user['TenDayDu']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['SDT']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['DiaChi']) ?></p>
                </div>

                <form method="POST">
                    <!-- Bảng giỏ hàng -->
                    <table cellspacing="0" class="shop_table cart">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr class="cart_item">
                                    <td><?= $item['MaSP'] ?></td>
                                    <td><?= htmlspecialchars($item['TenSP']) ?></td>
                                    <td><?= number_format($item['Gia']) ?> đ</td>
                                    <td><?= $item['SL'] ?></td>
                                    <td><?= number_format($item['Gia'] * $item['SL']) ?> đ</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                                <td><strong class="text-danger"><?= number_format($TongTien) ?> đ</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- mã giảm giá -->
                    <div class="form-group mt-3">
                        <label>Mã giảm giá (nếu có)</label>
                        <input type="text" name="MaGiamGia" class="form-control" placeholder="Nhập mã giảm giá">
                    </div>

                    <!-- Ghi chú -->
                    <div class="form-group mt-3">
                        <label>Ghi chú</label>
                        <textarea name="GhiChu" class="form-control" rows="3" placeholder="Nhập ghi chú nếu có"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg mt-3">Tạo đơn đặt hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>