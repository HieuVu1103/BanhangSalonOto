<?php 
include 'config/config.php';
include 'config/Database.php';
session_start();

if (!isset($_SESSION['TenTaiKhoan'])) {
    header("Location: login.php");
    exit;
}

// Thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy dữ liệu người dùng
$user = Database::GetData("SELECT * FROM users WHERE TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "'", ['row' => 0]);

// Lấy danh sách đơn hàng
$orders = Database::GetData("
    SELECT * FROM dondathang 
    WHERE TenTaiKhoan='" . $_SESSION['TenTaiKhoan'] . "' 
    ORDER BY CreatedAt DESC
");

// Lấy chi tiết đơn hàng cho mỗi đơn và kiểm tra trạng thái thanh toán
foreach ($orders as &$order) {
    $orderId = $order['MaDonDatHang'];
    $order['ChiTiet'] = Database::GetData("
        SELECT c.MaSP, c.SL, s.TenSP, s.Gia 
        FROM chitietdondathang c
        INNER JOIN sanpham s ON c.MaSP = s.MaSP
        WHERE c.MaDonDatHang = '$orderId'
    ");
    
    // Kiểm tra xem đơn hàng đã thanh toán chưa
    $paymentCheck = Database::GetData("SELECT MaTT FROM thanhtoan WHERE MaDonDatHang=$orderId");
    $order['DaThanhToan'] = ($paymentCheck && count($paymentCheck) > 0);
    
    // Kiểm tra thời gian còn lại để thanh toán (15 phút)
    $createdTime = strtotime($order['CreatedAt']);
    $currentTime = time();
    $timeElapsed = $currentTime - $createdTime;
    $order['ConThoiGianThanhToan'] = ($timeElapsed < 15 * 60); // 15 phút = 900 giây
}

// Xử lý hủy dịch vụ

if (isset($_GET['cancelService'])) {
    $MaDatDichVu = intval($_GET['cancelService']);

    // Lấy trạng thái hiện tại
    $service = Database::GetData("SELECT TrangThai FROM datdichvu WHERE MaDatDichVu=$MaDatDichVu", ['row'=>0]);

    if ($service && ($service['TrangThai'] == 'ChoXuLy' || $service['TrangThai'] == 'XacNhan')) {
        // Cập nhật trạng thái thành Huy
        if (Database::NonQuery("UPDATE datdichvu SET TrangThai='Huy' WHERE MaDatDichVu=$MaDatDichVu")) {
            echo "<script>alert('Dịch vụ đã được hủy!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
            exit;
        } else {
            echo "<script>alert('Có lỗi khi hủy dịch vụ, vui lòng thử lại!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Dịch vụ này không thể hủy!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
        exit;
    }
}

// Xử lý hủy đơn hàng

if (isset($_GET['cancelOrder'])) {
    $MaDonDatHang = intval($_GET['cancelOrder']);

    // Lấy trạng thái hiện tại
    $order = Database::GetData("SELECT TrangThai FROM dondathang WHERE MaDonDatHang=$MaDonDatHang", ['row'=>0]);

    if ($order && $order['TrangThai'] == 'ChoXuLy') {
        // Cập nhật trạng thái thành Huy
        if (Database::NonQuery("UPDATE dondathang SET TrangThai='Huy' WHERE MaDonDatHang=$MaDonDatHang")) {
            echo "<script>alert('Đơn hàng đã được hủy!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
            exit;
        } else {
            echo "<script>alert('Có lỗi khi hủy đơn hàng, vui lòng thử lại!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Đơn hàng này không thể hủy!'); window.location='".$_SERVER['PHP_SELF']."';</script>";
        exit;
    }
}

$alert = "";
$alert1 = "";

if (isset($_POST['submit'])) {
    if (!empty($_FILES['avatar']['name'])) {
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $image_name = $_SESSION['TenTaiKhoan'] . "." . $extension;
        $image_path = '/Salonoto/assets/img/' . $image_name;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path)) {
            if (Database::NonQuery("UPDATE users SET Avatar = '$image_path' WHERE TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "'")) {
                $_SESSION['Avatar'] = $image_path;
                $alert1 .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Ảnh đại diện đã được cập nhật thành công
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                           </div>';
            } else {
                $alert1 .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Cập nhật ảnh đại diện thất bại
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                           </div>';
            }
        } else {
            $alert1 .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Upload ảnh thất bại
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                       </div>';
        }
    }

    // Cập nhật thông tin cá nhân
    $tendaydu = $_POST['tendaydu'] ?? '';
    $sdt      = $_POST['sdt'] ?? '';
    $email    = $_POST['email'] ?? '';
    $diachi   = $_POST['diachi'] ?? '';

    $sql = "UPDATE users 
            SET TenDayDu='$tendaydu', SDT='$sdt', Email='$email', DiaChi='$diachi'
            WHERE TenTaiKhoan='" . $_SESSION['TenTaiKhoan'] . "'";

    if (Database::NonQuery($sql)) {
        $alert .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Cập nhật thông tin cá nhân thành công
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                   </div>';

        // Refresh lại dữ liệu user
        $user = Database::GetData("SELECT * FROM users WHERE TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "'", ['row' => 0]);
    } else {
        $alert .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Cập nhật thất bại, vui lòng thử lại
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                   </div>';
    }
}


// Lấy lịch sử dịch vụ
$servicesRaw = Database::GetData("
    SELECT dc.MaDatDichVu, dc.NgayDat, dc.NgayHen, dc.TrangThai, dc.ModelXe, dc.BienSoXe,
           dct.Gia, dv.TenDichVu
    FROM datdichvu_chitiet dct
    INNER JOIN dichvu dv ON dct.MaDichVu = dv.MaDichVu
    INNER JOIN datdichvu dc ON dct.MaDatDichVu = dc.MaDatDichVu
    WHERE dc.TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "'
    ORDER BY dc.NgayHen DESC
");

// Gom chi tiết theo từng dịch vụ và tính tổng tiền
$services = [];
foreach ($servicesRaw as $item) {
    $id = $item['MaDatDichVu'];
    if (!isset($services[$id])) {
        $services[$id] = [
            'MaDatDichVu' => $id,
            'NgayDat' => $item['NgayDat'],
            'NgayHen' => $item['NgayHen'],
            'TrangThai' => $item['TrangThai'],
            'ModelXe' => $item['ModelXe'],
            'BienSoXe' => $item['BienSoXe'],
            'TongTien' => 0,
            'ChiTiet' => []
        ];
    }
    $services[$id]['ChiTiet'][] = [
        'TenDichVu' => $item['TenDichVu'],
        'Gia' => $item['Gia']
    ];
    $services[$id]['TongTien'] += $item['Gia'];
}
$services = array_values($services);

function OrderStatusBadge($status) {
    switch ($status) {
        case 'ChoXuLy': return '<span class="badge bg-warning">Chờ xử lý</span>';
        case 'XacNhan': return '<span class="badge bg-info">Xác nhận </span>';
        case 'DangGiaoHang': return '<span class="badge bg-info">Đang giao hàng</span>';
        case 'DaHoanThanh': return '<span class="badge bg-success">Đã hoàn thành</span>';
        case 'Huy': return '<span class="badge bg-danger">Hủy</span>';
        case 'HoanHang': return '<span class="badge bg-danger">Hoàn hàng</span>';
        default: return '<span class="badge bg-secondary">Không xác định</span>';
    }
}

function ServiceStatusBadge($status) {
    switch ($status) {
        case 'ChoXuLy': return '<span class="badge bg-warning">Chờ xử lý</span>';
        case 'XacNhan': return '<span class="badge bg-info">Xác nhận</span>';
        case 'DaHoanThanh': return '<span class="badge bg-success">Đã hoàn thành</span>';
        case 'Huy': return '<span class="badge bg-danger">Hủy</span>';
        case 'TuChoi': return '<span class="badge bg-danger">Từ chối</span>';
        default: return '<span class="badge bg-secondary">Không xác định</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thông tin cá nhân</title>
<link rel="stylesheet" href="/Salonoto/assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="profile__bg d-flex-center">
<div class="profile__container">

    <!-- Avatar -->
    <div class="profile__avatar-col">
        <img class="profile__avatar" src="<?=$user['Avatar']?>?v=<?=time()?>" alt="Avatar">
    </div>

    <!--Thông tin cá nhân -->
    <div class="profile__form">
        <div class="profile__form--header"><h3>Thông tin cá nhân</h3></div>
        <form class="profile__form--body" method="POST" enctype="multipart/form-data">
            <div class="profile__group"><b>Tên đăng nhập: </b><input type="text" value="<?=$user['TenTaiKhoan']?>" disabled></div>
            <div class="profile__group"><b>Họ tên: </b><input type="text" name="tendaydu" value="<?=$user['TenDayDu']?>"></div>
            <div class="profile__group"><b>Số điện thoại: </b><input type="text" name="sdt" value="<?=$user['SDT']?>"></div>
            <div class="profile__group"><b>Email: </b><input type="email" name="email" value="<?=$user['Email']?>"></div>
            <div class="profile__group"><b>Địa chỉ: </b><input type="text" name="diachi" value="<?=$user['DiaChi']?>"></div>
            <div class="profile__group"><b>Ảnh đại diện: </b><input type="file" name="avatar"></div>
            <div class="profile__group"><span><b>Ngày tạo tài khoản: </b> <?=date('d-m-Y', strtotime($user['CreatedAt']))?></span></div>
            <div class="profile__group d-flex-center">
                <div>
                    <input class="btn" name="submit" type="submit" value="Cập nhật">
                    <a class="btn" href="/Salonoto/change-password.php">Đổi mật khẩu</a>
                    <a class="btn" href="/Salonoto/index.php">Trang chủ</a>
                </div>
            </div>

        <!-- Chỗ hiển thị thông báo -->
        <div id="alert-box" class="mt-3">
            <?= $alert ?>
        </div>
        </form>
    </div>

    <!-- Lịch sử -->
    <div class="profile__history">

        <!-- Lịch sử đơn hàng -->
        <div class="profile__history-card">
            <h3>Lịch sử đơn hàng</h3>
            <div class="history-table-wrapper">
                <?php if ($orders): ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Công cụ</th>
                        </tr>
                    </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?=$order['MaDonDatHang']?></td>
                    <td><?=number_format($order['TongTien'],0,',','.')?> đ</td>
                    <td><?=OrderStatusBadge($order['TrangThai'])?></td>
                    <td><?=date('d-m-Y H:i', strtotime($order['CreatedAt']))?></td>
                    <td>
                        <!-- nút xem chi tiết luôn hiển thị -->
                        <button class="btn btn-info btn-sm" title="Xem chi tiết"
                            onclick="showOrderDetail('<?=$order['MaDonDatHang']?>')">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- nút thanh toán - chỉ hiển thị khi: chưa thanh toán, chưa hủy, còn trong 15 phút -->
                        <?php if (!$order['DaThanhToan'] && $order['TrangThai'] != 'Huy' && $order['ConThoiGianThanhToan']): ?>
                            <a href="pay.php?MaDonDatHang=<?=$order['MaDonDatHang']?>" 
                            class="btn btn-warning btn-sm" title="Thanh toán">
                                <i class="fas fa-credit-card"></i>
                            </a>
                        <?php endif; ?>

                        <!-- nút in chỉ hiển thị khi đơn đã hoàn thành -->
                        <?php if ($order['TrangThai'] == 'DaHoanThanh'): ?>
                            <a href="print-order.php?order-id=<?=$order['MaDonDatHang']?>" 
                            class="btn btn-success btn-sm" title="In đơn">
                                <i class="fas fa-print"></i>
                            </a>
                        <?php endif; ?>

                        <!-- nút hủy chỉ hiển thị khi đang chờ xử lý -->
                        <?php if ($order['TrangThai'] == 'ChoXuLy'): ?>
                            <a href="?cancelOrder=<?=$order['MaDonDatHang']?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?');"
                            title="Hủy đơn hàng">
                            <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
                <?php else: ?>
                    <p>Bạn chưa có đơn hàng nào.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lịch sử dịch vụ -->
        <div class="profile__history-card">
            <h3>Lịch sử đặt dịch vụ</h3>
            <div class="history-table-wrapper">
                <?php if ($services): ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã dịch vụ</th>
                            <th>Xe</th>
                            <th>Biển số</th>
                            <th>Ngày đặt</th>
                            <th>Ngày hẹn</th>
                            <th>Trạng thái</th>
                            <th>Công cụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $svc): ?>
                        <tr>
                            <td><?=$svc['MaDatDichVu']?></td>
                            <td><?=$svc['ModelXe']?></td>
                            <td><?=$svc['BienSoXe']?></td>
                            <td><?=date('d-m-Y H:i', strtotime($svc['NgayDat']))?></td>
                            <td><?=date('d-m-Y H:i', strtotime($svc['NgayHen']))?></td>
                            <td><?=ServiceStatusBadge($svc['TrangThai'])?></td>
                            <td>
                                <!-- Nút xem chi tiết dịch vụ -->
                                <button class="btn btn-info btn-sm" title="Xem chi tiết"
                                    onclick="showServiceDetail('<?=$svc['MaDatDichVu']?>')">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Nút hủy dịch vụ nếu trạng thái cho phép -->
                                <?php if ($svc['TrangThai'] == 'ChoXuLy' || $svc['TrangThai'] == 'XacNhan'): ?>
                                    <a href="?cancelService=<?=$svc['MaDatDichVu']?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Bạn có chắc muốn hủy dịch vụ này?');"
                                    title="Hủy dịch vụ">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"></span>
                                <?php endif; ?>
                            </td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>Bạn chưa có lịch đặt dịch vụ nào.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal chi tiết hóa đơn -->
<div class="modal fade" id="modal-order-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Chi tiết hóa đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="order-detail-body">
                <!-- Nội dung chi tiết sẽ được JS populate -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal chi tiết dịch vụ -->
<div class="modal fade" id="modal-service-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Chi tiết dịch vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="service-detail-body">
                <!-- Nội dung chi tiết sẽ được JS populate -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
const orders = <?=json_encode($orders)?>;

function showOrderDetail(orderId) {
    const order = orders.find(o => o.MaDonDatHang == orderId);
    if (!order) return;

    let html = `<p><b>Mã đơn:</b> ${order.MaDonDatHang}</p>`;
    html += `<p><b>Tổng tiền:</b> ${parseFloat(order.TongTien).toLocaleString()} đ</p>`;

    html += `<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                        <th>Mã giảm giá</th>
                        <th>Giảm</th>
                    </tr>
                </thead>
                <tbody>`;
    order.ChiTiet.forEach(item => {
        html += `<tr>
                    <td>${item.TenSP}</td>
                    <td>${item.SL}</td>
                    <td>${parseFloat(item.Gia).toLocaleString()} đ</td>
                    <td></td>
                    <td></td>
                 </tr>`;
    });

    if (order.MaGiamGia) {
        html += `<tr>
                    <td colspan="3" class="text-end"><b>Khuyến mãi</b></td>
                    <td>${order.MaGiamGia}</td>
                    <td>- ${parseFloat(order.GiamGia).toLocaleString()} đ</td>
                 </tr>`;
    }

    html += `</tbody></table>`;

    document.getElementById('order-detail-body').innerHTML = html;
    $('#modal-order-detail').modal('show');
}
const services = <?=json_encode($services)?>;

function showServiceDetail(serviceId) {
    const svc = services.find(s => s.MaDatDichVu == serviceId);
    if (!svc) return;

    let html = `<p><b>Mã đặt dịch vụ:</b> ${svc.MaDatDichVu}</p>`;
    html += `<p><b>Ngày hẹn:</b> ${new Date(svc.NgayHen).toLocaleString()}</p>`;
    html += `<p><b>Tổng tiền:</b> ${parseFloat(svc.TongTien).toLocaleString()} đ</p>`;

    html += `<table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Tên dịch vụ</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>`;
    svc.ChiTiet.forEach(item => {
        html += `<tr>
                    <td>${item.TenDichVu}</td>
                    <td>${parseFloat(item.Gia).toLocaleString()} đ</td>
                 </tr>`;
    });
    html += `</tbody></table>`;

    document.getElementById('service-detail-body').innerHTML = html;
    $('#modal-service-detail').modal('show');
}
</script>

</body>
</html>
