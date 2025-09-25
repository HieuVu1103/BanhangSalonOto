<?php include '../header.php'?>

<?php
if (isset($_POST['action']) && $_POST['action'] == 'get_detail') {
    $id = $_POST['id'];
    
    // Get phiếu nhập info
    $phieuNhap = Database::GetData("
        SELECT pn.*, nc.TenNCC 
        FROM phieunhap pn 
        JOIN nhacungcap nc ON pn.MaNCC = nc.MaNCC 
        WHERE pn.MaNhap = $id
    ", ['row' => 0]);
    
    // Get chi tiết
    $chiTiet = Database::GetData("
        SELECT ct.*, sp.TenSP 
        FROM chitietphieunhap ct 
        JOIN sanpham sp ON ct.MaSP = sp.MaSP 
        WHERE ct.MaNhap = $id
    ");
    
    if ($phieuNhap) {
        // Tính tổng tiền
        $tongTien = 0;
        if ($chiTiet) {
            foreach ($chiTiet as $ct) {
                $tongTien += $ct['SL'] * $ct['GiaNhap'];
            }
        }
        
        echo '<div class="row mb-3">
                <div class="col-md-6">
                    <strong>Mã phiếu nhập:</strong> ' . $phieuNhap['MaNhap'] . '<br>
                    <strong>Nhà cung cấp:</strong> ' . $phieuNhap['TenNCC'] . '<br>
                    <strong>Thời gian nhập:</strong> ' . date('d/m/Y H:i', strtotime($phieuNhap['TGNhap'])) . '
                </div>
                <div class="col-md-6">
                    <strong>Tổng tiền:</strong> ' . number_format($tongTien, 0, ',', '.') . ' VNĐ<br>
                    <strong>Ghi chú:</strong> ' . ($phieuNhap['GhiChu'] ?: '-') . '
                </div>
              </div>';
        
        if ($chiTiet) {
            echo '<h6>Chi tiết sản phẩm:</h6>
                  <table class="table table-bordered table-sm table-detail">
                    <thead class="table-secondary">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá nhập</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            foreach ($chiTiet as $ct) {
                $thanhTien = $ct['SL'] * $ct['GiaNhap'];
                echo '<tr>
                        <td>' . $ct['TenSP'] . '</td>
                        <td>' . $ct['SL'] . '</td>
                        <td>' . number_format($ct['GiaNhap'], 0, ',', '.') . ' VNĐ</td>
                        <td>' . number_format($thanhTien, 0, ',', '.') . ' VNĐ</td>
                      </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p class="text-muted">Không có chi tiết sản phẩm</p>';
        }
    } else {
        echo '<div class="alert alert-danger">Không tìm thấy phiếu nhập</div>';
    }
    exit;
}

// Lấy danh sách sản phẩm và nhà cung cấp
$products = Database::GetData("SELECT MaSP, TenSP, Gia, GiaKhuyenMai FROM SanPham ORDER BY TenSP");
$nhacungcap = Database::GetData("SELECT MaNCC, TenNCC FROM NhaCungCap ORDER BY TenNCC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm phiếu nhập với nhiều sản phẩm
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $MaNCC = $_POST['MaNCC'] ?? '';
        $GhiChu = $_POST['GhiChu'] ?? '';
        
        // Chi tiết phiếu nhập
        $sanPham = $_POST['sanpham'] ?? [];
        $soLuong = $_POST['soluong'] ?? [];
        $giaNhap = $_POST['gianhap'] ?? [];

        if (!empty($MaNCC) && !empty($sanPham)) {
            // Kiểm tra có ít nhất 1 sản phẩm hợp lệ
            $hasValidProduct = false;
            for ($i = 0; $i < count($sanPham); $i++) {
                if (!empty($sanPham[$i]) && $soLuong[$i] > 0 && $giaNhap[$i] > 0) {
                    $hasValidProduct = true;
                    break;
                }
            }

            if ($hasValidProduct) {
                $connect = Database::BeginTransaction();
                try {
                    // 1. Insert phiếu nhập
                    $sql = "INSERT INTO phieunhap (MaNCC, GhiChu) VALUES ('$MaNCC', '$GhiChu')";
                    $maNhap = Database::NonQueryIdTrans($connect, $sql);

                    if (!$maNhap) {
                        throw new Exception("Không lấy được MaNhap");
                    }

                    // 2. Insert chi tiết phiếu nhập + cập nhật tồn kho
                    for ($i = 0; $i < count($sanPham); $i++) {
                        if (!empty($sanPham[$i]) && $soLuong[$i] > 0 && $giaNhap[$i] > 0) {
                            $sp  = (int)$sanPham[$i];
                            $sl  = (int)$soLuong[$i];
                            $gia = (float)$giaNhap[$i];

                            // Kiểm tra giá nhập phải nhỏ hơn giá bán
                            $giaBanResult = $connect->query("SELECT Gia FROM SanPham WHERE MaSP = $sp");
                            if (!$giaBanResult) {
                                throw new Exception("Lỗi khi lấy giá bán sản phẩm");
                            }
                            $giaBanRow = $giaBanResult->fetch_assoc();
                            $giaBan = $giaBanRow['Gia'];

                            if ($gia >= $giaBan) {
                                throw new Exception("Giá nhập phải nhỏ hơn giá bán!");
                            }

                            $sqlDetail = "INSERT INTO chitietphieunhap (MaNhap, MaSP, SL, GiaNhap) 
                                        VALUES ($maNhap, $sp, $sl, $gia)";
                            Database::NonQueryTrans($connect, $sqlDetail);

                            $sqlUpdate = "UPDATE sanpham SET SL = SL + $sl WHERE MaSP = $sp";
                            Database::NonQueryTrans($connect, $sqlUpdate);
                        }
                    }

                    Database::Commit($connect);
                    $message = ['type' => 'success', 'text' => 'Thêm phiếu nhập thành công'];
                } catch (Exception $e) {
                    Database::Rollback($connect);
                    $message = ['type' => 'error', 'text' => 'Lỗi: ' . $e->getMessage()];
                }
            } else {
                $message = ['type' => 'warning', 'text' => 'Vui lòng nhập ít nhất 1 sản phẩm hợp lệ'];
            }
        } else {
            $message = ['type' => 'warning', 'text' => 'Vui lòng chọn nhà cung cấp và nhập ít nhất 1 sản phẩm'];
        }
    }
}

// Xóa phiếu nhập 
if (isset($_GET['del-id'])) {
    $MaNhap = $_GET['del-id'];
    try {
        $connect = Database::BeginTransaction();
        
        // Lấy tất cả chi tiết để hoàn nguyên số lượng
        $chiTietList = Database::GetData("SELECT MaSP, SL FROM chitietphieunhap WHERE MaNhap=$MaNhap");
        foreach ($chiTietList as $chiTiet) {
            $sqlRestore = "UPDATE SanPham SET SL = SL - {$chiTiet['SL']} WHERE MaSP = {$chiTiet['MaSP']}";
            Database::NonQueryTrans($connect, $sqlRestore);
        }
        
        Database::NonQueryTrans($connect, "DELETE FROM chitietphieunhap WHERE MaNhap=$MaNhap");
        Database::NonQueryTrans($connect, "DELETE FROM phieunhap WHERE MaNhap=$MaNhap");
        
        Database::Commit($connect);
        $message = ['type'=>'success','text'=>'Xóa phiếu nhập thành công!'];
    } catch (Exception $e) {
        Database::Rollback($connect);
        $message = ['type'=>'error','text'=>'Có lỗi xảy ra: ' . $e->getMessage()];
    }
}
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Phiếu nhập</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Phiếu nhập</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal: thêm -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Thêm phiếu nhập</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nhà cung cấp <span class="text-danger">*</span></label>
                                    <select name="MaNCC" class="form-control" required>
                                        <option value="">Chọn nhà cung cấp</option>
                                        <?php
                                            foreach($nhacungcap as $ncc) {
                                                echo "<option value='{$ncc['MaNCC']}'>{$ncc['TenNCC']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea name="GhiChu" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <h5>Chi tiết phiếu nhập</h5>
                        <div id="chi-tiet-container">
                            <div class="chi-tiet-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Sản phẩm</label>
                                        <select name="sanpham[]" class="form-control" onchange="updatePrice(this)">
                                            <option value="">Chọn sản phẩm</option>
                                            <?php
                                                foreach($products as $sp) {
                                                    $giaHienThi = $sp['GiaKhuyenMai'] ? $sp['GiaKhuyenMai'] : $sp['Gia'];
                                                    echo "<option value='{$sp['MaSP']}' data-gia='{$giaHienThi}'>{$sp['TenSP']}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Số lượng</label>
                                        <input type="number" name="soluong[]" class="form-control" min="1" onchange="updateTotal()">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Giá nhập</label>
                                        <input type="number" step="0.01" name="gianhap[]" class="form-control" onchange="updateTotal()">
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

        <!-- Modal: chi tiết -->
        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title">Chi tiết phiếu nhập</h5>
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
                        <input type="text" name="keyword" placeholder="Từ khóa (Nhà cung cấp, Ghi chú)" class="form-control" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ''?>">
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
                                    <th>Mã nhập</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Tổng tiền</th>
                                    <th>Thời gian nhập</th>
                                    <th>Ghi chú</th>
                                    <th width="150">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $pager = (new Pagination())->get('phieunhap', $page, ROW_OF_PAGE);

                                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                    $where = '';
                                    if ($keyword) {
                                        $where = "WHERE nc.TenNCC LIKE '%$keyword%' OR pn.GhiChu LIKE '%$keyword%'";
                                    }

                                    $sqlNhap = "SELECT pn.MaNhap, pn.TGNhap, pn.GhiChu, nc.TenNCC,
                                                       COALESCE(SUM(ct.SL * ct.GiaNhap), 0) AS TongTien
                                                FROM phieunhap pn
                                                JOIN nhacungcap nc ON pn.MaNCC = nc.MaNCC
                                                LEFT JOIN chitietphieunhap ct ON pn.MaNhap = ct.MaNhap
                                                $where
                                                GROUP BY pn.MaNhap, pn.TGNhap, pn.GhiChu, nc.TenNCC
                                                ORDER BY pn.TGNhap DESC LIMIT " . $pager['StartIndex'] . ', ' . ROW_OF_PAGE;

                                    $phieuNhapList = Database::GetData($sqlNhap);

                                    if ($phieuNhapList) {
                                        foreach ($phieuNhapList as $pn) {
                                            echo '
                                                <tr>
                                                    <th>' . $pn['MaNhap'] . '</th>
                                                    <td>' . $pn['TenNCC'] . '</td>
                                                    <td>' . number_format($pn['TongTien'], 0, ',', '.') . ' VNĐ</td>
                                                    <td>' . date('d/m/Y H:i', strtotime($pn['TGNhap'])) . '</td>
                                                    <td>' . ($pn['GhiChu'] ?: '-') . '</td>
                                                    <td>
                                                        <button onclick="viewDetail(' . $pn['MaNhap'] . ')" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button onclick="removeRow(' . $pn['MaNhap'] . ')" class="btn btn-danger btn-sm" title="Xóa">
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
function removeRow(id) {
    if (confirm('Bạn có chắc chắn muốn xóa phiếu nhập này không? Tất cả chi tiết phiếu nhập cũng sẽ bị xóa và số lượng sản phẩm sẽ được trừ đi.')) {
        window.location = '?del-id=' + id;
    }
}

function updatePrice(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var gia = selectedOption.getAttribute('data-gia');
    
    var row = selectElement.closest('.chi-tiet-row');
    var giaInput = row.querySelector('input[name="gianhap[]"]');
    var slInput = row.querySelector('input[name="soluong[]"]');
    
    if (gia && selectedOption.value) {
        // Đặt giá nhập bằng 70% giá bán để đảm bảo có lãi
        giaInput.value = Math.round(gia * 0.7);
        slInput.value = 1;
    } else {
        giaInput.value = '';
        slInput.value = '';
    }
    updateTotal();
}

function updateTotal() {
    var total = 0;
    var rows = document.querySelectorAll('.chi-tiet-row');
    
    rows.forEach(function(row) {
        var slInput = row.querySelector('input[name="soluong[]"]');
        var giaInput = row.querySelector('input[name="gianhap[]"]');
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
    newRow.querySelector('input[name="gianhap[]"]').value = '';
    
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
        $('#detail-content').html('<div class="alert alert-danger">Có lỗi xảy ra khi tải chi tiết phiếu nhập</div>');
    });
}
</script>