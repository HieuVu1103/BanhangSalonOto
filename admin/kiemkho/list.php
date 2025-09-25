<?php
include '../header.php';
include '../sidebar.php';


// Xử lý thêm phiếu kiểm
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_phieu'])) {
    $nguoiKiem = $_POST['NguoiKiem'] ?? '';
    $ghiChuPhieu = $_POST['GhiChuPhieu'] ?? '';
    $ngayKiem = date('Y-m-d H:i:s');

    // Thêm phiếu kiểm
    $sql = "INSERT INTO PhieuKiem (NguoiKiemKho, TGKiem, GhiChu) 
            VALUES ('$nguoiKiem', '$ngayKiem', '$ghiChuPhieu')";
    $maKiem = Database::NonQueryId($sql);

    // Thêm chi tiết phiếu kiểm
    foreach($_POST['SanPham'] as $maSP => $data) {
        $sltot = $data['SLTot'] ?? 0;
        $slhong = $data['SLHong'] ?? 0;
        $slbh = $data['SLCanBaoHanh'] ?? 0;
        $ghichu = $data['GhiChu'] ?? '';

        $sqlCt = "INSERT INTO ChiTietPhieuKiem (MaKiem, MaSP, SLTot, SLHong, SLCanBaoHanh, GhiChu)
                  VALUES ($maKiem, $maSP, $sltot, $slhong, $slbh, '$ghichu')";
        Database::NonQuery($sqlCt);
    }

    echo "<div class='alert alert-success'>Thêm phiếu kiểm thành công!</div>";
}

// Xử lý AJAX xem chi tiết phiếu kiểm trong cùng file
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaKiem'])) {
    $maKiem = (int)$_POST['MaKiem'];
    $chiTiet = Database::GetData("
        SELECT ct.*, sp.TenSP
        FROM ChiTietPhieuKiem ct
        JOIN SanPham sp ON ct.MaSP = sp.MaSP
        WHERE ct.MaKiem = $maKiem
    ");
    if($chiTiet):
?>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Tên SP</th>
        <th>Số lượng kiểm thực tế</th>
        <th>Số lượng hỏng</th>
        <th>Số lượng cần bảo hành</th>
        <th>Ghi chú</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($chiTiet as $ct): ?>
      <tr>
        <td><?=$ct['TenSP']?></td>
        <td><?=$ct['SLTot']?></td>
        <td><?=$ct['SLHong']?></td>
        <td><?=$ct['SLCanBaoHanh']?></td>
        <td><?=$ct['GhiChu']?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
</table>
<?php
    else:
        echo '<div class="text-warning">Không có chi tiết!</div>';
    endif;
    exit; 
}

// Lấy danh sách sản phẩm và phiếu kiểm
$products = Database::GetData("SELECT * FROM SanPham ORDER BY TenSP ASC");
$phieuKiems = Database::GetData("SELECT * FROM PhieuKiem ORDER BY TGKiem DESC");
?>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Quản lý kiểm kho</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- Form thêm phiếu kiểm -->
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">Thêm phiếu kiểm mới</div>
        <div class="card-body">
          <form method="POST">
            <div class="form-group mb-2">
              <label>Người kiểm kho</label>
              <input type="text" name="NguoiKiem" class="form-control" required>
            </div>
            <div class="form-group mb-3">
              <label>Ghi chú phiếu kiểm</label>
              <textarea name="GhiChuPhieu" class="form-control"></textarea>
            </div>

            <h5>Sản phẩm</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tên SP</th>
                  <th>Số lượng tồn</th>
                  <th>Số lượng kiểm thực tế</th>
                  <th>Số lượng hỏng</th>
                  <th>Số lượng cần bảo hành</th>
                  <th>Ghi chú</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($products as $p): ?>
                <tr>
                  <td><?=$p['TenSP']?></td>
                  <td><?=$p['SL']?></td>
                  <td><input type="number" name="SanPham[<?=$p['MaSP']?>][SLTot]" class="form-control" value="<?=$p['SL']?>"></td>
                  <td><input type="number" name="SanPham[<?=$p['MaSP']?>][SLHong]" class="form-control" value="0"></td>
                  <td><input type="number" name="SanPham[<?=$p['MaSP']?>][SLCanBaoHanh]" class="form-control" value="0"></td>
                  <td><input type="text" name="SanPham[<?=$p['MaSP']?>][GhiChu]" class="form-control"></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <button type="submit" name="add_phieu" class="btn btn-success">Thêm phiếu kiểm</button>
          </form>
        </div>
      </div>

      <!-- Danh sách phiếu kiểm -->
      <div class="card">
        <div class="card-header bg-info text-white">Danh sách phiếu kiểm</div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>MaKiem</th>
                <th>Người kiểm kho</th>
                <th>Thời gian kiểm</th>
                <th>Ghi chú</th>
                <th>Chi tiết</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($phieuKiems as $phieu): ?>
              <tr>
                <td><?=$phieu['MaKiem']?></td>
                <td><?=$phieu['NguoiKiemKho']?></td>
                <td><?=$phieu['TGKiem']?></td>
                <td><?=$phieu['GhiChu']?></td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" onclick="viewChiTiet(<?=$phieu['MaKiem']?>)">Xem chi tiết</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal chi tiết phiếu kiểm -->
      <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="chiTietModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
              <h5 class="modal-title" id="chiTietModalLabel">Chi tiết phiếu kiểm</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="chiTietContent">
              <div class="text-center">Đang tải...</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function viewChiTiet(maKiem) {
    var modalEl = document.getElementById('chiTietModal');
    var modal = new bootstrap.Modal(modalEl);
    modal.show();

    var formData = new FormData();
    formData.append('MaKiem', maKiem);

    fetch('', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(html => {
            document.getElementById('chiTietContent').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('chiTietContent').innerHTML = '<div class="text-danger">Lỗi tải dữ liệu!</div>';
        });
}
</script>

<?php include '../footer.php'; ?>
