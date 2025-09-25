<?php session_start()?>
<?php include 'config/config.php'?>
<?php include 'config/database.php'?>
<?php include 'config/Helper.php'?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salon ô tô</title>
    <link rel="icon" href="/Salonoto/assets/img/logo.png" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,100" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/Salonoto/vendor/Home/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/Salonoto/assets/Admin-LTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/Salonoto/vendor/Home/css/owl.carousel.css">
    <link rel="stylesheet" href="/Salonoto/vendor/Home/css/ustora-style.css">
    <link rel="stylesheet" href="/Salonoto/vendor/Home/css/responsive.css">

    <style>
     .form-search {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-search input,
        .form-search .btn {
            font-size: inherit;
            font-family: inherit;
            padding: 8px;
            border: 1px solid #ccc;
        }

        .form-search input {
            width: 100%;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            outline: none;
        }

        .form-search .btn {
            background-color: #428bca;
            color: white;
            padding: 8px 16px;
            border-radius: 0;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .form-search .btn:hover {
            opacity: 0.7;
        }
        .navbar-nav > li {
            position: relative;
        }

        .navbar-nav > li.dropdown > a {
            width: 250px;
            background-color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            border: 1px solid #ccc;
            z-index: 999;
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding-left: 0;
        }

        .navbar-nav .submenu li {
            list-style: none;
        }

        .navbar-nav .submenu li a {
            display: block;
            padding: 10px 15px;
            width: 100%;
            box-sizing: border-box;
            color: #333;
            text-decoration: none;
            transition: background 0.25s ease, color 0.25s ease;
            white-space: nowrap;
        }

        .navbar-nav .submenu li a:hover {
            background-color: #dcdcdc;
            color: #007bff;
        }

        .navbar-nav li.dropdown:hover .submenu {
            display: block;
        }

        .navbar-nav > li {
            position: relative;
        }

        .navbar-nav > li.dropdown > a {
            width: 250px;
            background-color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .navbar-nav .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            border: 1px solid #ccc;
            z-index: 999;
            width: 100%;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .submenu li {
            list-style: none;
        }

        .navbar-nav .submenu li a {
            display: block;
            padding: 10px 10px;
            width: 100%;
            box-sizing: border-box;
            color: #333;
            text-decoration: none;
            text-align: left;
            transition: background 0.25s ease, color 0.25s ease;
            white-space: nowrap;
        }

        .navbar-nav .submenu li a:hover {
            background-color: #dcdcdc;
            color: #007bff;
        }

        .navbar-nav li.dropdown:hover .submenu {
            display: block;
        }
        .navbar-nav > li > a {
            color: #000;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .navbar-nav .submenu li {
            list-style: none;
        }

        .navbar-nav .submenu li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background 0.25s ease, color 0.25s ease;
        }

        .navbar-nav .submenu li a:hover {
            background-color: #f2f2f2;
            color: #007bff;
        }

        .navbar-nav li.dropdown:hover .submenu {
            display: block;
        }
        ul.navbar-nav li.dropdown:hover ul.submenu {
        display: block;
        }

        ul.navbar-nav li.dropdown ul.submenu li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            background-color: #fff;
            text-decoration: none;
            transition: background 0.25s ease, color 0.25s ease;
        }

        ul.navbar-nav li.dropdown ul.submenu li a:hover {
            background-color: #f2f2f2;
            color: #007bff;
        } 
    </style>
</head>

<body>
    <div class="header-area">
        <div class="container">
            <div class="user-menu">
                <ul>
                    <?php if (isset($_SESSION['MaQuyen']) && ($_SESSION['MaQuyen'] == '1' || $_SESSION['MaQuyen'] == '2')) {?>
                    <li><a href="/Salonoto/admin/dashboard/index.php"><i class="fas fa-user-shield"></i> Trang quản trị</a></li>
                    <?php }if (isset($_SESSION['MaQuyen'])) {?>
                    <li><a href="/Salonoto/profile.php"><i class="fas fa-user"></i> <?=$_SESSION['TenDayDu']?></a></li>
                    <li><a href="/Salonoto/logout.php"><i class="fas fa-sign-in-alt"></i> Đăng xuất</a></li>
                    <?php } else {?>
                    <li><a href="/Salonoto/sign.php"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a></li>
                    <li><a href="/Salonoto/sign.php"><i class="fas fa-user"></i> Đăng ký</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div> 

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="logo">
                        <h1><a href="./"><img src="/Salonoto/assets/img/logo.png" style="height: 150px"></a></h1>
                    </div>
                </div>

                <form class="col-sm-6 form-search" action="shop.php">
                    <input name="keyword" placeholder="Từ khoá">
                    <button class="btn"><i class="glyphicon glyphicon-search"></i></button>
                </form>

                <?php
                $totalMoney = 0;
                $countItem  = 0;

                if (isset($_SESSION['TenTaiKhoan'])) {
                    $username = $_SESSION['TenTaiKhoan'];

                    // tổng tiền = SUM(SL * Giá)
                    $sql = "SELECT SUM(GioHang.SL * IFNULL(SanPham.GiaKhuyenMai, SanPham.Gia)) AS TongTien
                            FROM GioHang
                            INNER JOIN SanPham ON GioHang.MaSP = SanPham.MaSP
                            WHERE GioHang.TenTaiKhoan = '$username'";
                    $totalMoney = (int) Database::GetData($sql, ['cell' => 'TongTien']);

                    // đếm số sản phẩm trong giỏ
                    $sql = "SELECT COUNT(*) AS SoLuong
                            FROM GioHang 
                            WHERE TenTaiKhoan = '$username'";
                    $countItem = (int) Database::GetData($sql, ['cell' => 'SoLuong']);
                }
                ?>
                <div class="col-sm-3">
                    <div class="shopping-item">
                        <a href="<?='/Salonoto/cart.php'?>">Giỏ hàng - <span class="cart-amunt"><?=Helper::Currency($totalMoney)?></span>
                            <i class="fa fa-shopping-cart"></i>
                            <span class="product-count"><?=$countItem?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                                            <li class="dropdown">
                        <a href="#"><i class="fa fa-bars" style="margin-right: 6px;"></i>Danh mục sản phẩm</a>
                        <ul class="submenu">
                            <?php
                                $sql = 'SELECT * FROM loaisp ORDER BY MaLoaiSP DESC';
                                $categories = Database::GetData($sql);
                                foreach ($categories as $cate) {
                                    echo '<li><a href="/Salonoto/category.php?MaLoaiSP=' . $cate['MaLoaiSP'] . '">' . $cate['TenLoaiSP'] . '</a></li>';
                                }
                            ?>
                        </ul>
                    </li>
                        <li><a href="./">Trang chủ</a></li>
                        <li><a href="<?='/Salonoto/about.php'?>">Giới thiệu</a></li>
                        <li><a href="<?='/Salonoto/shop.php'?>">Mua hàng</a></li>
                        <li><a href="<?='/Salonoto/dichvu.php'?>">Dịch vụ</a></li>
                        <li><a href="<?='/Salonoto/booking.php'?>">Đặt dịch vụ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> 
