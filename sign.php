<?php
include './config/config.php';
include './config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Đăng nhập
    if (isset($_POST['SignIn'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $sql = "SELECT * FROM Users WHERE (TenTaiKhoan = '$username' OR SDT = '$username') AND TrangThai = 1";
        $users = Database::GetData($sql);

        if ($users && count($users) > 0) {
            $user = $users[0];

            if (password_verify($password, $user['MatKhau'])) {
                $_SESSION['TenTaiKhoan'] = $user['TenTaiKhoan'];
                $_SESSION['TenDayDu'] = !empty($user['TenDayDu']) ? $user['TenDayDu'] : $user['TenTaiKhoan'];
                $_SESSION['Avatar'] = !empty($user['Avatar']) ? $user['Avatar'] : '/assets/img/user.png';
                $_SESSION['MaQuyen'] = $user['MaQuyen'];

                if ($user['MaQuyen'] == 1 || $user['MaQuyen'] == 2) {
                    header('Location: admin/index.php');
                    exit;
                } else {
                    header('Location: index.php');
                    exit;
                }
            } else {
                echo "<script>alert('Tên đăng nhập hoặc mật khẩu không hợp lệ!');window.location='sign.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Tên đăng nhập hoặc mật khẩu không hợp lệ!');window.location='sign.php';</script>";
            exit;
        }
    }

   //Đăng ký 
if (isset($_POST['SignUp'])) {
    $username   = $_POST['username'] ?? '';
    $fullname   = $_POST['fullname'] ?? '';
    $password1  = $_POST['password1'] ?? '';
    $password2  = $_POST['password2'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $email      = $_POST['email'] ?? '';
    $address    = $_POST['address'] ?? '';


    // Kiểm tra email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!');window.location='sign.php';</script>";
        exit;
    }

    if ($password1 === $password2) {
        $checkUser = Database::GetData("SELECT * FROM Users WHERE TenTaiKhoan = '$username' OR SDT = '$phone'");
        if ($checkUser && count($checkUser) > 0) {
            echo "<script>alert('Tên tài khoản hoặc số điện thoại đã tồn tại!');window.location='sign.php';</script>";
            exit;
        } else {
            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users 
                    (TenTaiKhoan, TenDayDu, MatKhau, SDT, Email, DiaChi, Avatar, TrangThai, CreatedAt, MaQuyen) 
                    VALUES 
                    ('$username', '$fullname', '$hashedPassword', '$phone', '$email', '$address', '/assets/img/user.png', 1, NOW(), 3)";
            
            $check = Database::NonQuery($sql);
            if ($check) {
                echo "<script>alert('Đăng ký thành công. Hãy đăng nhập!');window.location='sign.php';</script>";
            } else {
                echo "<script>alert('Đăng ký thất bại!');window.location='sign.php';</script>";
            }
            exit;
        }
    } else {
        echo "<script>alert('Mật khẩu không khớp!');window.location='sign.php';</script>";
        exit;
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/sign.css" />
    <title>Đăng ký và đăng nhập</title>
    <link rel="icon" href="/Salon/assets/img/logo.png" />
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Đăng nhập -->
                <form action="" method="POST" class="sign-in-form">
                    <h2 class="title">Đăng nhập</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="username" type="text" placeholder="Tên Tài Khoản / Số điện thoại" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="password" type="password" placeholder="Mật khẩu" required />
                    </div>
                    <input name="SignIn" type="submit" value="Đăng nhập" class="btn solid" />
                    <div class="form-group text-center">
                        <a href="forgot-password.php">Quên mật khẩu?</a>
                    </div>
                </form>

                <!-- Đăng ký -->
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Đăng ký</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="username" type="text" placeholder="Tên đăng nhập" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-id-card"></i>
                        <input name="fullname" type="text" placeholder="Họ và tên" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="password1" type="password" placeholder="Mật khẩu" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="password2" type="password" placeholder="Nhập lại mật khẩu" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input name="phone" type="text" 
                               placeholder="Số điện thoại" 
                               required 
                               maxlength="10" 
                               pattern="^0\d{9}$" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input name="email" type="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-map-marker-alt"></i>
                        <input name="address" type="text" placeholder="Địa chỉ" required />
                    </div>
                    <input name="SignUp" type="submit" class="btn" value="Đăng ký" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Thành viên mới?</h3>
                    <p>Nếu bạn chưa có tài khoản. Hãy tạo ngay một tài khoản và tham gia cùng chúng tôi nào!</p>
                    <button class="btn transparent" id="sign-up-btn">Đăng ký</button>
                </div>
                <img src="./assets/img/login1.png" class="image" alt="" />
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>Xin chào!</h3>
                    <p>Nếu bạn đã có tài khoản. Hãy đăng nhập vào để bắt đầu mua hàng!</p>
                    <button class="btn transparent" id="sign-in-btn">Đăng nhập</button>
                </div>
                <img src="./assets/img/register1.png" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="./assets/js/sign.js"></script>
</body>
</html>
