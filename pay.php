<?php
// thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

include 'header.php'; 

if (!isset($_SESSION['TenTaiKhoan'])) {
    echo "<script>alert('Vui lòng đăng nhập để thanh toán!'); window.location='sign.php';</script>";
    exit;
}

$username = $_SESSION['TenTaiKhoan'];

$MaDonDatHang = isset($_GET['MaDonDatHang']) ? intval($_GET['MaDonDatHang']) : 0;
if (!$MaDonDatHang) {
    echo "<script>alert('Không tìm thấy đơn hàng!'); window.location='index.php';</script>";
    exit;
}

// lấy thông tin đơn hàng
$orderInfo = Database::GetData("SELECT * FROM dondathang WHERE MaDonDatHang=$MaDonDatHang AND TenTaiKhoan='$username'");
if (!$orderInfo || count($orderInfo) == 0) {
    echo "<script>alert('Đơn hàng không tồn tại!'); window.location='index.php';</script>";
    exit;
}
$order = $orderInfo[0];

if ($order['TrangThai'] == 'Huy') {
    echo "<script>alert('Đơn hàng này đã bị hủy do quá thời gian thanh toán!'); window.location='index.php';</script>";
    exit;
}

// kiểm tra xem đã thanh toán chưa
$paymentCheck = Database::GetData("SELECT MaTT FROM thanhtoan WHERE MaDonDatHang=$MaDonDatHang");
if ($paymentCheck && count($paymentCheck) > 0) {
    echo "<script>alert('Đơn hàng này đã được thanh toán!'); window.location='index.php';</script>";
    exit;
}

// lấy thông tin user
$userInfo = Database::GetData("SELECT TenDayDu, SDT, DiaChi FROM Users WHERE TenTaiKhoan='$username'");
if (!$userInfo || count($userInfo) == 0) {
    echo "<script>alert('Không tìm thấy thông tin người dùng!'); window.location='index.php';</script>";
    exit;
}
$user = $userInfo[0];

// lấy chi tiết đơn hàng
$cartItems = Database::GetData("
    SELECT c.MaSP, c.SL, s.TenSP, IFNULL(s.GiaKhuyenMai, s.Gia) AS Gia
    FROM chitietdondathang c
    JOIN SanPham s ON c.MaSP = s.MaSP
    WHERE c.MaDonDatHang=$MaDonDatHang
");

if (!$cartItems || count($cartItems) == 0) {
    echo "<script>alert('Không tìm thấy chi tiết đơn hàng!'); window.location='index.php';</script>";
    exit;
}

// tính tổng tiền từ chi tiết
$TongTien = 0;
foreach($cartItems as $item){
    $TongTien += $item['Gia'] * $item['SL'];
}

// lấy mã giảm giá và giá trị
$MaGiamGia = $order['MaGiamGia'] ?? '';
$GiamGia = floatval($order['GiamGia'] ?? 0);
$TongTienSauGiam = max(0, $TongTien - $GiamGia);

// tính thời gian còn lại 
$createdTime = strtotime($order['CreatedAt']);
$currentTime = time();
$timeElapsed = $currentTime - $createdTime; 
$remainingSeconds = max(0, (15 * 60) - $timeElapsed);

// hết thời gian, tự động hủy đơn
if ($remainingSeconds <= 0) {
    $updateSql = "UPDATE dondathang 
                  SET TrangThai = 'Huy', 
                      GhiChu = CONCAT(IFNULL(GhiChu, ''), ' [Tự động hủy do quá thời gian thanh toán]') 
                  WHERE MaDonDatHang = $MaDonDatHang";
    Database::NonQuery($updateSql);
    echo "<script>alert('Đơn hàng đã bị hủy do quá thời gian thanh toán (15 phút)!'); window.location='index.php';</script>";
    exit;
}

// form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $GhiChu = isset($_POST['GhiChu']) ? addslashes(trim($_POST['GhiChu'])) : '';
    $PhuongThucTT = isset($_POST['PhuongThucTT']) ? $_POST['PhuongThucTT'] : 'COD';

    if (!empty($GhiChu)) {
        Database::NonQuery("UPDATE dondathang SET GhiChu='$GhiChu' WHERE MaDonDatHang=$MaDonDatHang");
    }
    
    $MaGiaoDich = "GD" . date('YmdHis') . rand(100, 999);
    
    $insertPaymentSql = "INSERT INTO thanhtoan 
        (MaDonDatHang, TenTaiKhoan, TongTien, PhuongThucTT, GhiChu, MaGiaoDich)
        VALUES ($MaDonDatHang, '$username', $TongTienSauGiam, '$PhuongThucTT', '$GhiChu', '$MaGiaoDich')";
    
    if (Database::NonQuery($insertPaymentSql)) {
        echo "<script>alert('Đơn hàng của bạn đã được tạo và đang chờ xử lý!'); window.location='index.php';</script>";
        exit;
    } else {
        $errorMsg = "Có lỗi khi xử lý thanh toán. Vui lòng thử lại!";
    }
}
?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Thanh toán đơn hàng #<?= $MaDonDatHang ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body { font-family: Arial, Helvetica, sans-serif; }
.payment-container { padding: 50px 0; background: #f4f4f4; }
.payment-card { 
    background: #fff; 
    padding: 30px; 
    border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
    border: 1px solid #e3e3e3; 
}
.payment-card h2, .payment-card h4 { color: #1976d2; margin-bottom: 20px; }
.btn-brand { 
    background-color: #1976d2; 
    border: none; 
    color: #fff; 
    font-weight: bold; 
    font-size: 16px; 
    padding: 12px; 
    border-radius: 5px; 
    transition: 0.3s; 
    width: 100%; 
}
.btn-brand:hover { background-color: #1565c0; }
.form-check-label { cursor: pointer; }
.form-group label { font-weight: bold; }

/* Style đếm ngược đơn giản */
.countdown-timer {
    background: #f8f9fa;
    color: #333;
    border: 2px solid #1976d2;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 20px;
}
</style>

<div class="payment-container">
    <div class="container">
        <div class="row">

            <!-- Thông tin người đặt -->
            <div class="col-md-7">
                <!-- Đếm ngược thời gian -->
                <div class="countdown-timer" id="countdownTimer">
                    <i class="fa fa-clock-o"></i> 
                    Thời gian thanh toán còn lại: <span id="timeDisplay">15:00</span>
                </div>

                <?php if (isset($errorMsg)): ?>
                    <div class="alert alert-danger"><?= $errorMsg ?></div>
                <?php endif; ?>

                <div class="payment-card mb-4">
                    <h2>Thông tin người đặt</h2>
                    <p><strong>Tên:</strong> <?= htmlspecialchars($user['TenDayDu']) ?></p>
                    <p><strong>SĐT:</strong> <?= htmlspecialchars($user['SDT']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['DiaChi']) ?></p>
                    <div class="form-group mt-3">
                        <label>Ghi chú (tuỳ chọn)</label>
                        <textarea name="GhiChu" form="paymentForm" class="form-control" rows="3" placeholder="Nhập yêu cầu đặc biệt nếu có"><?= htmlspecialchars($order['GhiChu'] ?? '') ?></textarea>
                    </div>
                    <!-- <p><strong>Lưu ý khi thanh toán:</strong> Nếu bạn thanh toán bằng chuyển khoản ngân hàng hoặc Momo, hãy nhập đúng số tiền và nội dung chuyển khoản theo cú pháp:</p>
                    <p><strong>Tên - SĐT - Mã đơn hàng</strong>: <?= htmlspecialchars($user['TenDayDu']) ?> - <?= htmlspecialchars($user['SDT']) ?> - <?= htmlspecialchars($order['MaDonDatHang'] ?? '') ?></p> -->
                </div>
            </div>

            <!-- Đơn hàng & phương thức thanh toán -->
            <div class="col-md-5">
                <div class="payment-card">
                    <h2>Đơn hàng của bạn</h2>

                    <ul class="list-group mb-3">
                        <?php foreach($cartItems as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($item['TenSP'] . " × " . $item['SL']) ?>
                                <span><?= number_format($item['Gia'] * $item['SL']) ?> đ</span>
                            </li>
                        <?php endforeach; ?>
                        
                        <?php if($MaGiamGia): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Mã giảm giá (<?= htmlspecialchars($MaGiamGia) ?>)</strong>
                                <strong class="text-success">- <?= number_format($GiamGia) ?> đ</strong>
                            </li>
                        <?php endif; ?>
                        
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Tổng cộng</strong>
                            <strong class="text-danger"><?= number_format($TongTienSauGiam) ?> đ</strong>
                        </li>
                    </ul>

                    <form method="POST" id="paymentForm">
                        <h4>Phương thức thanh toán</h4>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="PhuongThucTT" value="COD" id="cod" checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="PhuongThucTT" value="ChuyenKhoan" id="bank">
                            <label class="form-check-label" for="bank">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>
                        <div id="bank-info" class="p-3 border rounded bg-light mb-3" style="display:none;">
                            <p><strong>Ngân hàng:</strong> Techcombank</p>
                            <p><strong>Số tài khoản:</strong> 0123456789</p>
                            <p><strong>Chủ tài khoản:</strong> NGUYEN VAN A</p>
                            <p><strong>Nội dung:</strong> <?= htmlspecialchars($user['TenDayDu']) ?> - <?= htmlspecialchars($user['SDT']) ?> - <?= htmlspecialchars($order['MaDonDatHang'] ?? '') ?></p>
                            <img src="assets/img/tech.jpg" alt="QR Bank" style="max-width:100%; height:auto; margin-top:10px;">
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="PhuongThucTT" value="Momo" id="momo">
                            <label class="form-check-label" for="momo">
                                Thanh toán qua Momo
                            </label>
                        </div>
                        <div id="momo-info" class="p-3 border rounded bg-light mb-3" style="display:none;">
                            <p><strong>Ví điện tử:</strong> Momo</p>
                            <p><strong>Số điện thoại:</strong> 0987654321</p>
                            <p><strong>Chủ tài khoản:</strong> NGUYEN VAN B</p>
                            <p><strong>Nội dung:</strong> <?= htmlspecialchars($user['TenDayDu']) ?> - <?= htmlspecialchars($user['SDT']) ?> - <?= htmlspecialchars($order['MaDonDatHang'] ?? '') ?></p>
                            <img src="assets/img/momo.jpg" alt="QR Momo" style="max-width:100%; height:auto; margin-top:10px;">
                        </div>

                        <button type="submit" class="btn btn-brand btn-lg">
                            Xác nhận thanh toán
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Đếm ngược thời gian 
let remainingSeconds = <?= $remainingSeconds ?>;

function updateCountdown() {
    const display = document.getElementById('timeDisplay');
    
    if (remainingSeconds <= 0) {
        display.textContent = "00:00";
        alert('Đã hết thời gian thanh toán! Đơn hàng sẽ bị hủy.');
        window.location.href = 'index.php';
        return;
    }
    
    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    
    display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    remainingSeconds--;
}

// Khởi tạo và cập nhật mỗi giây
updateCountdown();
const countdownInterval = setInterval(updateCountdown, 1000);

// Xử lý hiển thị thông tin thanh toán
function togglePaymentInfo() {
    const bankInfo = document.getElementById('bank-info');
    const momoInfo = document.getElementById('momo-info');
    const bankRadio = document.getElementById('bank');
    const momoRadio = document.getElementById('momo');
    
    if (bankRadio.checked) {
        bankInfo.style.display = 'block';
        momoInfo.style.display = 'none';
    } else if (momoRadio.checked) {
        bankInfo.style.display = 'none';
        momoInfo.style.display = 'block';
    } else {
        bankInfo.style.display = 'none';
        momoInfo.style.display = 'none';
    }
}

// Gắn sự kiện
document.getElementById('cod').addEventListener('change', togglePaymentInfo);
document.getElementById('bank').addEventListener('change', togglePaymentInfo);
document.getElementById('momo').addEventListener('change', togglePaymentInfo);

// Setup ban đầu
togglePaymentInfo();
</script>

<?php include 'footer.php'; ?>