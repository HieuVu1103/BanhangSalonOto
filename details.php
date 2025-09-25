<?php include 'header.php'?>
<?php
$maSP = isset($_GET['id']) ? $_GET['id'] : '';

// Lấy thông tin sản phẩm kèm loại
$sql = "SELECT sp.*, lsp.TenLoaiSP 
        FROM sanpham sp 
        LEFT JOIN loaisp lsp ON sp.MaLoaiSP = lsp.MaLoaiSP 
        WHERE sp.MaSP = '$maSP'";
$sanPham = Database::GetData($sql, ['row' => 0]);

// Xử lý giá hiển thị
$giaHienThi = $sanPham['GiaKhuyenMai'] && $sanPham['GiaKhuyenMai'] > 0 ? $sanPham['GiaKhuyenMai'] : $sanPham['Gia'];
$giamGiaPhanTram = ($sanPham['GiaKhuyenMai'] && $sanPham['GiaKhuyenMai'] > 0) ? round((($sanPham['Gia'] - $sanPham['GiaKhuyenMai']) / $sanPham['Gia']) * 100) : 0;

// Lấy sản phẩm liên quan
$relatedSql = "SELECT sp.* 
               FROM sanpham sp
               WHERE sp.MaLoaiSP = '{$sanPham['MaLoaiSP']}' 
                 AND sp.MaSP != '{$sanPham['MaSP']}'
               ORDER BY UpdatedAt DESC
               LIMIT 8";
$relatedProducts = Database::GetData($relatedSql);
?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div style="width:100%; display:flex; max-width:1200px; margin:0 auto;">
            <!-- Cột ảnh -->
            <div style="width:500px; flex-shrink:0; padding-right:16px;">
                <?php if(!empty($sanPham['HinhAnh'])): ?>
                    <img src="<?=$sanPham['HinhAnh']?>" alt="<?=$sanPham['TenSP']?>" 
                         style="width:100%; height:100%; max-height:600px; object-fit:contain; display:block;">
                <?php else: ?>
                    <div style="width:100%; height:320px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#999;">
                        Chưa có ảnh
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cột thông tin -->
            <div style="width:500px; flex-shrink:0; padding-left:16px;">
                <h2 class="section-title" style="text-align:left; font-weight:bold; color:#0077cc; font-size:50px;">
                    Thông tin sản phẩm
                </h2>
                <p><b>Tên sản phẩm: </b><?=$sanPham['TenSP']?></p>
                <p><b>Nhà sản xuất: </b><?= !empty($sanPham['NhaSanXuat']) ? $sanPham['NhaSanXuat'] : 'Chưa có thông tin'; ?></p>
                <p><b>Giá: </b>
                    <?php if($giamGiaPhanTram > 0): ?>
                        <ins><?=number_format($giaHienThi)?> ₫</ins>
                        <del style="color:#999; margin-left:10px;"><?=number_format($sanPham['Gia'])?> ₫</del>
                        <span style="color:red; font-weight:bold; margin-left:10px;">-<?=$giamGiaPhanTram?>%</span>
                    <?php else: ?>
                        <ins><?=number_format($giaHienThi)?> ₫</ins>
                    <?php endif; ?>
                </p>
                <p><b>Loại sản phẩm: </b>
                    <?php if(isset($sanPham['TenLoaiSP'])): ?>
                        <a href="<?='/Salonoto/category.php?MaLoaiSP=' . $sanPham['MaLoaiSP']?>"><?=$sanPham['TenLoaiSP']?></a>
                    <?php else: ?>Chưa phân loại<?php endif; ?>
                </p>
                <p><b>Số lượng: </b>
                    <?php
                        if(isset($sanPham['SL'])){
                            echo $sanPham['SL'] > 0 ? '<strong>'.$sanPham['SL'].'</strong>' : '<span style="color:red;font-weight:bold;">Liên hệ</span>';
                        } else { echo 'Chưa có thông tin'; }
                    ?>
                </p>
                <p><b>Thời gian bảo hành: </b>
                    <?= isset($sanPham['ThoiGianBaoHanh']) && $sanPham['ThoiGianBaoHanh']>0 ? $sanPham['ThoiGianBaoHanh'].' năm' : 'Chưa có thông tin'; ?>
                </p>
                <p><b>Thông số sản phẩm: </b></p>
                <ul>
                    <?php 
                    $lines = explode("\n", $sanPham['ThongSo']);
                    foreach($lines as $line){
                        $line = trim($line, "- \t\n\r\0\x0B");
                        if(!empty($line)) echo "<li>".htmlspecialchars($line)."</li>";
                    }
                    ?>
                </ul>
                <p><b>Mô tả sản phẩm: </b></p>
                <ul>
                    <?php 
                    $descLines = explode("\n", $sanPham['TinhNang']);
                    foreach($descLines as $line){
                        $line = trim($line, "- \t\n\r\0\x0B");
                        if(!empty($line)) echo "<li>".htmlspecialchars($line)."</li>";
                    }
                    ?>
                </ul>

                <?php if(isset($sanPham['SL']) && $sanPham['SL'] > 0 && isset($_SESSION['MaQuyen']) && $_SESSION['MaQuyen']==3): ?>
                    <div class="product-option-shop">
                        <form method="POST" action="cart.php" style="display:inline-block;">
                            <input type="hidden" name="MaSP" value="<?=$sanPham['MaSP']?>">
                            <label>Số lượng: </label>
                            <input type="number" name="SL" value="1" min="1" max="<?=$sanPham['SL']?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Sản phẩm liên quan -->
<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title" style="text-align:left; font-weight:bold; color:#0077cc; font-size:30px;">
                        Sản phẩm liên quan
                    </h2>
                    <div class="product-carousel">
                        <?php foreach ($relatedProducts as $sp): ?>
                        <div class="single-product">
                            <div class="product-f-image">
                                <img src="<?=$sp['HinhAnh']?>" alt="<?=$sp['TenSP']?>">
                                <div class="product-hover">
                                    <?php if(isset($_SESSION['MaQuyen']) && $_SESSION['MaQuyen']==3){ ?>
                                        <a href="<?='/Salonoto/cart.php?id=' . $sp['MaSP']?>" class="add-to-cart-link">
                                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                        </a>
                                    <?php } ?>
                                    <a href="<?='/Salonoto/details.php?id=' . $sp['MaSP']?>" class="view-details-link">
                                        <i class="fa fa-link"></i> Chi tiết
                                    </a>
                                </div>
                            </div>
                            <h2><a href="<?='/Salonoto/details.php?id=' . $sp['MaSP']?>"><?=$sp['TenSP']?></a></h2>
                            <div class="product-carousel-price">
                                <?php 
                                    $gia = $sp['GiaKhuyenMai'] && $sp['GiaKhuyenMai']>0 ? $sp['GiaKhuyenMai'] : $sp['Gia'];
                                    $giam = ($sp['GiaKhuyenMai'] && $sp['GiaKhuyenMai']>0) ? round((($sp['Gia']-$sp['GiaKhuyenMai'])/$sp['Gia'])*100) : 0;
                                ?>
                                <?php if($giam>0): ?>
                                    <ins><?=number_format($gia)?> ₫</ins>
                                    <del style="color:#999; margin-left:5px;"><?=number_format($sp['Gia'])?> ₫</del>
                                    <span style="color:red; font-weight:bold; margin-left:5px;">-<?=$giam?>%</span>
                                <?php else: ?>
                                    <ins><?=number_format($gia)?> ₫</ins>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'?>
