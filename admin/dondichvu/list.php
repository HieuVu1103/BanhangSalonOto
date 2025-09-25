<?php include '../header.php'?>

<?php
// Xử lý Xác nhận / Từ chối
if (isset($_GET['action']) && isset($_GET['MaDatDichVu'])) {
    $MaDatDichVu = intval($_GET['MaDatDichVu']);
    $action = $_GET['action'];

    if ($action == 'confirm') {
        Database::NonQuery("UPDATE datdichvu SET TrangThai='XacNhan' WHERE MaDatDichVu=$MaDatDichVu");
    } elseif ($action == 'reject') {
        Database::NonQuery("UPDATE datdichvu SET TrangThai='TuChoi' WHERE MaDatDichVu=$MaDatDichVu");
    }
}

// Xử lý Hoàn thành và tạo hóa đơn
if (isset($_GET['complete']) && isset($_GET['MaDatDichVu'])) {
    $MaDatDichVu = intval($_GET['MaDatDichVu']);
    $conn = Database::BeginTransaction();

    try {
        Database::NonQueryTrans($conn, "UPDATE datdichvu SET TrangThai='DaHoanThanh' WHERE MaDatDichVu=$MaDatDichVu");

        $order = Database::GetData("SELECT TenTaiKhoan FROM datdichvu WHERE MaDatDichVu=$MaDatDichVu", ['row'=>0]);
        if (!$order) throw new Exception("Không tìm thấy tài khoản cho đơn dịch vụ $MaDatDichVu");
        $TenTaiKhoan = $order['TenTaiKhoan'];

        $services = Database::GetData("SELECT MaDichVu, Gia FROM datdichvu_chitiet WHERE MaDatDichVu=$MaDatDichVu");
        $tongTien = 0;
        if ($services) {
            foreach ($services as $s) $tongTien += $s['Gia'];
        }


        $MaHoaDon = Database::NonQueryIdTrans($conn, "
            INSERT INTO hoadondichvu (MaDatDichVu, TenTaiKhoan, TongTien)
            VALUES ($MaDatDichVu, '$TenTaiKhoan', $tongTien)
        ");

        //Tạo chi tiết hóa đơn
        if ($services) {
            foreach ($services as $s) {
                $dv = Database::GetData("SELECT TenDichVu FROM dichvu WHERE MaDichVu={$s['MaDichVu']}", ['row'=>0]);
                $tenDV_SQL = $dv ? "'".addslashes($dv['TenDichVu'])."'" : "NULL";

                Database::NonQueryTrans($conn, "
                    INSERT INTO chitiethoadondichvu (MaHoaDonDichVu, TenDichVu, Gia)
                    VALUES ($MaHoaDon, $tenDV_SQL, {$s['Gia']})
                ");
            }
        }

        Database::Commit($conn);
    } catch (Exception $e) {
        Database::Rollback($conn);
        die("Lỗi khi tạo hóa đơn: " . $e->getMessage());
    }
}


function ServiceOrderStatusBadge($status) {
    switch($status){
        case 'ChoXuLy': return '<span class="badge bg-warning">Chờ xử lý</span>';
        case 'XacNhan': return '<span class="badge bg-info">Đã xác nhận</span>';
        case 'DaHoanThanh': return '<span class="badge bg-success">Hoàn thành</span>';
        case 'Huy': return '<span class="badge bg-danger">Hủy</span>';
        case 'TuChoi': return '<span class="badge bg-secondary">Từ chối</span>';
        default: return '<span class="badge bg-dark">Không xác định</span>';
    }
}
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Đơn đặt dịch vụ</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">Đơn đặt dịch vụ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <div class="container-fluid">

            <div class="row my-2 d-flex-end">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Từ khoá" class="form-control" 
                               value="<?=isset($_GET['keyword'])?htmlspecialchars($_GET['keyword']):''?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bảng đơn dịch vụ -->
            <div class="row my-2">
                <div class="card w-100">
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Mã đặt dịch vụ</th>
                                    <th>Tài khoản</th>
                                    <th>Họ tên</th>
                                    <th>Model xe</th>
                                    <th>Biển số</th>
                                    <th>Dịch vụ</th>
                                    <th>Ngày đặt</th>
                                    <th>Ngày hẹn</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                    <th>Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                $pager = (new Pagination())->get('datdichvu', $page, ROW_OF_PAGE);

                                $keyword = isset($_GET['keyword']) ? addslashes($_GET['keyword']) : '';
                                $where = '';
                                if ($keyword) {
                                    $where = "WHERE ddv.MaDatDichVu LIKE '%$keyword%' 
                                              OR ddv.TenTaiKhoan LIKE '%$keyword%' 
                                              OR ddv.BienSoXe LIKE '%$keyword%' 
                                              OR ddv.ModelXe LIKE '%$keyword%'";
                                }

                                $sql = "
                                    SELECT 
                                        ddv.MaDatDichVu,
                                        ddv.TenTaiKhoan,
                                        u.TenDayDu,
                                        ddv.ModelXe,
                                        ddv.BienSoXe,
                                        ddv.NgayDat,
                                        ddv.NgayHen,
                                        ddv.TrangThai,
                                        ddv.GhiChu,
                                        GROUP_CONCAT(CONCAT(dv.TenDichVu, ' (', ct.Gia, 'đ)') SEPARATOR ', ') AS DanhSachDichVu
                                    FROM datdichvu ddv
                                    JOIN users u ON ddv.TenTaiKhoan = u.TenTaiKhoan
                                    LEFT JOIN datdichvu_chitiet ct ON ddv.MaDatDichVu = ct.MaDatDichVu
                                    LEFT JOIN dichvu dv ON ct.MaDichVu = dv.MaDichVu
                                    $where
                                    GROUP BY ddv.MaDatDichVu
                                    ORDER BY ddv.NgayDat DESC
                                    LIMIT ".$pager['StartIndex'].", ".ROW_OF_PAGE;

                                $orders = Database::GetData($sql);

                                if ($orders) {
                                    foreach ($orders as $order) {
                                        echo '<tr>
                                            <th>'.$order['MaDatDichVu'].'</th>
                                            <td>'.$order['TenTaiKhoan'].'</td>
                                            <td>'.$order['TenDayDu'].'</td>
                                            <td>'.$order['ModelXe'].'</td>
                                            <td>'.$order['BienSoXe'].'</td>
                                            <td>'.htmlspecialchars($order['DanhSachDichVu']).'</td>
                                            <td>'.Helper::DateTime($order['NgayDat']).'</td>
                                            <td>'.Helper::DateTime($order['NgayHen']).'</td>
                                            <td>'.ServiceOrderStatusBadge($order['TrangThai']).'</td>
                                            <td>'.$order['GhiChu'].'</td>
                                            <td>';
                                        
                                        if ($order['TrangThai'] == 'ChoXuLy') {
                                            echo '<a href="?action=confirm&MaDatDichVu='.$order['MaDatDichVu'].'" 
                                                     class="btn btn-success btn-sm" title="Xác nhận">
                                                     <i class="fas fa-check"></i></a> ';
                                            echo '<a href="?action=reject&MaDatDichVu='.$order['MaDatDichVu'].'" 
                                                     class="btn btn-danger btn-sm" title="Từ chối">
                                                     <i class="fas fa-times"></i></a>';
                                        } elseif ($order['TrangThai'] == 'XacNhan') {
                                            echo '<a href="?complete=1&MaDatDichVu='.$order['MaDatDichVu'].'" 
                                                    class="btn btn-primary btn-sm" title="Hoàn thành">
                                                    <i class="fas fa-check-circle"></i></a>';
                                            echo '<a href="?cancel=1&MaDatDichVu='.$order['MaDatDichVu'].'" 
                                                    class="btn btn-warning btn-sm" title="Hủy">
                                                    <i class="fas fa-times-circle"></i></a>';
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
                    for($i=1;$i<=$pager['TotalPages'];$i++){
                        $active = $page==$i?'active':'';
                        echo '<li class="page-item '.$active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>
</div>

<?php include '../footer.php'?>
