<?php
class Database
{
    private const HOST = 'localhost';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const DBNAME = 'doansalon';
    
    // Biến static để theo dõi lần chạy cron cuối
    private static $lastCronCheck = null;

    /**
     * Kết nối CSDL
     */
    private static function Connect()
    {
        $connect = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($connect->connect_error) {
            die('Connection failed: ' . $connect->connect_error);
        }
        
        // Tự động chạy cron mỗi lần kết nối (nhưng có giới hạn)
        self::runAutoCron($connect);
        
        return $connect;
    }

    /**
     * Tự động chạy cron để hủy đơn hàng quá hạn
     * Chỉ chạy mỗi 2 phút để tránh spam
     */
    private static function runAutoCron($connect)
    {
        $currentTime = time();
        
        // Chỉ chạy cron nếu đã qua 2 phút từ lần cuối (120 giây)
        if (self::$lastCronCheck === null || ($currentTime - self::$lastCronCheck) >= 120) {
            self::$lastCronCheck = $currentTime;
            
            try {
                // Tìm các đơn hàng chưa thanh toán và quá 15 phút
                $expiredQuery = "SELECT d.MaDonDatHang, d.TenTaiKhoan 
                               FROM dondathang d 
                               LEFT JOIN thanhtoan t ON d.MaDonDatHang = t.MaDonDatHang 
                               WHERE d.TrangThai = 'ChoXuLy' 
                               AND t.MaDonDatHang IS NULL 
                               AND d.CreatedAt < DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
                
                $expiredResult = $connect->query($expiredQuery);
                
                if ($expiredResult && $expiredResult->num_rows > 0) {
                    $cancelledCount = 0;
                    
                    while ($order = $expiredResult->fetch_assoc()) {
                        $orderId = $order['MaDonDatHang'];
                        
                        // Cập nhật trạng thái đơn hàng thành 'Huy'
                        $updateQuery = "UPDATE dondathang 
                                       SET TrangThai = 'Huy', 
                                           GhiChu = CONCAT(IFNULL(GhiChu, ''), ' [Tự động hủy lúc " . date('Y-m-d H:i:s') . " do quá 15 phút chưa thanh toán]')
                                       WHERE MaDonDatHang = $orderId";
                        
                        if ($connect->query($updateQuery)) {
                            $cancelledCount++;
                            
                            // Khôi phục số lượng sản phẩm trong kho (nếu có quản lý tồn kho)
                            self::restoreInventory($connect, $orderId);
                        }
                    }
                    
                    // Log để debug (có thể comment lại trong production)
                    if ($cancelledCount > 0) {
                        error_log("[Auto Cron] Đã hủy $cancelledCount đơn hàng quá hạn thanh toán tại " . date('Y-m-d H:i:s'));
                    }
                }
            } catch (Exception $e) {
                // Log lỗi nhưng không dừng hệ thống
                error_log("[Auto Cron Error] " . $e->getMessage());
            }
        }
    }

    /**
     * Khôi phục số lượng sản phẩm khi hủy đơn (nếu có quản lý tồn kho)
     */
    private static function restoreInventory($connect, $orderId)
    {
        // Lấy chi tiết đơn hàng
        $detailQuery = "SELECT MaSP, SL FROM chitietdondathang WHERE MaDonDatHang = $orderId";
        $detailResult = $connect->query($detailQuery);
        
        if ($detailResult && $detailResult->num_rows > 0) {
            while ($detail = $detailResult->fetch_assoc()) {
                // Nếu bạn có cột SoLuongTon trong bảng SanPham, uncomment dòng dưới
                // $restoreQuery = "UPDATE sanpham SET SoLuongTon = SoLuongTon + {$detail['SL']} WHERE MaSP = {$detail['MaSP']}";
                // $connect->query($restoreQuery);
            }
        }
    }

    // SELECT thông thường
    public static function GetData($query, $format = [])
    {
        if (is_array($format)) {
            $connect = self::Connect();
            $resQuery = $connect->query($query);

            if (!$resQuery) {
                die('Invalid query: ' . $connect->error);
            }

            $arr = [];
            if ($resQuery->num_rows > 0) {
                while ($row = $resQuery->fetch_assoc()) {
                    $arr[] = $row;
                }

                // Trả về giá trị theo key hoặc index
                if (isset($format['cell'])) {
                    $formatRow = $format['row'] ?? 0;
                    $formatKey = is_numeric($format['cell']) ? array_keys($arr[$formatRow])[$format['cell']] : $format['cell'];
                    return $arr[$formatRow][$formatKey] ?? null;
                }

                // Trả về dòng dữ liệu tại index
                if (isset($format['row'])) {
                    return $arr[$format['row']];
                }
            }

            $connect->close();
            return $arr;
        }
        return [];
    }

    // SELECT có phân trang
    public static function GetDataWithPagination($query, $offset = 10, $page = 1)
    {
        $countAll = self::GetData('SELECT count(*) FROM categories', ['cell' => 0]);
        $start = ($page - 1) * $offset;
        $data = self::GetData($query . " LIMIT $start, $offset");
        $end = $start + count($data);

        return [
            'data'        => $data,
            'start'       => $start + 1,
            'end'         => $end,
            'countAll'    => $countAll,
            'page_number' => ceil($countAll / $offset),
        ];
    }
    // INSERT, UPDATE, DELETE
    public static function NonQuery($query)
    {
        $connect = self::Connect();
        $result = $connect->query($query);
        $connect->close();
        return $result === true;
    }


    // INSERT và trả về ID vừa tạo
    public static function NonQueryId($query)
    {
        $connect = self::Connect();
        $result = $connect->query($query);
        if ($result) {
            $lastId = $connect->insert_id;
            $connect->close();
            return $lastId;
        } else {
            die('Error: ' . $connect->error);
        }
    }


    // Transaction
    public static function BeginTransaction()
    {
        $connect = self::Connect();
        $connect->autocommit(false);
        return $connect;
    }

    public static function Commit($connect)
    {
        if ($connect) {
            $connect->commit();
            $connect->autocommit(true);
            $connect->close();
        }
    }

    public static function Rollback($connect)
    {
        if ($connect) {
            $connect->rollback();
            $connect->autocommit(true);
            $connect->close();
        }
    }


    // NonQuery trong transaction

    public static function NonQueryTrans($connect, $query)
    {
        if (!$connect->query($query)) {
            throw new Exception($connect->error);
        }
        return true;
    }


    // NonQueryId trong transaction

    public static function NonQueryIdTrans($connect, $query)
    {
        if ($connect->query($query)) {
            return $connect->insert_id;
        } else {
            throw new Exception($connect->error);
        }
    }


    // Method để chạy cron thủ công nếu cần

    public static function runCronManually()
    {
        $connect = self::Connect();
        self::runAutoCron($connect);
        $connect->close();
        return "Cron job đã chạy thủ công!";
    }


    // Method để kiểm tra trạng thái cron
    public static function getCronStatus()
    {
        return [
            'last_cron_check' => self::$lastCronCheck ? date('Y-m-d H:i:s', self::$lastCronCheck) : 'Chưa chạy',
            'next_cron_run' => self::$lastCronCheck ? date('Y-m-d H:i:s', self::$lastCronCheck + 120) : 'Sẽ chạy khi có request tiếp theo'
        ];
    }
}
?>