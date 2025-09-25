<?php include 'config/config.php'?>
<?php include 'config/Database.php'?>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="icon" href="Salonoto/assets/img/favicon.png" />
    <link rel="stylesheet" href="/Salonoto/assets/css/style.css">
</head>

<?php
    if (!isset($_SESSION['TenTaiKhoan'])) {
        header('Location: /Salonoto/sign.php');
        exit;
    }

    if (isset($_POST['submit'])) {
    $re_pass = $_POST['re-pass'] ?? '';
    $pass_1  = $_POST['pass-1'] ?? '';
    $pass_2  = $_POST['pass-2'] ?? '';

    if ($pass_1 !== $pass_2) {
        $message = '<p style="color: #ED5565;">Mật khẩu mới không khớp</p>';
    } elseif (empty($pass_1)) {
        $message = '<p style="color: #ED5565;">Mật khẩu mới không được để trống</p>';
    } else {
        // lấy thông tin user từ database
        $sql = "SELECT MatKhau FROM Users WHERE TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "' AND TrangThai = 1";
        $users = Database::GetData($sql, ['row'=>0]);

        if ($users && password_verify($re_pass, $users['MatKhau'])) {
            // mã hóa mật khẩu mới
            $hashedPassword = password_hash($pass_1, PASSWORD_DEFAULT);
            $updateSql = "UPDATE Users SET MatKhau = '$hashedPassword' WHERE TenTaiKhoan = '" . $_SESSION['TenTaiKhoan'] . "'";
            if (Database::NonQuery($updateSql)) {
                $message = '<p style="color: #48CFAD;">Đổi mật khẩu thành công. Vui lòng đăng nhập lại</p>';
                session_destroy();
                header('Refresh:2; URL=/Salonoto/sign.php');
            } else {
                $message = '<p style="color: #ED5565;">Đã có lỗi xảy ra, vui lòng thử lại</p>';
            }
        } else {
            $message = '<p style="color: #ED5565;">Mật khẩu cũ không đúng</p>';
        }
    }
}
?>

<body class="profile__bg d-flex-center">
    <img class="profile__avatar" src="<?=$_SESSION['Avatar']?>" alt="Avatar">
    <div class="profile__form">
        <div class="profile__form--header">
            <h3>Đổi mật khẩu</h3>
        </div>
        <form class="profile__form--body" method="POST">
            <div class="profile__group">
                <b>Mật khẩu cũ: </b>
                <input type="password" name="re-pass">
            </div>
            <div class="profile__group">
                <b>Mật khẩu mới: </b>
                <input type="password" name="pass-1">
            </div>
            <div class="profile__group">
                <b>Nhập lại mật khẩu mới: </b>
                <input type="password" name="pass-2">
            </div>
            <div class="profile__group d-flex-center">
                <div>
                    <input class="btn" name="submit" type="submit" value="Đổi mật khẩu">
                    <a class="btn" href="/Salonoto/profile.php">Thông tin cá nhân</a>
                    <a class="btn" href="/Salonoto/index.php">Trang chủ</a>
                </div>
            </div>
        </form>
        <?php
            if (isset($message)) {
                echo '<div class="profile__form--footer">' . $message . '</div>';
            }
        ?>
    </div>
</body>

</html>