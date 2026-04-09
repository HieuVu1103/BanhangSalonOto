<?php include '../header.php'?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // sửa
        if (isset($_POST['action']) && $_POST['action'] == 'edit') {
            $id = isset($_GET['edit-id']) ? $_GET['edit-id'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $accountType = isset($_POST['accountType']) ? $_POST['accountType'] : '';

            $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';

            $sql = "UPDATE users 
                    SET TrangThai = $status, MaQuyen = $accountType, 
                        TenDayDu = '$fullname', SDT = '$phone', Email = '$email'
                    WHERE TenTaiKhoan = '$id'";
            if (Database::NonQuery($sql)) {
                $message = [
                    'type' => 'success',
                    'text' => 'Cập nhật thành công',
                ];
                header("Location: list.php");
                    exit;
            }
        }
    }

    // xóa
    if (isset($_GET['del-id'])) {
        $id = isset($_GET['del-id']) ? $_GET['del-id'] : '';
        $sql = "DELETE FROM users WHERE TenTaiKhoan = '$id'";

        if (Database::NonQuery($sql)) {
            $message = [
                'type' => 'success',
                'text' => 'Xoá thành công',
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
                    <h1 class="m-0">Tài khoản</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Tài khoản</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal: sửa -->
        <?php
            $id = isset($_GET['edit-id']) ? $_GET['edit-id'] : '';
            $user = [];
            if ($id != '') {
                $sql = "SELECT * FROM users WHERE TenTaiKhoan = '$id'";
                $user = Database::GetData($sql, ['row' => 0]);
            }
        ?>
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Sửa tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên đăng nhập</label>
                            <input type="text" name="id" value="<?=$user['TenTaiKhoan']?>" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="0" <?=$user['TrangThai'] == 0 ? 'selected' : ''?>>Khóa</option>
                                <option value="1" <?=$user['TrangThai'] == 1 ? 'selected' : ''?>>Hoạt động</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullname" value="<?=$user['TenDayDu']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="<?=$user['SDT']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?=$user['Email']?>" class="form-control">
                        </div>
                        <?php
                            $sql = 'SELECT * FROM quyen';
                            $accountTypes = Database::GetData($sql);
                        ?>
                        <div class="form-group">
                            <label>Loại tài khoản</label>
                            <select class="form-control" name="accountType">
                                <?php foreach ($accountTypes as $accountType) {
                                        $selected = $accountType['MaQuyen'] == $user['MaQuyen'] ? 'selected' : '';
                                        echo '<option value="' . $accountType['MaQuyen'] . '" ' . $selected . '>' . $accountType['TenQuyen'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="window.location.href='list.php'">Hủy</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeRow('<?=$user['TenTaiKhoan']?>')">Xóa tài khoản</button>
                        <button name="action" value="edit" class="btn btn-success">Sửa</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row my-2 d-flex-end">
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
                                    <th>Tên đăng nhập</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Avatar</th>
                                    <th>Trạng thái</th>
                                    <th>Loại tài khoản</th>
                                    <th>Ngày tạo</th>
                                    <th width="113">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $pager = (new Pagination())->get('users', $page, ROW_OF_PAGE);

                                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                                    if ($keyword) {
                                        $keyword = "AND (TenTaiKhoan LIKE '%$keyword%' OR TenDayDu LIKE '%$keyword%' OR Email LIKE '%$keyword%')";
                                    }

                                    $sql = "SELECT u.*, q.TenQuyen 
                                            FROM users u 
                                            LEFT JOIN quyen q ON u.MaQuyen = q.MaQuyen 
                                            WHERE 1 $keyword 
                                            LIMIT " . $pager['StartIndex'] . ', ' . ROW_OF_PAGE;
                                    $users = Database::GetData($sql);

                                    if ($users) {
                                        foreach ($users as $user) {
                                            echo '
                                                <tr>
                                                    <td>' . $user['TenTaiKhoan'] . '</td>
                                                    <td>' . $user['TenDayDu'] . '</td>
                                                    <td>' . $user['Email'] . '</td>
                                                    <td>' . Helper::Phone($user['SDT']) . '</td>
                                                    <td>' . $user['DiaChi'] . '</td>
                                                    <td><img src="' . $user['Avatar'] . '" style="width:50px;height:50px;border-radius:50%;object-fit:cover"></td>
                                                    <td>' . Helper::StatusBadge($user['TrangThai']) . '</td>
                                                    <td>' . ($user['TenQuyen'] ?? 'Chưa gán quyền') . '</td>
                                                    <td>' . $user['CreatedAt'] . '</td>
                                                    <td>
                                                        <a href="?edit-id=' . $user['TenTaiKhoan'] . '" class="btn btn-warning"><i class="fas fa-marker"></i></a>
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
