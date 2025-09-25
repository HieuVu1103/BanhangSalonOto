<?php include '../header.php'?>

<?php
        if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $maDonDatHang = $_POST['maDonDatHang'] ?? null;
        $nguoiLap     = $_POST['nguoiLap']     ?? '';
        $lyDoXuat     = $_POST['lyDoXuat']     ?? 'BanHang';
        $trangThai    = $_POST['trangThai']    ?? 'DaXuat';
        $ghiChu       = $_POST['ghiChu']       ?? '';

        // Chi tiết phiếu xuất
        $sanPham = $_POST['sanpham'] ?? [];
        $soLuong = $_POST['soluong'] ?? [];
        $giaXuat = $_POST['giaxuat'] ?? [];

        if (!empty($nguoiLap) && !empty($sanPham)) {
            // Tính tổng tiền
            $tongTien = 0;
            for ($i = 0; $i < count($sanPham); $i++) {
                if (!empty($sanPham[$i]) && $soLuong[$i] > 0) {
                    $tongTien += $soLuong[$i] * $giaXuat[$i];
                }
            }

            $maDonDatHangSQL = $maDonDatHang ? "'$maDonDatHang'" : 'NULL';

            // Bắt đầu transaction
            $connect = Database::BeginTransaction();
            try {
                // 1. Insert phiếu xuất
                $sql = "INSERT INTO phieuxuat (MaDonDatHang, NguoiLap, LyDoXuat, TrangThai, TongTien, GhiChu) 
                        VALUES ($maDonDatHangSQL, '$nguoiLap', '$lyDoXuat', '$trangThai', '$tongTien', '$ghiChu')";
                $maXuat = Database::NonQueryIdTrans($connect, $sql);

                if (!$maXuat) {
                    throw new Exception("Không lấy được MaXuat");
                }

                // 2. Insert chi tiết phiếu xuất + cập nhật tồn kho
                for ($i = 0; $i < count($sanPham); $i++) {
                    if (!empty($sanPham[$i]) && $soLuong[$i] > 0) {
                        $sp  = (int)$sanPham[$i];
                        $sl  = (int)$soLuong[$i];
                        $gia = (float)$giaXuat[$i];

                        $sqlDetail = "INSERT INTO chitietphieuxuat (MaXuat, MaSP, SL, GiaXuat) 
                                    VALUES ($maXuat, $sp, $sl, $gia)";
                        Database::NonQueryTrans($connect, $sqlDetail);

                        $sqlUpdate = "UPDATE sanpham SET SL = SL - $sl WHERE MaSP = $sp";
                        Database::NonQueryTrans($connect, $sqlUpdate);
                    }
                }

                // Commit transaction
                Database::Commit($connect);
                $message = ['type' => 'success', 'text' => 'Thêm phiếu xuất thành công'];
            } catch (Exception $e) {
                Database::Rollback($connect);
                $message = ['type' => 'error', 'text' => 'Lỗi: ' . $e->getMessage()];
            }
        } else {
            $message = ['type' => 'warning', 'text' => 'Vui lòng nhập đầy đủ thông tin và ít nhất 1 sản phẩm'];
        }
    }

        // Edit items
        if (isset($_POST['action']) && $_POST['action'] == 'edit') {
            $id = isset($_GET['edit-id']) ? $_GET['edit-id'] : '';
            $trangThaiCu = Database::GetData("SELECT TrangThai FROM phieuxuat WHERE MaXuat = $id", ['row' => 0])['TrangThai'];
            
            $maDonDatHang = isset($_POST['maDonDatHang']) ? $_POST['maDonDatHang'] : null;
            $nguoiLap = isset($_POST['nguoiLap']) ? $_POST['nguoiLap'] : '';
            $lyDoXuat = isset($_POST['lyDoXuat']) ? $_POST['lyDoXuat'] : 'BanHang';
            $trangThai = isset($_POST['trangThai']) ? $_POST['trangThai'] : 'DaXuat';
            $ghiChu = isset($_POST['ghiChu']) ? $_POST['ghiChu'] : '';

            if (!empty($nguoiLap)) {
                // Xử lý thay đổi trạng thái
                if($trangThaiCu != $trangThai) {
                    // Lấy chi tiết phiếu xuất để cập nhật số lượng
                    $chiTiet = Database::GetData("SELECT MaSP, SL FROM chitietphieuxuat WHERE MaXuat = $id");
                    
                    if($trangThaiCu == 'DaXuat' && $trangThai == 'Huy') {
                        // Hoàn trả số lượng
                        foreach($chiTiet as $ct) {
                            $sqlRestore = "UPDATE sanpham SET SL = SL + {$ct['SL']} WHERE MaSP = {$ct['MaSP']}";
                            Database::NonQuery($sqlRestore);
                        }
                    } elseif($trangThaiCu == 'Huy' && $trangThai == 'DaXuat') {
                        // Trừ số lượng
                        foreach($chiTiet as $ct) {
                            $sqlReduce = "UPDATE sanpham SET SL = SL - {$ct['SL']} WHERE MaSP = {$ct['MaSP']}";
                            Database::NonQuery($sqlReduce);
                        }
                    }
                }

                // Tính lại tổng tiền
                $tongTienResult = Database::GetData("SELECT SUM(SL * GiaXuat) as total FROM chitietphieuxuat WHERE MaXuat = $id", ['row' => 0]);
                $tongTien = $tongTienResult['total'] ?: 0;

                $maDonDatHangSQL = $maDonDatHang ? "'$maDonDatHang'" : 'NULL';
                $sql = "UPDATE phieuxuat SET MaDonDatHang = $maDonDatHangSQL, NguoiLap = '$nguoiLap', 
                        LyDoXuat = '$lyDoXuat', TrangThai = '$trangThai', TongTien = '$tongTien', GhiChu = '$ghiChu' 
                        WHERE MaXuat = $id";

                if (Database::NonQuery($sql)) {
                    $message = [
                        'type' => 'success',
                        'text' => 'Cập nhật phiếu xuất thành công',
                    ];
                    header("Location: list.php"); 
                    exit;
                }
            } else {
                $message = [
                    'type' => 'warning',
                    'text' => 'Người lập không được trống',
                ];
            }
        }

        // Get detail via AJAX
        if (isset($_POST['action']) && $_POST['action'] == 'get_detail') {
            $id = $_POST['id'];
            
            // Get phiếu xuất info
            $phieuXuat = Database::GetData("SELECT * FROM phieuxuat WHERE MaXuat = $id", ['row' => 0]);
            
            // Get chi tiết
            $chiTiet = Database::GetData("
                SELECT ct.*, sp.TenSP 
                FROM chitietphieuxuat ct 
                JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                WHERE ct.MaXuat = $id
            ");
            
            if ($phieuXuat) {
                $trangThaiText = $phieuXuat['TrangThai'] == 'DaXuat' ? 'Đã xuất' : 'Hủy';
                $lyDoXuatText = '';
                switch($phieuXuat['LyDoXuat']) {
                    case 'BanHang': $lyDoXuatText = 'Bán hàng'; break;
                    case 'TraHang': $lyDoXuatText = 'Trả hàng'; break;
                    case 'Hong': $lyDoXuatText = 'Hỏng'; break;
                }
                
                echo '<div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Mã phiếu xuất:</strong> ' . $phieuXuat['MaXuat'] . '<br>
                            <strong>Mã đơn hàng:</strong> ' . ($phieuXuat['MaDonDatHang'] ?: '-') . '<br>
                            <strong>Người lập:</strong> ' . $phieuXuat['NguoiLap'] . '<br>
                            <strong>Lý do xuất:</strong> ' . $lyDoXuatText . '
                        </div>
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong> ' . $trangThaiText . '<br>
                            <strong>Tổng tiền:</strong> ' . number_format($phieuXuat['TongTien'], 0, ',', '.') . ' VNĐ<br>
                            <strong>Thời gian xuất:</strong> ' . date('d/m/Y H:i', strtotime($phieuXuat['TGXuat'])) . '<br>
                            <strong>Ghi chú:</strong> ' . ($phieuXuat['GhiChu'] ?: '-') . '
                        </div>
                      </div>';
                
                if ($chiTiet) {
                    echo '<h6>Chi tiết sản phẩm:</h6>
                          <table class="table table-bordered table-sm table-detail">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá xuất</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>';
                    
                    foreach ($chiTiet as $ct) {
                        $thanhTien = $ct['SL'] * $ct['GiaXuat'];
                        echo '<tr>
                                <td>' . $ct['TenSP'] . '</td>
                                <td>' . $ct['SL'] . '</td>
                                <td>' . number_format($ct['GiaXuat'], 0, ',', '.') . ' VNĐ</td>
                                <td>' . number_format($thanhTien, 0, ',', '.') . ' VNĐ</td>
                              </tr>';
                    }
                    
                    echo '</tbody></table>';
                } else {
                    echo '<p class="text-muted">Không có chi tiết sản phẩm</p>';
                }
            } else {
                echo '<div class="alert alert-danger">Không tìm thấy phiếu xuất</div>';
            }
            exit;
        }

    // Delete items
    if (isset($_GET['del-id'])) {
        $id = isset($_GET['del-id']) ? $_GET['del-id'] : '';
        
        // Lấy thông tin phiếu xuất và chi tiết
        $phieuXuat = Database::GetData("SELECT TrangThai FROM phieuxuat WHERE MaXuat = $id", ['row' => 0]);
        $chiTiet = Database::GetData("SELECT MaSP, SL FROM chitietphieuxuat WHERE MaXuat = $id");
        
        // Nếu trạng thái là "DaXuat", hoàn trả số lượng
        if($phieuXuat && $phieuXuat['TrangThai'] == 'DaXuat') {
            foreach($chiTiet as $ct) {
                $sqlRestore = "UPDATE sanpham SET SL = SL + {$ct['SL']} WHERE MaSP = {$ct['MaSP']}";
                Database::NonQuery($sqlRestore);
            }
        }
        
        // Delete chi tiết phiếu xuất trước
        $sqlDetail = "DELETE FROM chitietphieuxuat WHERE MaXuat = $id";
        Database::NonQuery($sqlDetail);
        
        // Delete phiếu xuất
        $sql = "DELETE FROM phieuxuat WHERE MaXuat = $id";
        if (Database::NonQuery($sql)) {
            $message = [
                'type' => 'success',
                'text' => 'Xóa phiếu xuất thành công',
            ];
        }
    }
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Phiếu xuất</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Phiếu xuất</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal: Add -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Thêm phiếu xuất</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mã đơn đặt hàng (tùy chọn)</label>
                                    <input type="number" name="maDonDatHang" class="form-control" placeholder="Để trống nếu không có">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Người lập <span class="text-danger">*</span></label>
                                    <input type="text" name="nguoiLap" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lý do xuất</label>
                                    <select name="lyDoXuat" class="form-control">
                                        <option value="BanHang">Bán hàng</option>
                                        <option value="TraHang">Trả hàng</option>
                                        <option value="Hong">Hỏng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="trangThai" class="form-control">
                                        <option value="DaXuat">Đã xuất</option>
                                        <option value="Huy">Hủy</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="ghiChu" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <hr>
                        <h5>Chi tiết phiếu xuất</h5>
                        <div id="chi-tiet-container">
                            <div class="chi-tiet-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Sản phẩm</label>
                                        <select name="sanpham[]" class="form-control" onchange="updatePrice(this)">
                                            <option value="">Chọn sản phẩm</option>
                                            <?php
                                                $sanPhamList = Database::GetData("SELECT MaSP, TenSP, Gia, GiaKhuyenMai, SL FROM sanpham WHERE SL > 0 ORDER BY TenSP");
                                                foreach($sanPhamList as $sp) {
                                                    $giaHienThi = $sp['GiaKhuyenMai'] ? $sp['GiaKhuyenMai'] : $sp['Gia'];
                                                    echo "<option value='{$sp['MaSP']}' data-gia='{$giaHienThi}' data-sl='{$sp['SL']}'>{$sp['TenSP']} (Tồn: {$sp['SL']})</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Số lượng</label>
                                        <input type="number" name="soluong[]" class="form-control" min="1" onchange="updateTotal()">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Giá xuất</label>
                                        <input type="number" step="0.01" name="giaxuat[]" class="form-control" onchange="updateTotal()">
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label>
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeChiTiet(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-info" onclick="addChiTiet()">
                                    <i class="fas fa-plus"></i> Thêm sản phẩm
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>Tổng tiền: <span id="tong-tien-display">0</span> VNĐ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                        <button name="action" value="add" class="btn btn-success">Thêm</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: Edit -->
        <?php
            $id = isset($_GET['edit-id']) ? $_GET['edit-id'] : '';
            $phieuXuat = [];
            if ($id != '') {
                $sql = "SELECT * FROM phieuxuat WHERE MaXuat = $id";
                $phieuXuat = Database::GetData($sql, ['row' => 0]);
            }
        ?>
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Sửa phiếu xuất</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mã phiếu xuất</label>
                                    <input type="text" value="<?=$phieuXuat['MaXuat']?>" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mã đơn đặt hàng (tùy chọn)</label>
                                    <input type="number" name="maDonDatHang" value="<?=$phieuXuat['MaDonDatHang']?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Người lập <span class="text-danger">*</span></label>
                                    <input type="text" name="nguoiLap" value="<?=$phieuXuat['NguoiLap']?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lý do xuất</label>
                                    <select name="lyDoXuat" class="form-control">
                                        <option value="BanHang" <?=$phieuXuat['LyDoXuat'] == 'BanHang' ? 'selected' : ''?>>Bán hàng</option>
                                        <option value="TraHang" <?=$phieuXuat['LyDoXuat'] == 'TraHang' ? 'selected' : ''?>>Trả hàng</option>
                                        <option value="Hong" <?=$phieuXuat['LyDoXuat'] == 'Hong' ? 'selected' : ''?>>Hỏng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="trangThai" class="form-control">
                                        <option value="DaXuat" <?=$phieuXuat['TrangThai'] == 'DaXuat' ? 'selected' : ''?>>Đã xuất</option>
                                        <option value="Huy" <?=$phieuXuat['TrangThai'] == 'Huy' ? 'selected' : ''?>>Hủy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tổng tiền</label>
                                    <input type="text" value="<?=number_format($phieuXuat['TongTien'], 0, ',', '.')?> VNĐ" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thời gian xuất</label>
                            <input type="text" value="<?=$phieuXuat['TGXuat']?>" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea name="ghiChu" class="form-control" rows="3"><?=$phieuXuat['GhiChu']?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="window.location.href='list.php'">Hủy</button>
                        <button name="action" value="edit" class="btn btn-success">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: View Detail -->
        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title">Chi tiết phiếu xuất</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detail-content">
                        <!-- Content will be loaded via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row my-2 d-flex-end">
                <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-add">
                    <i class="fas fa-plus"></i>
                </button>
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Từ khóa (Mã xuất, Người lập)" class="form-control" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row my-2">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Mã xuất</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Người lập</th>
                                    <th>Lý do xuất</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Thời gian xuất</th>
                                    <th width="180">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $pager = (new Pagination())->get('phieuxuat', $page, ROW_OF_PAGE);

                                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                    if ($keyword) {
                                        $keyword = "WHERE MaXuat LIKE '%$keyword%' OR NguoiLap LIKE '%$keyword%'";
                                    }

                                    $sql = "SELECT * FROM phieuxuat $keyword ORDER BY MaXuat DESC LIMIT " . $pager['StartIndex'] . ', ' . ROW_OF_PAGE;
                                    $phieuXuatList = Database::GetData($sql);

                                    if ($phieuXuatList) {
                                        foreach ($phieuXuatList as $px) {
                                            // Format trạng thái
                                            $trangThaiText = $px['TrangThai'] == 'DaXuat' ? 'Đã xuất' : 'Hủy';
                                            $trangThaiClass = $px['TrangThai'] == 'DaXuat' ? 'badge-success' : 'badge-danger';
                                            
                                            // Format lý do xuất
                                            $lyDoXuatText = '';
                                            switch($px['LyDoXuat']) {
                                                case 'BanHang': $lyDoXuatText = 'Bán hàng'; break;
                                                case 'TraHang': $lyDoXuatText = 'Trả hàng'; break;
                                                case 'Hong': $lyDoXuatText = 'Hỏng'; break;
                                            }
                                            
                                            echo '
                                                <tr>
                                                    <th>' . $px['MaXuat'] . '</th>
                                                    <td>' . ($px['MaDonDatHang'] ?: '-') . '</td>
                                                    <td>' . $px['NguoiLap'] . '</td>
                                                    <td>' . $lyDoXuatText . '</td>
                                                    <td><span class="badge ' . $trangThaiClass . '">' . $trangThaiText . '</span></td>
                                                    <td>' . number_format($px['TongTien'], 0, ',', '.') . ' VNĐ</td>
                                                    <td>' . date('d/m/Y H:i', strtotime($px['TGXuat'])) . '</td>
                                                    <td>
                                                        <button onclick="viewDetail(' . $px['MaXuat'] . ')" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="?edit-id=' . $px['MaXuat'] . '" class="btn btn-warning btn-sm" title="Sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button onclick="removeRow(' . $px['MaXuat'] . ')" class="btn btn-danger btn-sm" title="Xóa">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    } else {
                                        echo '<tr><td colspan="100%" class="text-center">Không có dữ liệu</td></tr>';
                                    }
                                ?>
                                <button type="button" data-toggle="modal" data-target="#modal-edit" hidden>
                                    <i class="fas fa-plus"></i>
                                </button>
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
    <!-- /.content -->
</div>
<?php include '../footer.php'?>

<script>
$(document).ready(function() {
    function GetParameterValues(param) {
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < url.length; i++) {
            var urlparam = url[i].split('=');
            if (urlparam[0] == param) {
                return urlparam[1];
            }
        }
    }

    if (GetParameterValues('edit-id') != undefined) {
        document.querySelector("[data-target='#modal-edit']").click();
    }
});

function removeRow(id) {
    if (confirm('Bạn có chắc chắn muốn xóa phiếu xuất này không? Tất cả chi tiết phiếu xuất cũng sẽ bị xóa và số lượng sản phẩm sẽ được hoàn trả (nếu phiếu đã xuất).')) {
        window.location = '?del-id=' + id;
    }
}

function updatePrice(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var gia = selectedOption.getAttribute('data-gia');
    var maxSL = selectedOption.getAttribute('data-sl');
    
    var row = selectElement.closest('.chi-tiet-row');
    var giaInput = row.querySelector('input[name="giaxuat[]"]');
    var slInput = row.querySelector('input[name="soluong[]"]');
    
    if (gia && selectedOption.value) {
        giaInput.value = gia;
        slInput.setAttribute('max', maxSL);
        slInput.value = 1;
    } else {
        giaInput.value = '';
        slInput.removeAttribute('max');
        slInput.value = '';
    }
    updateTotal();
}

function updateTotal() {
    var total = 0;
    var rows = document.querySelectorAll('.chi-tiet-row');
    
    rows.forEach(function(row) {
        var slInput = row.querySelector('input[name="soluong[]"]');
        var giaInput = row.querySelector('input[name="giaxuat[]"]');
        var sl = parseFloat(slInput.value) || 0;
        var gia = parseFloat(giaInput.value) || 0;
        total += sl * gia;
    });
    
    var displayElement = document.getElementById('tong-tien-display');
    if (displayElement) {
        displayElement.textContent = total.toLocaleString('vi-VN');
    }
}

function addChiTiet() {
    var container = document.getElementById('chi-tiet-container');
    var firstRow = container.querySelector('.chi-tiet-row');
    var newRow = firstRow.cloneNode(true);
    
    // Reset values
    newRow.querySelector('select[name="sanpham[]"]').selectedIndex = 0;
    newRow.querySelector('input[name="soluong[]"]').value = '';
    newRow.querySelector('input[name="giaxuat[]"]').value = '';
    
    container.appendChild(newRow);
}

function removeChiTiet(button) {
    var rows = document.querySelectorAll('.chi-tiet-row');
    if (rows.length > 1) {
        button.closest('.chi-tiet-row').remove();
        updateTotal();
    } else {
        alert('Phải có ít nhất 1 sản phẩm');
    }
}

function viewDetail(id) {
    // Show loading
    $('#detail-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Đang tải...</div>');
    $('#modal-detail').modal('show');
    
    // Load detail via AJAX
    $.post('', {
        action: 'get_detail', 
        id: id
    }, function(response) {
        $('#detail-content').html(response);
    }).fail(function() {
        $('#detail-content').html('<div class="alert alert-danger">Có lỗi xảy ra khi tải chi tiết phiếu xuất</div>');
    });
}
</script>