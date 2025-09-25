<?php include '../header.php'?>

<?php
// tt thủ công
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $MaDonDatHang = !empty($_POST['MaDonDatHang']) ? (int)$_POST['MaDonDatHang'] : null;
    $TenTaiKhoan  = $_POST['TenTaiKhoan'] ?? '';
    $TongTien     = $_POST['TongTien'] ?? 0;
    $PhuongThucTT = $_POST['PhuongThucTT'] ?? '';
    $GhiChu       = $_POST['GhiChu'] ?? '';

    if ($TenTaiKhoan && $TongTien > 0 && $PhuongThucTT) {
        // chọn mới kiểm tra
        if ($MaDonDatHang) {
            $donHang = Database::GetData("SELECT * FROM dondathang WHERE MaDonDatHang = '$MaDonDatHang'", ['row' => 0]);
            if (!$donHang) {
                $message = ['type' => 'warning', 'text' => 'Đơn đặt hàng không tồn tại'];
                return;
            }
        }

        // check tồn tại user
        $user = Database::GetData("SELECT * FROM users WHERE TenTaiKhoan = '$TenTaiKhoan'", ['row' => 0]);
        if ($user) {
            // tạo mã gd
            $MaGiaoDich = 'GD' . rand(1000000, 9999999);

            // insert thanh toán 
            $MaDonDatHangSQL = $MaDonDatHang ? "'$MaDonDatHang'" : "NULL";

            $sql = "INSERT INTO thanhtoan (MaDonDatHang, MaGiaoDich, TenTaiKhoan, TongTien, PhuongThucTT, TrangThaiTT, GhiChu, NgayTT) 
                    VALUES ($MaDonDatHangSQL, '$MaGiaoDich', '$TenTaiKhoan', '$TongTien', '$PhuongThucTT', 'ChoXuLy', '$GhiChu', NOW())";

            if (Database::NonQuery($sql)) {
                $message = ['type' => 'success', 'text' => 'Thêm thanh toán thành công'];
            } else {
                $message = ['type' => 'error', 'text' => 'Lỗi khi thêm thanh toán'];
            }
        } else {
            $message = ['type' => 'warning', 'text' => 'Tài khoản không tồn tại'];
        }
    } else {
        $message = ['type' => 'warning', 'text' => 'Vui lòng nhập đầy đủ thông tin'];
    }
}

// xử lý xác nhận hoặc hủy 
if (isset($_GET['action']) && isset($_GET['MaGiaoDich'])) {
    $MaGiaoDich = $_GET['MaGiaoDich'];
    $action = $_GET['action'];

    // lấy MaDonDatHang từ thanhtoan
    $payment = Database::GetData("SELECT MaDonDatHang FROM thanhtoan WHERE MaGiaoDich='$MaGiaoDich'", ['row'=>0]);
    if ($payment) {
        $MaDonDatHang = $payment['MaDonDatHang'];

        if ($action == 'confirm') {
            // thanh toán hoàn tất
            Database::NonQuery("UPDATE thanhtoan SET TrangThaiTT='HoanTat', UpdatedAt=NOW() WHERE MaGiaoDich='$MaGiaoDich'");
            Database::NonQuery("UPDATE dondathang SET TrangThai='XacNhan' WHERE MaDonDatHang='$MaDonDatHang'");

            // trừ số lượng trong SanPham
            $chiTiet = Database::GetData("SELECT MaSP, SL FROM chitietdondathang WHERE MaDonDatHang='$MaDonDatHang'");
            if ($chiTiet) {
                foreach ($chiTiet as $item) {
                    $MaSP = $item['MaSP'];
                    $SL   = $item['SL'];
                    Database::NonQuery("UPDATE SanPham SET SL = SL - $SL WHERE MaSP = $MaSP");
                }
            }
        }
        elseif ($action == 'cancel') {
            // thanh toán hủy
            Database::NonQuery("UPDATE thanhtoan SET TrangThaiTT='Huy', UpdatedAt=NOW() WHERE MaGiaoDich='$MaGiaoDich'");
            Database::NonQuery("UPDATE dondathang SET TrangThai='Huy' WHERE MaDonDatHang='$MaDonDatHang'");
        }
    }
}

//  badge trạng thái thanh toán
function PaymentBadgeTT($status) {
    switch($status){
        case 'ChoXuLy':
            return '<span class="badge bg-warning">Chờ xử lý</span>';
        case 'HoanTat':
            return '<span class="badge bg-success">Hoàn tất</span>';
        case 'Huy':
            return '<span class="badge bg-danger">Hủy</span>';
        default:
            return '<span class="badge bg-secondary">Không xác định</span>';
    }
}

// lấy danh sách đơn đặt hàng và users cho form thêm
$donDatHangList = Database::GetData("SELECT MaDonDatHang, TongTien FROM dondathang WHERE TrangThai IN ('ChoXuLy', 'XacNhan') ORDER BY MaDonDatHang DESC");
$usersList = Database::GetData("SELECT TenTaiKhoan, TenDayDu FROM users ORDER BY TenDayDu");
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thanh toán</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">Thanh toán</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal: thêm tt -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Thêm thanh toán</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Đơn đặt hàng <span class="text-danger">*</span></label>
                                    <select name="MaDonDatHang" class="form-control" onchange="updateTongTien(this)">
                                        <option value="">Chọn đơn đặt hàng</option>
                                        <?php
                                            foreach($donDatHangList as $ddh) {
                                                echo "<option value='{$ddh['MaDonDatHang']}' data-tongtien='{$ddh['TongTien']}'>#{$ddh['MaDonDatHang']} - " . number_format($ddh['TongTien'], 0, ',', '.') . " VNĐ</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Khách hàng <span class="text-danger">*</span></label>
                                    <select name="TenTaiKhoan" class="form-control" required>
                                        <option value="">Chọn khách hàng</option>
                                        <?php
                                            foreach($usersList as $user) {
                                                echo "<option value='{$user['TenTaiKhoan']}'>{$user['TenDayDu']} ({$user['TenTaiKhoan']})</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tổng tiền <span class="text-danger">*</span></label>
                                    <input type="number" name="TongTien" id="tongTienInput" class="form-control" step="0.01" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phương thức thanh toán <span class="text-danger">*</span></label>
                                    <select name="PhuongThucTT" class="form-control" required>
                                        <option value="">Chọn phương thức</option>
                                        <option value="TienMat">Tiền mặt</option>
                                        <option value="ChuyenKhoan">Chuyển khoản</option>
                                        <option value="TheATM">Thẻ ATM</option>
                                        <option value="ViDienTu">Ví điện tử</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="GhiChu" class="form-control" rows="3" placeholder="Ghi chú về thanh toán..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                        <button name="action" value="add" class="btn btn-success">Thêm thanh toán</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Tìm kiếm -->
            <div class="row my-2 d-flex-end">
                <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-add">
                    <i class="fas fa-plus"></i>
                </button>
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Từ khóa (Mã giao dịch, Tài khoản)" class="form-control" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bảng thanh toán -->
            <div class="row my-2">
                <div class="card w-100">
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Mã TT</th>
                                    <th>Giao dịch</th>
                                    <th>Đơn hàng</th>
                                    <th>Người dùng</th>
                                    <th>Tổng tiền</th>
                                    <th>Phương thức TT</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày TT</th>
                                    <th>Ghi chú</th>
                                    <th width="120">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $pager = (new Pagination())->get('thanhtoan', $page, ROW_OF_PAGE);

                                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                $where = '';
                                if ($keyword) {
                                    $where = "WHERE t.MaGiaoDich LIKE '%$keyword%' OR t.TenTaiKhoan LIKE '%$keyword%'";
                                }

                                $sql = "
                                    SELECT t.*, u.TenDayDu
                                    FROM thanhtoan t
                                    JOIN users u ON t.TenTaiKhoan = u.TenTaiKhoan
                                    $where
                                    ORDER BY t.NgayTT DESC
                                    LIMIT " . $pager['StartIndex'] . ", " . ROW_OF_PAGE;
                                
                                $payments = Database::GetData($sql);

                                if ($payments) {
                                    foreach ($payments as $payment) {
                                        echo '<tr>
                                            <td>' . $payment['MaTT'] . '</td>
                                            <td>' . $payment['MaGiaoDich'] . '</td>
                                            <td>#' . $payment['MaDonDatHang'] . '</td>
                                            <td>' . $payment['TenDayDu'] . '</td>
                                            <td>' . number_format($payment['TongTien'], 0, ',', '.') . ' VNĐ</td>
                                            <td>' . $payment['PhuongThucTT'] . '</td>
                                            <td>' . PaymentBadgeTT($payment['TrangThaiTT']) . '</td>
                                            <td>' . date('d/m/Y H:i', strtotime($payment['NgayTT'])) . '</td>
                                            <td>' . ($payment['GhiChu'] ?: '-') . '</td>
                                            <td>';
                                        if ($payment['TrangThaiTT'] == 'ChoXuLy') {
                                            echo '<a href="?action=confirm&MaGiaoDich=' . $payment['MaGiaoDich'] . '" class="btn btn-success btn-sm" title="Xác nhận"><i class="fas fa-check"></i></a> ';
                                            echo '<a href="?action=cancel&MaGiaoDich=' . $payment['MaGiaoDich'] . '" class="btn btn-danger btn-sm" title="Hủy"><i class="fas fa-times"></i></a>';
                                        } else {
                                            echo '<span class="text-muted">Đã xử lý</span>';
                                        }
                                        echo '</td></tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="100%" class="text-center">Không có dữ liệu</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row my-2 d-flex-between">
                <div>Hiển thị từ <?=$pager['StartPage']?> đến <?=$pager['EndPage']?> của <?=$pager['TotalItems']?> bản ghi</div>
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= $pager['TotalPages']; $i++) {
                        $active = $page == $i ? 'active' : '';
                        echo '<li class="page-item ' . $active . '">
                            <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
</div>

<?php include '../footer.php'?>

<script>
function updateTongTien(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var tongTien = selectedOption.getAttribute('data-tongtien');
    
    if (tongTien) {
        document.getElementById('tongTienInput').value = tongTien;
    } else {
        document.getElementById('tongTienInput').value = '';
    }
}

// Reset form khi đóng modal
$('#modal-add').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
});
</script>