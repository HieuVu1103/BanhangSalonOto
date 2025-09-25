<?php include 'header.php'?>
<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">

        <?php
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 8;
        $offset = ($page - 1) * $limit;

        $keyword = isset($_GET['keyword']) ? "WHERE sp.TenSP LIKE '%" . $_GET['keyword'] . "%'" : '';

        // lấy sản phẩm 
        $sql = "SELECT sp.*, sp.SL AS SLTon
                FROM sanpham sp
                $keyword
                ORDER BY sp.UpdatedAt DESC
                LIMIT $limit OFFSET $offset";
        $SanPham = Database::GetData($sql);

        //tính tổng số trang
        $countSql = "SELECT COUNT(*) as total FROM sanpham sp $keyword";
        $totalResult = Database::GetData($countSql, ['row' => 0]);
        $totalProducts = $totalResult['total'];
        $totalPages = ceil($totalProducts / $limit);
        ?>

        <div class="row">
            <?php foreach ($SanPham as $sp): 
                $giaHienThi = ($sp['GiaKhuyenMai'] && $sp['GiaKhuyenMai']>0) ? $sp['GiaKhuyenMai'] : $sp['Gia'];
                $giamPhanTram = ($sp['GiaKhuyenMai'] && $sp['GiaKhuyenMai']>0) ? round((($sp['Gia'] - $sp['GiaKhuyenMai']) / $sp['Gia']) * 100) : 0;
            ?>
            <div class="col-md-3 col-sm-6" style="margin-bottom:20px;">
                <div class="single-shop-product">
                    <div class="product-upper" style="width:100%; height:320px; overflow:hidden; text-align:center;">
                        <img src="<?=$sp['HinhAnh']?>" style="width:100%; height:100%; object-fit:fill;">
                    </div>
                    <h2><a href="<?='/Salonoto/details.php?id=' . $sp['MaSP']?>"><?=$sp['TenSP']?></a></h2>
                    
                    <div class="product-carousel-price">
                        <?php if($giamPhanTram > 0): ?>
                            <ins><?=number_format($giaHienThi)?> ₫</ins>
                            <del style="color:#999; margin-left:5px;"><?=number_format($sp['Gia'])?> ₫</del>
                            <span style="color:red; font-weight:bold; margin-left:5px;">-<?=$giamPhanTram?>%</span>
                        <?php else: ?>
                            <ins><?=number_format($giaHienThi)?> ₫</ins>
                        <?php endif; ?>
                    </div>

                    <div class="product-option-shop">
                        <?php if (isset($_SESSION['MaQuyen']) && $_SESSION['MaQuyen'] == 3) { ?>
                            <a class="add_to_cart_button" href="#" 
                               onclick="return addToCart('<?=$sp['MaSP']?>', '<?=isset($sp['SLTon']) ? $sp['SLTon'] : 0?>')">
                               <i class="fas fa-cart-plus"></i>
                            </a>
                        <?php } ?>
                        <a class="add_to_cart_button" href="<?='/Salonoto/details.php?id=' . $sp['MaSP']?>">Chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?<?php 
                    echo isset($_GET['keyword']) ? "keyword=".$_GET['keyword']."&" : "";
                    echo "page=$i"; 
                ?>" 
                   style="margin:0 5px; padding:5px 10px; background:#0077cc; color:#fff; text-decoration:none; border-radius:3px;">
                   <?=$i?>
                </a>
            <?php endfor; ?>
        </div>

    </div>
</div>

<script>
function addToCart(maSP, slTon) {
    if (!slTon || slTon <= 0) {
        alert("Sản phẩm này đã hết hàng!");
        return false;
    } else {
        // Gọi ajax để thêm vào giỏ hàng mà không rời trang
        fetch("/Salonoto/cart.php?id=" + maSP)
            .then(response => response.text())
            .then(data => {
                alert("Thêm vào giỏ hàng thành công!");
            })
            .catch(error => {
                alert("Có lỗi khi thêm vào giỏ hàng!");
                console.error(error);
            });

        return false; // vẫn ở lại trang
    }
}
</script>

<?php include 'footer.php'?>
