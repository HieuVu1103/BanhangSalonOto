<?php include '../header.php'?>
<?php include '../sidebar.php'?>

<?php
// Xử lý POST (Thêm / Sửa)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $action = $_POST['action'] ?? '';

    // thêm
    if ($action == 'add') {
        $name = $_POST['name'] ?? '';
        $status = $_POST['status'] ?? 'HoatDong';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;

        if (!empty($name) && $price > 0) {
            $sql = "INSERT INTO dichvu (TenDichVu, TrangThai, MoTa, Gia) VALUES ('$name','$status','$description',$price)";
            if (Database::NonQuery($sql)) $message = ['type'=>'success','text'=>'Thêm dịch vụ thành công'];
        } else {
            $message = ['type'=>'warning','text'=>'Tên dịch vụ không được để trống và giá phải lớn hơn 0'];
        }
    }

    // sửa
    if ($action == 'edit') {
        $id = $_POST['edit_id'] ?? '';
        $name = $_POST['name'] ?? '';
        $status = $_POST['status'] ?? 'HoatDong';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;

        if (!empty($name) && $id && $price > 0) {
            $sql = "UPDATE dichvu SET TenDichVu='$name', TrangThai='$status', MoTa='$description', Gia=$price WHERE MaDichVu=$id";
            if (Database::NonQuery($sql)) $message = ['type'=>'success','text'=>'Cập nhật dịch vụ thành công'];
        } else {
            $message = ['type'=>'warning','text'=>'Tên dịch vụ không được để trống và giá phải lớn hơn 0'];
        }
    }
}

// xóa
if (isset($_GET['del-id'])) {
    $id = $_GET['del-id'] ?? '';
    if ($id) {
        $sql = "DELETE FROM dichvu WHERE MaDichVu=$id";
        if (Database::NonQuery($sql)) $message = ['type'=>'success','text'=>'Xoá dịch vụ thành công'];
    }
}

function ServiceStatusBadge($status) {
    switch ($status) {
        case 'HoatDong': return '<span class="badge bg-success">Hoạt động</span>';
        case 'KhongHoatDong': return '<span class="badge bg-danger">Không hoạt động</span>';
        default: return '<span class="badge bg-secondary">Không xác định</span>';
    }
}

function FormatPrice($price) {
    return number_format($price, 0, '.', ',') . ' VNĐ';
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Dịch vụ</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=ADMIN_URL?>/"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item active">Dịch vụ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <?php include '../alert.php'?>

        <!-- Modal Thêm dịch vụ -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 600px">
                <form class="modal-content" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Thêm dịch vụ</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên dịch vụ <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Mô tả chi tiết về dịch vụ..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" min="1" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="HoatDong">Hoạt động</option>
                                <option value="KhongHoatDong">Không hoạt động</option>
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

        <!-- Modal Sửa dịch vụ -->
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 600px">
                <form class="modal-content" method="POST">
                    <input type="hidden" name="edit_id" id="edit_id" value="">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Sửa dịch vụ</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mã dịch vụ</label>
                            <input type="text" id="edit_code" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tên dịch vụ <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3" placeholder="Mô tả chi tiết về dịch vụ..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="edit_price" class="form-control" min="1" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status" id="edit_status">
                                <option value="HoatDong">Hoạt động</option>
                                <option value="KhongHoatDong">Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Huỷ</button>
                        <button name="action" value="edit" class="btn btn-success">Sửa</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danh sách -->
        <div class="container-fluid">
            <div class="row my-2 d-flex-end">
                <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus"></i></button>
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Từ khoá" class="form-control" value="<?=htmlspecialchars($_GET['keyword'] ?? '')?>">
                        <div class="input-group-append"><button class="btn btn-outline-info"><i class="fas fa-search"></i></button></div>
                    </div>
                </form>
            </div>

            <div class="row my-2">
                <div class="card" style="width:100%">
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th>Mã DV</th>
                                    <th>Tên dịch vụ</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th width="120">Công cụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = $_GET['page'] ?? 1;
                                $pager = (new Pagination())->get('dichvu', $page, ROW_OF_PAGE);

                                $keyword = $_GET['keyword'] ?? '';
                                $keyword_sql = $keyword ? "WHERE TenDichVu LIKE '%$keyword%'" : '';

                                $services = Database::GetData("SELECT * FROM dichvu $keyword_sql ORDER BY MaDichVu DESC LIMIT ".$pager['StartIndex'].','.ROW_OF_PAGE);

                                if ($services) {
                                    foreach($services as $dv) {
                                        echo '<tr>
                                            <th>'.$dv['MaDichVu'].'</th>
                                            <td>'.$dv['TenDichVu'].'</td>
                                            <td>'.($dv['MoTa'] ? substr($dv['MoTa'], 0, 50).'...' : '<em>Không có mô tả</em>').'</td>
                                            <td><strong>'.FormatPrice($dv['Gia']).'</strong></td>
                                            <td>'.ServiceStatusBadge($dv['TrangThai']).'</td>
                                            <td>
                                                <button class="btn btn-warning btn-edit" 
                                                    data-id="'.$dv['MaDichVu'].'" 
                                                    data-name="'.htmlspecialchars($dv['TenDichVu'], ENT_QUOTES).'" 
                                                    data-description="'.htmlspecialchars($dv['MoTa'] ?? '', ENT_QUOTES).'"
                                                    data-price="'.$dv['Gia'].'"
                                                    data-status="'.$dv['TrangThai'].'">
                                                    <i class="fas fa-marker"></i>
                                                </button>
                                                <a onclick="removeRow('.$dv['MaDichVu'].')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>';
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

<script>
function removeRow(id){
    if(confirm('Bạn có chắc chắn muốn xoá không?')){
        window.location='?del-id='+id;
    }
}

// Bật modal sửa và điền dữ liệu
$(document).ready(function(){
    $('.btn-edit').click(function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');
        var price = $(this).data('price');
        var status = $(this).data('status');

        $('#edit_id').val(id);
        $('#edit_code').val(id);
        $('#edit_name').val(name);
        $('#edit_description').val(description);
        $('#edit_price').val(price);
        $('#edit_status').val(status);

        $('#modal-edit').modal('show');
    });
});
</script>