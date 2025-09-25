<?php 
include 'header.php';
?>

<div class="slider-area">
    <div class="block-slider block-slider4">
        <ul id="bxslider-home4">
            <?php
            $quangcaoData = Database::GetData("SELECT * FROM quangcao WHERE TinhTrang = 1");
            if ($quangcaoData) {
                foreach ($quangcaoData as $qc) {
                    echo '<li>
                            <img src="' . htmlspecialchars($qc['AnhQC']) . '" alt="Slide">
                        </li>';
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="promo-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo1">
                    <i class="fas fa-sync"></i>
                    <p>Hoàn trả 30 ngày</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo2">
                    <i class="fas fa-truck"></i>
                    <p>Vận chuyển miễn phí</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo3">
                    <i class="fas fa-lock"></i>
                    <p>Thanh toán an toàn</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo4">
                    <i class="fas fa-gift"></i>
                    <p>Quà tặng khuyến mãi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Sản phẩm mới nhất</h2>
                    <div class="product-carousel">
                        <?php
                        $SanPham = Database::GetData("SELECT * FROM sanpham ORDER BY UpdatedAt DESC LIMIT 5");
                        if ($SanPham) {
                            foreach ($SanPham as $sp) {
                        ?>
                        <div class="single-product">
                            <div class="product-f-image">
                                <img src="<?= htmlspecialchars($sp['HinhAnh']) ?>" alt="<?= htmlspecialchars($sp['TenSP']) ?>">
                                <div class="product-hover">
                                    <?php 
                                    if (isset($_SESSION['MaQuyen']) && $_SESSION['MaQuyen'] == 3) {
                                        if ($sp['SL'] > 0) { 
                                    ?>
                                        <a href="/Salonoto/cart.php?id=<?= $sp['MaSP'] ?>" class="add-to-cart-link">
                                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                        </a>
                                    <?php 
                                        }
                                    } 
                                    ?>
                                    <a href="/Salonoto/details.php?id=<?= $sp['MaSP'] ?>" class="view-details-link">
                                        <i class="fa fa-link"></i> Chi tiết
                                    </a>
                                </div>
                            </div>
                            <h2><a href="/Salonoto/details.php?id=<?= $sp['MaSP'] ?>"><?= htmlspecialchars($sp['TenSP']) ?></a></h2>
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
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
