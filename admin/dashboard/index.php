<?php include '../header.php'?>
<?php include '../sidebar.php'?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bảng điều khiển</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/Salonoto/admin/dashboard/"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Bảng điều khiển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <?php
                // Lấy tổng số đơn hàng
                $totalOrders = Database::GetData("SELECT COUNT(*) AS total FROM dondathang", ['row'=>0])['total'];

                // Lấy tổng số sản phẩm
                $totalProducts = Database::GetData("SELECT COUNT(*) AS total FROM sanpham", ['row'=>0])['total'];

                // Lấy tổng số loại sản phẩm
                $totalCategories = Database::GetData("SELECT COUNT(*) AS total FROM loaisp", ['row'=>0])['total'];

                // Lấy tổng số người dùng
                $totalUsers = Database::GetData("SELECT COUNT(*) AS total FROM users", ['row'=>0])['total'];

                // Lấy tổng số lịch đặt dịch vụ
                $totalBookings = Database::GetData("SELECT COUNT(*) AS total FROM datdichvu", ['row'=>0])['total'];

                // Lấy tổng số dịch vụ
                $totalServices = Database::GetData("SELECT COUNT(*) AS total FROM dichvu", ['row'=>0])['total'];
                ?>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $totalOrders ?></h3>
                            <p>Tổng số đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="/Salonoto/admin/donhang/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $totalProducts ?></h3>
                            <p>Tổng số sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="/Salonoto/admin/sanpham/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-4 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3><?= $totalCategories ?></h3>
                            <p>Tổng số loại sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <a href="/Salonoto/admin/loaisp/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $totalUsers ?></h3>
                            <p>Tổng số người dùng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="/Salonoto/admin/users/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-4 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $totalBookings ?></h3>
                            <p>Tổng số lịch đặt dịch vụ</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <a href="/Salonoto/admin/dondichvu/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $totalServices ?></h3>
                            <p>Tổng số dịch vụ</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <a href="/Salonoto/admin/dichvu/list.php" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<?php include '../footer.php'?>
