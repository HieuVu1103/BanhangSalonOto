<?php include 'header.php'; ?>
<?php include_once 'config/Database.php'; ?>

<style>
.service-container {
    font-size: 20px;
    line-height: 1.7;
    margin-top: 40px;
    margin-bottom: 60px;
}
.service-container strong {
    color: #0077cc;
}
.service-container h2, 
.service-container h3, 
.service-container h4 {
    font-weight: bold;
    color: #0077cc; 
    margin-top: 30px;
    margin-bottom: 15px;
}
.service-img {
    width: 100%;
    max-width: 1200px;
    border-radius: 15px;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
    margin-top: 20px;
    margin-bottom: 5px; 
}
figcaption {
    font-size: 16px;
    font-style: italic;
    color: #555;
    margin-bottom: 20px;
}
</style>

<div class="container service-container">

    <h2 style="text-align: center;">DỊCH VỤ TẠI SALON THẾ GIỚI Ô TÔ</h2>

    <div class="service-banner">
        <img src="/Salonoto/assets/img/dv.jpg" alt="Salon Thế Giới Ô Tô" style="margin: 0 auto; display: block;">
        <p>
            <strong>Salon Thế Giới Ô Tô</strong> cung cấp các dịch vụ chăm sóc và bảo dưỡng xe toàn diện, từ rửa xe, đánh bóng, phủ gầm cho đến bảo dưỡng định kỳ, sửa chữa và nâng cấp xe theo nhu cầu cá nhân. 
            Với <strong>đội ngũ kỹ thuật viên giàu kinh nghiệm</strong> và cơ sở vật chất hiện đại, chúng tôi cam kết mang đến cho xe của bạn <strong>hiệu suất tối ưu, an toàn tuyệt đối và vẻ đẹp hoàn hảo.</strong>
        </p>

        <div class="service-intro-images">
            <img src="/Salonoto/assets/img/sc1.jpg" alt="Salon Thế Giới Ô Tô 1" style="margin: 0 auto; display: block;">
            <p>
            Trong những năm gần đây, việc sở hữu ô tô đã không còn là việc quá xa xỉ đối với nhiều hộ gia đình ở Việt Nam. 
            Chính vì vậy, nhu cầu tìm hiểu thông tin về các loại xe, hãng xe cũng như thông số kỹ thuật trở nên cấp bách và cần thiết. Chính vì vậy với kinh nghiệm hơn 10 năm trong ngành kĩ sư Phạm Văn Phong và với đội ngũ nhân viên đây kinh nghiệm, sẽ tư vấn và phục vụ các bạn một cách chuyên nghiệp nhất - Chắc chắn các bạn sẽ hai lòng khi hợp tác với chúng tôi!
        </p>
        </div>
        <div class="service-intro-images">
            <img src="/Salonoto/assets/img/sc2.jpg" alt="Salon Thế Giới Ô Tô 2">
            <p>
            <strong>Đặc biệt, dịch vụ độ xe hoàn toàn miễn phí:</strong>
            </p>
            <p>   
            Khách hàng đến với Salon Thế Giới Ô Tô sẽ được tư vấn và thực hiện các gói độ xe miễn phí công lắp đặt. Chúng tôi hỗ trợ nâng cấp màn hình, đèn, lazang, và các phụ kiện khác mà không tính phí công, giúp xe của bạn vừa đẹp mắt, vừa hiện đại, đồng thời tiết kiệm chi phí tối đa.
        </p>
        </div>
    </div>
    <h2 style="text-align: center;">Sau đây là những dịch vụ nổi bật tại Thế Giới Ô Tô</h2>
<?php

$services = Database::GetData("SELECT * FROM dichvu WHERE TrangThai='HoatDong'");

if (!empty($services)) {
    foreach ($services as $row) {
        echo '<div class="service-item">';
        echo '<h3>' . htmlspecialchars($row['TenDichVu']) . '</h3>';
        echo '<p>' . nl2br(htmlspecialchars($row['MoTa'])) . '</p>';
        echo '<p><strong>Giá: </strong>' . number_format($row['Gia'], 0, ',', '.') . ' VND</p>';
        echo '<hr>';
        echo '</div>';
    }
} else {
    echo "<p>Hiện chưa có dịch vụ nào.</p>";
}
?>

<div class="row" style="margin-top: 40px;">
    
    <p style="font-size: 20px;">
        📍 Địa chỉ: <strong>438 Lê Thánh Tông, Vạn Mĩ, Ngô Quyền, Hải Phòng</strong><br>
        ☎️ Hotline: <strong>0907.428.999</strong> – <strong>0904.361.979</strong><br>
        📧 Email: <strong><em>info@vimaru.edu.vn</em></strong>
    </p>

    <div class="col-md-12">
        <h3>📍 Bản đồ chỉ đường</h3>
        <div style="width: 100%; height: 500px; border: 1px solid #ccc; border-radius: 8px; overflow: hidden;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d233.0116838467421!2d106.71161697777104!3d20.864513988904676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7bec16bba21b%3A0xd258acc8ce75f592!2zU2Fsb24gVGjhur8gZ2nhu5tpIMO0IHTDtCB04bqhaSBI4bqjaSBQaMOybmc!5e0!3m2!1svi!2s!4v1754127418512!5m2!1svi!2s"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

</div>

<?php include 'footer.php'; ?>
