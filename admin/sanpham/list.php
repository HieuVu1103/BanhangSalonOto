<?php include '../header.php'?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $action = $_POST['action'] ?? '';

    $image_path = '';
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK) {
        // Thư mục lưu ảnh
        $uploadDir = __DIR__ . '/../../assets/img/sanpham/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Lấy tên file gốc
        $filename = $_FILES['pic']['name'];
        $targetPath = $uploadDir . $filename;

        // Di chuyển file từ tmp sang thư mục lưu
        if (move_uploaded_file($_FILES['pic']['tmp_name'], $targetPath)) {
            $image_path = '/Salonoto/assets/img/sanpham/' . $filename;
        } else {
            echo "Upload thất bại!";
            $image_path = null;
        }
    } else {
        $image_path = null; // hoặc giữ nguyên ảnh cũ khi edit
    }

    // ===== THÊM SẢN PHẨM =====
    if ($action == 'add') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $manufacturer = $_POST['manufacturer'] ?? ''; // nhà sản xuất
        $feature = $_POST['feature'] ?? ''; // tính năng
        $price = $_POST['price'] ?? 0;
        $promo_price = $_POST['promo_price'] ?? null; // giá khuyến mãi
        $category = $_POST['category'] ?? '';
        $warranty = $_POST['warranty'] ?? 0;

        if (!empty($name) && $image_path) {
            if ($promo_price !== null && $promo_price !== '') {
                $columns = "TenSP, ThongSo, TinhNang, NhaSanXuat, Gia, GiaKhuyenMai, HinhAnh, MaLoaiSP, ThoiGianBaoHanh, UpdatedAt";
                $values = "'$name', '$description', '$feature', '$manufacturer', $price, $promo_price, '$image_path', '$category', $warranty, NOW()";
            } else {
                $columns = "TenSP, ThongSo, TinhNang, NhaSanXuat, Gia, HinhAnh, MaLoaiSP, ThoiGianBaoHanh, UpdatedAt";
                $values = "'$name', '$description', '$feature', '$manufacturer', $price, '$image_path', '$category', $warranty, NOW()";
            }

            $sql = "INSERT INTO SanPham ($columns) VALUES ($values)";
            if (Database::NonQuery($sql)) {
                $message = ['type'=>'success','text'=>'Thêm sản phẩm thành công'];
            }
        } else {
            $message = ['type'=>'warning','text'=>'Tên sản phẩm và ảnh không được để trống'];
        }
    }

    // ===== SỬA SẢN PHẨM =====
    if ($action == 'edit') {
        $id = $_GET['edit-id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $manufacturer = $_POST['manufacturer'] ?? ''; // nhà sản xuất
        $feature = $_POST['feature'] ?? ''; // tính năng
        $price = $_POST['price'] ?? 0;
        $promo_price = $_POST['promo_price'] ?? null; // giá khuyến mãi
        $category = $_POST['category'] ?? '';
        $warranty = $_POST['warranty'] ?? 0;

        if (!empty($name) && $id) {
            $updates = [];
            $updates[] = "TenSP='$name'";
            $updates[] = "ThongSo='$description'";
            $updates[] = "TinhNang='$feature'";
            $updates[] = "NhaSanXuat='$manufacturer'";
            $updates[] = "Gia=$price";
            if ($promo_price !== null && $promo_price !== '') {
                $updates[] = "GiaKhuyenMai=$promo_price";
            } else {
                $updates[] = "GiaKhuyenMai=NULL";
            }
            if ($image_path) {
                $updates[] = "HinhAnh='$image_path'";
            }
            $updates[] = "MaLoaiSP='$category'";
            $updates[] = "ThoiGianBaoHanh=$warranty";
            $updates[] = "UpdatedAt=NOW()";

            $sql = "UPDATE SanPham SET " . implode(", ", $updates) . " WHERE MaSP=$id";

            if (Database::NonQuery($sql)) {
                $message = ['type'=>'success','text'=>'Cập nhật sản phẩm thành công'];
                header("Location: list.php");
                    exit;
            }
        } else {
            $message = ['type'=>'warning','text'=>'Tên sản phẩm không được để trống'];
        }
    }


    // ===== XÓA KHUYẾN MÃI =====
    if ($action == 'remove-promo') {
        $id = $_GET['edit-id'] ?? '';
        if ($id) {
            $sql = "UPDATE SanPham SET GiaKhuyenMai=NULL WHERE MaSP=$id";
            if (Database::NonQuery($sql)) {
                $message = ['type'=>'success','text'=>'Xóa khuyến mãi thành công'];
            }
        }
    }
}

// ===== XÓA SẢN PHẨM =====
if (isset($_GET['del-id'])) {
    $id = $_GET['del-id'] ?? '';
    if ($id) {
        $sql = "DELETE FROM SanPham WHERE MaSP=$id";
        if (Database::NonQuery($sql)) {
            $message = ['type'=>'success','text'=>'Xoá sản phẩm thành công'];
        }
    }
}
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sản phẩm</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
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
        <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 800px">
            <form class="modal-content" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Tên sản phẩm -->
                        <div class="col-md-6 form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Mô tả -->
                        <div class="col-md-6 form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Nhà sản xuất -->
                        <div class="col-md-6 form-group">
                            <label>Nhà sản xuất</label>
                            <input type="text" name="manufacturer" class="form-control">
                        </div>

                        <!-- Tính năng -->
                        <div class="col-md-6 form-group">
                            <label>Tính năng</label>
                            <textarea name="feature" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Hình ảnh -->
                        <div class="col-md-6 form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="pic" class="form-control" required>
                        </div>

                        <!-- Giá -->
                        <div class="col-md-6 form-group">
                            <label>Giá</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="col-md-6 form-group">
                            <label>Giá khuyến mãi</label>
                            <input type="number" name="promo_price" class="form-control" placeholder="Nếu có">
                        </div>

                        <!-- Loại sản phẩm -->
                        <div class="col-md-6 form-group">
                            <label>Loại sản phẩm</label>
                            <select class="form-control" name="category">
                                <?php
                                    $sql = 'SELECT * FROM LoaiSP';
                                    $categories = Database::GetData($sql);
                                    if ($categories) {
                                        foreach ($categories as $cate) {
                                            echo '<option value="' . $cate['MaLoaiSP'] . '">' . $cate['TenLoaiSP'] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- Thời gian bảo hành -->
                        <div class="col-md-6 form-group">
                            <label>Thời gian bảo hành (năm)</label>
                            <input type="number" name="warranty" class="form-control" min="0" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                    <button name="action" value="add" class="btn btn-success">Thêm</button>
                </div>
            </form>
        </div>
    </div>


<!-- Modal: Edit -->
<?php
    $id = $_GET['edit-id'] ?? '';
    $product = [];
    if ($id != '') {
        $sql = "SELECT * FROM SanPham WHERE MaSP = $id";
        $product = Database::GetData($sql, ['row' => 0]);
    }
?>
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 800px">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Sửa sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Mã sản phẩm -->
                    <div class="col-md-6 form-group">
                        <label>Mã sản phẩm</label>
                        <input type="text" value="<?=$product['MaSP']?>" class="form-control" disabled>
                    </div>

                    <!-- Tên sản phẩm -->
                    <div class="col-md-6 form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="name" value="<?=$product['TenSP']?>" class="form-control">
                    </div>

                    <!-- Mô tả -->
                    <div class="col-md-6 form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="3"><?=$product['ThongSo']?></textarea>
                    </div>

                    <!-- Tính năng -->
                    <div class="col-md-6 form-group">
                        <label>Tính năng</label>
                        <textarea name="feature" class="form-control" rows="3"><?=$product['TinhNang']?></textarea>
                    </div>

                    <!-- Nhà sản xuất -->
                    <div class="col-md-6 form-group">
                        <label>Nhà sản xuất</label>
                        <input type="text" name="manufacturer" value="<?=$product['NhaSanXuat']?>" class="form-control">
                    </div>

                    <!-- Hình ảnh -->
                    <div class="col-md-6 form-group">
                        <label>Hình ảnh</label>
                        <input type="file" name="pic" class="form-control">
                        <?php if(!empty($product['HinhAnh'])): ?>
                            <img src="<?=$product['HinhAnh']?>" alt="" class="img-fluid mt-2" style="max-height:150px;">
                        <?php endif; ?>
                    </div>

                    <!-- Giá -->
                    <div class="col-md-6 form-group">
                        <label>Giá</label>
                        <input type="number" name="price" value="<?=$product['Gia']?>" class="form-control">
                    </div>

                    <!-- Giá khuyến mãi -->
                    <div class="col-md-6 form-group">
                        <label>Giá khuyến mãi</label>
                        <input type="number" name="promo_price" value="<?=$product['GiaKhuyenMai']?>" class="form-control" placeholder="Nếu có">
                    </div>

                    <!-- Loại sản phẩm -->
                    <div class="col-md-6 form-group">
                        <label>Loại sản phẩm</label>
                        <select class="form-control" name="category">
                            <?php
                                $sql = 'SELECT * FROM LoaiSP';
                                $categories = Database::GetData($sql);
                                if ($categories) {
                                    foreach ($categories as $cate) {
                                        $selected = $cate['MaLoaiSP'] == $product['MaLoaiSP'] ? 'selected' : '';
                                        echo '<option value="' . $cate['MaLoaiSP'] . '" ' . $selected . '>' . $cate['TenLoaiSP'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Thời gian bảo hành -->
                    <div class="col-md-6 form-group">
                        <label>Thời gian bảo hành (năm)</label>
                        <input type="number" name="warranty" class="form-control" min="0" value="<?=$product['ThoiGianBaoHanh'] ?? 0?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="window.location.href='list.php'">Hủy</button>
                <button name="action" value="edit" class="btn btn-success">Sửa</button>
                <button name="action" value="remove-promo" class="btn btn-warning">Xóa KM</button>
            </div>
        </form>
    </div>
</div>

        <div class="container-fluid">
            <div class="row my-2 d-flex-end">
                <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-add">
                    <i class="fas fa-plus"></i>
                </button>
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Từ khoá" class="form-control">
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
                                                <th>Mã sản phẩm</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Nhà sản xuất</th>
                                                <th>Mô tả</th>
                                                <th>Tính năng</th>
                                                <th>Giá</th>
                                                <th>Giá khuyến mãi</th>
                                                <th>Loại</th>
                                                <th>Bảo hành (năm)</th>
                                                <th width="200">Công cụ</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                <?php
                                    $page = $_GET['page'] ?? 1;
                                    $pager = (new Pagination())->get('SanPham', $page, ROW_OF_PAGE);

                                    $keyword = $_GET['keyword'] ?? '';
                                    $keyword_sql = $keyword ? "AND sp.TenSP LIKE '%$keyword%'" : '';

                                    $sql = "SELECT sp.*, l.TenLoaiSP 
                                            FROM SanPham sp 
                                            JOIN LoaiSP l ON sp.MaLoaiSP = l.MaLoaiSP 
                                            WHERE 1=1 $keyword_sql 
                                            ORDER BY sp.UpdatedAt DESC 
                                            LIMIT " . $pager['StartIndex'] . ', ' . ROW_OF_PAGE;
                                    $products = Database::GetData($sql);

                                                if ($products) {
                                            foreach ($products as $sp) {
                                                echo '
                                                    <tr>
                                                        <th>' . $sp['MaSP'] . '</th>
                                                        <td>' . $sp['TenSP'] . '</td>
                                                        <td class="text-center"><img height="150" src="' . $sp['HinhAnh'] . '" alt="" /></td>
                                                        <td>' . ($sp['NhaSanXuat'] ?? '-') . '</td>
                                                        <td>' . ($sp['ThongSo'] ?? '-') . '</td>
                                                        <td>' . ($sp['TinhNang'] ?? '-') . '</td>
                                                        <td>' . Helper::Currency($sp['Gia']) . '</td>
                                                        <td>' . ($sp['GiaKhuyenMai'] ? Helper::Currency($sp['GiaKhuyenMai']) : '-') . '</td>
                                                        <td>' . $sp['TenLoaiSP'] . '</td>
                                                        <td>' . ($sp['ThoiGianBaoHanh'] ?? 0) . '</td>
                                                        <td>
                                                            <a href="?edit-id=' . $sp['MaSP'] . '" class="btn btn-warning"><i class="fas fa-marker"></i></a>
                                                            <a onclick="removeRow(' . $sp['MaSP'] . ')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
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
    if (confirm('Bạn có chắc chắn muốn xoá không?')) {
        window.location = '?del-id=' + id;
    }
}
</script>
