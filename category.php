<?php include 'header.php'?>
<div class="single-product-area">
    <?php
        $maLoaiSP = isset($_GET['MaLoaiSP']) ? $_GET['MaLoaiSP'] : '';
        
        // Lấy tên loại sản phẩm
        if (!empty($maLoaiSP)) {
            $sql = "SELECT TenLoaiSP FROM LoaiSP WHERE MaLoaiSP = '$maLoaiSP'";
            $tenLoaiSP = Database::GetData($sql, ['row' => 0, 'cell' => 0]);
        } else {
            $tenLoaiSP = 'Tất cả sản phẩm';
        }
    ?>
    <div class="zigzag-bottom"></div>
    <div class="container">
        <h1 class="text-primary text-center"><?= $tenLoaiSP ?></h1>
        <div class="row">
            <?php
                // Lấy danh sách sản phẩm theo loại
                if (!empty($maLoaiSP)) {
                    $sql = "SELECT * FROM SanPham WHERE MaLoaiSP = '$maLoaiSP' ORDER BY UpdatedAt DESC";
                } else {
                    $sql = "SELECT * FROM SanPham ORDER BY UpdatedAt DESC";
                }
                
                $sanPhams = Database::GetData($sql);
                
                if (!empty($sanPhams)) {
                    foreach ($sanPhams as $sanPham) {
            ?>
            <div class="col-md-3 col-sm-6">
                <div class="single-shop-product">
                    <div class="product-upper">
                        <img src="<?= $sanPham['HinhAnh'] ?>" alt="<?= $sanPham['TenSP'] ?>" style="height: 320px; width: 100%; object-fit: cover;">
                    </div>
                    <h2><a href="<?= '/Salonoto/details.php?id=' . $sanPham['MaSP'] ?>"><?= $sanPham['TenSP'] ?></a></h2>
                   <div class="product-carousel-price">
                        <?php if (!empty($sanPham['GiaKhuyenMai']) && $sanPham['GiaKhuyenMai'] > 0): ?>
                            <ins><?= number_format($sanPham['GiaKhuyenMai']) ?> ₫</ins>
                            <?php if (!empty($sanPham['Gia']) && $sanPham['Gia'] > 0): ?>
                                <del><?= number_format($sanPham['Gia']) ?> ₫</del>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (!empty($sanPham['Gia']) && $sanPham['Gia'] > 0): ?>
                                <ins><?= number_format($sanPham['Gia']) ?> ₫</ins>
                            <?php else: ?>
                                <ins>Liên hệ</ins>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-option-shop">
                        <?php if (isset($_SESSION['Role']) && $_SESSION['Role'] == 3) { ?>
                        <a class="add_to_cart_button" href="<?= '/Salonoto/cart.php?id=' . $sanPham['MaSP'] ?>">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <?php } ?>
                        <a class="add_to_cart_button" href="<?= '/Salonoto/details.php?id=' . $sanPham['MaSP'] ?>">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php 
                    }
                } else {
            ?>
            <div class="col-md-12">
                <div class="text-center" style="padding: 50px 0;">
                    <h3>Không có sản phẩm nào trong danh mục này</h3>
                    <p>Vui lòng chọn danh mục khác hoặc quay lại trang chủ.</p>
                    <a href="/Salonoto/" class="btn btn-primary">Về trang chủ</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php include 'footer.php'?>