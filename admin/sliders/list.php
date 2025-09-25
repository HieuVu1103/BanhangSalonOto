<?php include '../header.php'?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_path = '';
    if (isset($_FILES['pic']) && !empty($_FILES['pic']['name'])) {
        $filename   = basename($_FILES['pic']['name']);
        $image_path = '/Salonoto/assets/img/sliders/' . $filename;
        $full_path  = $_SERVER['DOCUMENT_ROOT'] . $image_path;

        $dir = dirname($full_path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['pic']['tmp_name'], $full_path)) {
            $message = ['type' => 'danger', 'text' => 'Upload ảnh thất bại!'];
        }
    }

    // thêm 
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 0;

        if (!empty($name)) {
            $sql = "INSERT INTO quangcao (TenQC, MoTa, AnhQC, TinhTrang) 
                    VALUES ('$name', '$description', '$image_path', $status)";
            if (Database::NonQuery($sql)) {
                $message = ['type' => 'success', 'text' => 'Thêm thành công'];
            }
        } else {
            $message = ['type' => 'warning', 'text' => 'Tên quảng cáo không được trống'];
        }
    }

    // sửa 
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = isset($_GET['edit-id']) ? $_GET['edit-id'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        if (!empty($name)) {
            $updates = [];
            $updates[] = "TenQC = '$name'";
            $updates[] = "MoTa = '$description'";
            if ($image_path != '/Salonoto/assets/img/sliders/') {
                $updates[] = "AnhQC = '$image_path'";
            }
            $updates[] = "TinhTrang = $status";

            $sql = "UPDATE quangcao SET " . implode(', ', $updates) . " WHERE MaQC = $id";

            if (Database::NonQuery($sql)) {
                $message = [
                    'type' => 'success',
                    'text' => 'Cập nhật thành công',
                ];
            }
        } else {
            $message = [
                'type' => 'warning',
                'text' => 'Tên quảng cáo không được trống',
            ];
        }
    }
}
// xóa
if (isset($_GET['del-id'])) {
    $id = $_GET['del-id'] ?? '';
    $sql = "DELETE FROM quangcao WHERE MaQC = $id";
    if (Database::NonQuery($sql)) {
        $message = ['type' => 'success', 'text' => 'Xoá thành công'];
    }
}
?>

<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Quảng cáo</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">Quảng cáo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal Thêm -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Thêm quảng cáo</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên quảng cáo</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="1">Hoạt động</option>
                                <option value="0">Khóa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                        <button name="action" value="add" class="btn btn-success">Thêm</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Sửa -->
        <?php
            $id = $_GET['edit-id'] ?? '';
            $qcData = [];
            if ($id != '') {
                $sql = "SELECT * FROM quangcao WHERE MaQC = $id";
                $qcData = Database::GetData($sql, ['row' => 0]);
            }
        ?>
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Sửa quảng cáo</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mã quảng cáo</label>
                            <input type="text" value="<?=$qcData['MaQC']?>" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tên quảng cáo</label>
                            <input type="text" name="name" value="<?=$qcData['TenQC']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" name="description" value="<?=$qcData['MoTa']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="1" <?=$qcData['TinhTrang'] == 1 ? 'selected' : ''?>>Hoạt động</option>
                                <option value="0" <?=$qcData['TinhTrang'] == 0 ? 'selected' : ''?>>Khóa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="window.location.href='list.php'">Hủy</button>
                        <button name="action" value="edit" class="btn btn-success">Sửa</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bảng quảng cáo -->
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
                                    <th>Mã quảng cáo</th>
                                    <th>Tên quảng cáo</th>
                                    <th>Mô tả</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                    <th width="111">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = $_GET['page'] ?? 1;
                                $pager = (new Pagination())->get('quangcao', $page, ROW_OF_PAGE);

                                $keyword = $_GET['keyword'] ?? '';
                                $where = $keyword ? "WHERE TenQC LIKE '%$keyword%'" : '';

                                $sql = "SELECT * FROM quangcao $where ORDER BY MaQC DESC LIMIT {$pager['StartIndex']}, " . ROW_OF_PAGE;
                                $qcList = Database::GetData($sql);

                                if ($qcList) {
                                    foreach ($qcList as $qc) {
                                        echo '<tr>
                                                <th>' . $qc['MaQC'] . '</th>
                                                <td>' . $qc['TenQC'] . '</td>
                                                <td>' . $qc['MoTa'] . '</td>
                                                <td><img height="60" src="' . $qc['AnhQC'] . '" alt="" /></td>
                                                <td>' . Helper::StatusBadge($qc['TinhTrang']) . '</td>
                                                <td>
                                                    <a href="?edit-id=' . $qc['MaQC'] . '" class="btn btn-warning"><i class="fas fa-marker"></i></a>
                                                    <a onclick="removeRow(' . $qc['MaQC'] . ')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                              </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="100%" class="text-center">Không có dữ liệu</td></tr>';
                                }
                                ?>
                                <button type="button" data-toggle="modal" data-target="#modal-edit" hidden id="open-edit"></button>
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
            if (urlparam[0] == param) return urlparam[1];
        }
    }

    if (GetParameterValues('edit-id') !== undefined) {
        document.getElementById('open-edit').click();
    }
});

function removeRow(id) {
    if (confirm('Bạn có chắc chắn muốn xoá không?')) {
        window.location = '?del-id=' + id;
    }
}
</script>
