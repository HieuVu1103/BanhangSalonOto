-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 26, 2025 lúc 04:21 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doansalon`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdondathang`
--

CREATE TABLE `chitietdondathang` (
  `MaChiTietDonDatHang` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `MaDonDatHang` int(11) NOT NULL,
  `SL` int(11) NOT NULL,
  `DonGia` decimal(15,2) NOT NULL,
  `NgayBatDauBH` datetime DEFAULT NULL,
  `NgayKetThucBH` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdondathang`
--

INSERT INTO `chitietdondathang` (`MaChiTietDonDatHang`, `MaSP`, `MaDonDatHang`, `SL`, `DonGia`, `NgayBatDauBH`, `NgayKetThucBH`) VALUES
(11, 1, 8, 1, 0.00, '2025-09-12 01:45:58', '2026-09-12 01:45:58'),
(12, 1, 9, 2, 0.00, '2025-09-12 01:48:47', '2026-09-12 01:48:47'),
(13, 1, 10, 1, 0.00, '2025-09-12 01:49:13', '2026-09-12 01:49:13'),
(14, 1, 11, 1, 0.00, '2025-09-12 10:12:50', '2026-09-12 10:12:50'),
(15, 2, 11, 1, 0.00, '2025-09-12 10:12:50', '2026-09-12 10:12:50'),
(16, 2, 12, 1, 3400000.00, '2025-09-12 18:44:35', '2026-09-12 18:44:35'),
(17, 1, 13, 1, 18000000.00, '2025-09-12 18:45:20', '2026-09-12 18:45:20'),
(18, 1, 14, 1, 17000000.00, '2025-09-12 19:28:37', '2026-09-12 19:28:37'),
(19, 1, 15, 2, 17000000.00, '2025-09-12 20:09:14', '2026-09-12 20:09:14'),
(20, 1, 16, 1, 17000000.00, '2025-09-12 22:03:22', '2026-09-12 22:03:22'),
(21, 2, 17, 1, 3400000.00, '2025-09-12 22:34:29', '2026-09-12 22:34:29'),
(22, 1, 18, 1, 17000000.00, '2025-09-12 22:42:27', '2026-09-12 22:42:27'),
(23, 1, 19, 1, 17000000.00, '2025-09-12 22:49:20', '2026-09-12 22:49:20'),
(24, 1, 20, 1, 17000000.00, '2025-09-12 22:54:50', '2026-09-12 22:54:50'),
(25, 1, 21, 1, 17000000.00, '2025-09-12 23:04:12', '2026-09-12 23:04:12'),
(26, 1, 22, 1, 17000000.00, '2025-09-13 16:27:33', '2026-09-13 16:27:33'),
(27, 1, 23, 1, 17000000.00, '2025-09-17 20:11:56', '2026-09-17 20:11:56'),
(28, 1, 24, 1, 17000000.00, '2025-09-17 20:18:18', '2026-09-17 20:18:18'),
(29, 1, 25, 1, 17000000.00, '2025-09-17 20:37:05', '2026-09-17 20:37:05'),
(30, 2, 26, 1, 3400000.00, '2025-09-17 20:51:01', '2026-09-17 20:51:01'),
(31, 1, 26, 1, 17000000.00, '2025-09-17 20:51:01', '2026-09-17 20:51:01'),
(32, 1, 27, 1, 17000000.00, '2025-09-17 20:51:30', '2026-09-17 20:51:30'),
(33, 2, 28, 1, 3400000.00, '2025-09-17 20:53:19', '2026-09-17 20:53:19'),
(34, 2, 29, 1, 3400000.00, '2025-09-17 20:53:20', '2026-09-17 20:53:20'),
(35, 2, 30, 1, 3400000.00, '2025-09-17 20:53:22', '2026-09-17 20:53:22'),
(36, 2, 31, 1, 3400000.00, '2025-09-17 20:53:22', '2026-09-17 20:53:22'),
(37, 2, 32, 1, 3400000.00, '2025-09-17 20:53:23', '2026-09-17 20:53:23'),
(38, 2, 33, 1, 3400000.00, '2025-09-17 20:55:42', '2026-09-17 20:55:42'),
(39, 2, 34, 1, 3400000.00, '2025-09-17 20:55:43', '2026-09-17 20:55:43'),
(51, 9, 46, 1, 900000.00, '2025-09-18 19:54:01', '2026-09-18 19:54:01'),
(52, 1, 47, 1, 17000000.00, '2025-09-20 09:42:40', '2026-09-20 09:42:40'),
(53, 8, 48, 1, 8500000.00, '2025-09-23 15:42:20', '2027-09-23 15:42:20'),
(54, 9, 48, 2, 900000.00, '2025-09-23 15:42:20', '2026-09-23 15:42:20'),
(55, 3, 49, 2, 349000.00, '2025-09-23 21:04:06', '2025-09-23 21:04:06'),
(56, 4, 50, 1, 4990000.00, '2025-09-25 04:55:46', '2027-09-25 04:55:46'),
(57, 6, 50, 1, 12000000.00, '2025-09-25 04:55:46', '2028-09-25 04:55:46'),
(58, 3, 51, 1, 349000.00, '2025-09-25 09:09:05', '2026-09-25 09:09:05'),
(59, 8, 51, 1, 8500000.00, '2025-09-25 09:09:05', '2027-09-25 09:09:05'),
(60, 4, 52, 1, 4990000.00, '2025-09-25 10:34:40', '2027-09-25 10:34:40'),
(61, 6, 52, 1, 12000000.00, '2025-09-25 10:34:40', '2028-09-25 10:34:40'),
(62, 4, 53, 1, 4990000.00, '2025-09-25 10:38:13', '2027-09-25 10:38:13'),
(63, 4, 54, 1, 4990000.00, '2025-09-25 11:06:50', '2027-09-25 11:06:50'),
(64, 6, 54, 1, 12000000.00, '2025-09-25 11:06:50', '2028-09-25 11:06:50'),
(65, 1, 55, 1, 17000000.00, '2025-09-25 16:56:14', '2026-09-25 16:56:14'),
(66, 6, 55, 1, 12000000.00, '2025-09-25 16:56:14', '2028-09-25 16:56:14'),
(67, 4, 56, 1, 4990000.00, '2025-09-25 21:09:19', '2027-09-25 21:09:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaChiTietHoaDon` int(11) NOT NULL,
  `MaHoaDon` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(255) NOT NULL,
  `SL` int(11) NOT NULL,
  `Gia` decimal(15,2) NOT NULL,
  `NgayBatDauBH` datetime DEFAULT NULL,
  `NgayKetThucBH` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`MaChiTietHoaDon`, `MaHoaDon`, `MaSP`, `TenSP`, `SL`, `Gia`, `NgayBatDauBH`, `NgayKetThucBH`) VALUES
(1, 2, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 19500000.00, '2025-09-12 01:49:13', '2026-09-12 01:49:13'),
(2, 3, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 18000000.00, '2025-09-12 18:45:20', '2026-09-12 18:45:20'),
(3, 4, 1, 'Màn Hình Gotech 2K GT 13i 360', 2, 17000000.00, '2025-09-12 20:09:14', '2026-09-12 20:09:14'),
(4, 5, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-12 22:54:50', '2026-09-12 22:54:50'),
(5, 6, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-12 23:04:12', '2026-09-12 23:04:12'),
(6, 7, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-17 20:51:30', '2026-09-17 20:51:30'),
(7, 8, 2, 'Camera Hành Trình VietMap C61 Pro', 1, 3400000.00, '2025-09-17 20:51:01', '2026-09-17 20:51:01'),
(8, 8, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-17 20:51:01', '2026-09-17 20:51:01'),
(9, 9, 9, 'Máy lọc không khí ô tô Hàn Quốc Allo A600 (APS-600)', 1, 900000.00, '2025-09-18 19:54:01', '2026-09-18 19:54:01'),
(10, 10, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-20 09:42:40', '2026-09-20 09:42:40'),
(11, 11, 8, 'Loa Sub ô tô Audison APBX 10DS', 1, 8500000.00, '2025-09-23 15:42:20', '2027-09-23 15:42:20'),
(12, 11, 9, 'Máy lọc không khí ô tô Hàn Quốc Allo A600 (APS-600)', 2, 900000.00, '2025-09-23 15:42:20', '2026-09-23 15:42:20'),
(13, 12, 4, 'Màn Hình Zestech Z18', 1, 4990000.00, '2025-09-25 04:55:46', '2027-09-25 04:55:46'),
(14, 12, 6, 'Đèn Bi Pha Aozoom X - Led Pro Domax', 1, 12000000.00, '2025-09-25 04:55:46', '2028-09-25 04:55:46'),
(15, 13, 4, 'Màn Hình Zestech Z18', 1, 4990000.00, '2025-09-25 10:38:13', '2027-09-25 10:38:13'),
(16, 14, 1, 'Màn Hình Gotech 2K GT 13i 360', 1, 17000000.00, '2025-09-25 16:56:14', '2026-09-25 16:56:14'),
(17, 14, 6, 'Đèn Bi Pha Aozoom X - Led Pro Domax', 1, 12000000.00, '2025-09-25 16:56:14', '2028-09-25 16:56:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadondichvu`
--

CREATE TABLE `chitiethoadondichvu` (
  `MaChiTietHoaDonDichVu` int(11) NOT NULL,
  `MaHoaDonDichVu` int(11) NOT NULL,
  `TenDichVu` varchar(255) DEFAULT NULL,
  `Gia` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadondichvu`
--

INSERT INTO `chitiethoadondichvu` (`MaChiTietHoaDonDichVu`, `MaHoaDonDichVu`, `TenDichVu`, `Gia`) VALUES
(3, 2, 'Rửa máy', 800000.00),
(4, 2, 'Đánh bóng xe', 5000000.00),
(5, 4, 'Rửa máy', 800000.00),
(6, 4, 'Đánh bóng xe', 5000000.00),
(7, 6, 'Rửa máy', 800000.00),
(8, 6, 'Đánh bóng xe', 5000000.00),
(9, 7, 'Rửa xe ', 120000.00),
(10, 7, 'Đánh bóng xe', 5000000.00),
(11, 8, 'Rửa xe ', 120000.00),
(12, 9, 'Rửa xe ', 120000.00),
(13, 10, 'Rửa xe ', 120000.00),
(14, 10, 'Rửa máy', 800000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieukiem`
--

CREATE TABLE `chitietphieukiem` (
  `MaChiTietKiem` int(11) NOT NULL,
  `MaKiem` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SLTot` int(11) DEFAULT 0,
  `SLHong` int(11) DEFAULT 0,
  `SLCanBaoHanh` int(11) DEFAULT 0,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieukiem`
--

INSERT INTO `chitietphieukiem` (`MaChiTietKiem`, `MaKiem`, `MaSP`, `SLTot`, `SLHong`, `SLCanBaoHanh`, `GhiChu`) VALUES
(1, 1, 2, 1, 0, 0, ''),
(2, 1, 7, 0, 0, 0, ''),
(3, 1, 8, 0, 0, 0, ''),
(4, 1, 1, 2, 0, 0, ''),
(5, 1, 5, 0, 0, 0, ''),
(6, 1, 4, 0, 0, 0, ''),
(7, 1, 9, 0, 0, 0, ''),
(8, 1, 3, 0, 0, 0, ''),
(9, 1, 6, 0, 0, 0, ''),
(10, 2, 2, 21, 1, 0, 'Bị hỏng'),
(11, 2, 7, 18, 0, 0, ''),
(12, 2, 8, 13, 0, 0, ''),
(13, 2, 1, 14, 0, 0, ''),
(14, 2, 5, 13, 0, 0, ''),
(15, 2, 4, 9, 0, 0, ''),
(16, 2, 9, 3, 0, 0, ''),
(17, 2, 3, 14, 0, 0, ''),
(18, 2, 6, 6, 0, 0, ''),
(19, 3, 2, 25, 1, 0, 'bị hỏng'),
(20, 3, 7, 18, 0, 0, ''),
(21, 3, 8, 11, 0, 0, ''),
(22, 3, 1, 11, 0, 0, ''),
(23, 3, 5, 13, 0, 0, ''),
(24, 3, 4, 5, 0, 0, ''),
(25, 3, 9, 0, 0, 0, ''),
(26, 3, 3, 14, 0, 0, ''),
(27, 3, 6, 2, 0, 0, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieunhap`
--

CREATE TABLE `chitietphieunhap` (
  `MaChiTietNhap` int(11) NOT NULL,
  `MaNhap` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SL` int(11) NOT NULL,
  `GiaNhap` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieunhap`
--

INSERT INTO `chitietphieunhap` (`MaChiTietNhap`, `MaNhap`, `MaSP`, `SL`, `GiaNhap`) VALUES
(2, 2, 1, 5, 16000000.00),
(3, 4, 2, 1, 2380000.00),
(4, 5, 2, 12, 2200000.00),
(5, 6, 8, 13, 5800000.00),
(6, 6, 1, 12, 11900000.00),
(7, 6, 2, 9, 2380000.00),
(8, 6, 6, 6, 8400000.00),
(9, 6, 5, 13, 4900000.00),
(10, 7, 7, 18, 40600000.00),
(11, 7, 3, 14, 244300.00),
(12, 7, 4, 9, 3493000.00),
(13, 8, 9, 5, 665000.00),
(14, 9, 2, 4, 2380000.00),
(15, 10, 11, 6, 294000.00),
(16, 10, 13, 7, 245000.00),
(17, 10, 12, 9, 5313000.00),
(18, 10, 10, 8, 434000.00),
(19, 11, 9, 9, 630000.00),
(20, 11, 8, 4, 5950000.00),
(21, 11, 6, 4, 8400000.00),
(22, 11, 8, 2, 5950000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuxuat`
--

CREATE TABLE `chitietphieuxuat` (
  `MaChiTietXuat` int(11) NOT NULL,
  `MaXuat` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SL` int(11) NOT NULL,
  `GiaXuat` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuxuat`
--

INSERT INTO `chitietphieuxuat` (`MaChiTietXuat`, `MaXuat`, `MaSP`, `SL`, `GiaXuat`) VALUES
(1, 1, 1, 1, 19500000.00),
(2, 2, 2, 1, 3400000.00),
(3, 3, 1, 1, 19500000.00),
(4, 4, 1, 1, 19500000.00),
(5, 5, 1, 1, 17000000.00),
(6, 6, 1, 1, 17000000.00),
(10, 10, 2, 1, 3400000.00),
(11, 11, 2, 1, 3400000.00),
(12, 11, 1, 1, 17000000.00),
(13, 12, 2, 1, 3400000.00),
(14, 12, 1, 1, 17000000.00),
(15, 13, 1, 1, 17000000.00),
(17, 15, 1, 1, 17000000.00),
(18, 16, 8, 1, 8500000.00),
(19, 16, 9, 2, 900000.00),
(20, 17, 4, 1, 4990000.00),
(21, 17, 6, 1, 12000000.00),
(22, 18, 4, 1, 4990000.00),
(23, 19, 1, 1, 17000000.00),
(24, 19, 6, 1, 12000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `datdichvu`
--

CREATE TABLE `datdichvu` (
  `MaDatDichVu` int(11) NOT NULL,
  `TenTaiKhoan` varchar(30) NOT NULL,
  `ModelXe` varchar(50) DEFAULT NULL,
  `BienSoXe` varchar(20) NOT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `NgayHen` datetime NOT NULL,
  `TrangThai` enum('ChoXuLy','XacNhan','DaHoanThanh','Huy','TuChoi') NOT NULL DEFAULT 'ChoXuLy',
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `datdichvu`
--

INSERT INTO `datdichvu` (`MaDatDichVu`, `TenTaiKhoan`, `ModelXe`, `BienSoXe`, `NgayDat`, `NgayHen`, `TrangThai`, `GhiChu`) VALUES
(2, 'a', 'LX 570 2019', '15R1-00037', '2025-09-12 05:43:59', '2025-09-19 09:42:00', 'Huy', ''),
(3, 'Admin', 'LX 570 2019', '15R1-00037', '2025-09-13 01:15:44', '2025-09-18 01:15:00', 'DaHoanThanh', ''),
(4, 'a', 'LX 570 2019', '15R1-00037', '2025-09-13 01:58:15', '2025-09-19 01:58:00', 'Huy', ''),
(5, 'a', 'LX 570 2019', '15R1-00037', '2025-09-20 14:44:12', '2025-09-23 07:10:00', 'DaHoanThanh', ''),
(6, 'a', 'LX 570 2019', '15R1-00037', '2025-09-23 20:44:01', '2025-09-25 00:43:00', 'DaHoanThanh', ''),
(7, 'hieu', 'LX 570 2019', '15R1-00037', '2025-09-25 09:52:49', '2025-09-30 09:52:00', 'DaHoanThanh', ''),
(8, 'hieu', 'LX 570 2019', '15R1-00037', '2025-09-25 15:37:15', '2025-09-27 15:36:00', 'DaHoanThanh', ''),
(9, 'hieu', 'LX 570 2019', '15R1-00037', '2025-09-25 21:59:27', '2025-09-27 10:00:00', 'XacNhan', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `datdichvu_chitiet`
--

CREATE TABLE `datdichvu_chitiet` (
  `MaDatDichVu` int(11) NOT NULL,
  `MaDichVu` int(11) DEFAULT NULL,
  `Gia` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `datdichvu_chitiet`
--

INSERT INTO `datdichvu_chitiet` (`MaDatDichVu`, `MaDichVu`, `Gia`) VALUES
(2, 2, 800000.00),
(2, 11, 0.00),
(2, 2, 800000.00),
(2, 11, 0.00),
(3, 2, 800000.00),
(3, 7, 5000000.00),
(4, 2, 800000.00),
(5, 1, 120000.00),
(6, 1, 120000.00),
(6, 7, 5000000.00),
(7, 1, 120000.00),
(8, 1, 120000.00),
(8, 2, 800000.00),
(9, 1, 120000.00),
(9, 3, 350000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dichvu`
--

CREATE TABLE `dichvu` (
  `MaDichVu` int(11) NOT NULL,
  `TenDichVu` varchar(255) NOT NULL,
  `TrangThai` enum('HoatDong','KhongHoatDong') NOT NULL,
  `MoTa` text DEFAULT NULL,
  `Gia` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dichvu`
--

INSERT INTO `dichvu` (`MaDichVu`, `TenDichVu`, `TrangThai`, `MoTa`, `Gia`) VALUES
(1, 'Rửa xe ', 'HoatDong', '\"Giúp chiếc xe của bạn luôn sạch sẽ, sáng bóng từ trong ra ngoài.\"\r\n\r\nBạn muốn chiếc xe của mình luôn trong tình trạng sạch sẽ và mới mẻ? Dịch vụ rửa xe của chúng tôi sử dụng công nghệ tiên tiến cùng các loại hóa chất chuyên dụng, không gây hại cho lớp sơn xe.', 120000.00),
(2, 'Rửa máy', 'HoatDong', '\"Giúp động cơ sạch sẽ, bền bỉ và dễ dàng phát hiện các sự cố.\"\r\n\r\nKhoang máy là \"trái tim\" của chiếc xe nhưng thường bị bỏ quên. Dịch vụ rửa khoang máy chuyên nghiệp của chúng tôi sẽ loại bỏ bụi bẩn, dầu mỡ và các mảng bám cứng đầu bằng hóa chất chuyên dụng, không làm ảnh hưởng đến các chi tiết điện và cao su. Việc vệ sinh khoang máy định kỳ không chỉ giúp xe luôn sạch sẽ mà còn giúp động cơ tản nhiệt tốt hơn, kéo dài tuổi thọ và dễ dàng nhận biết các dấu hiệu rò rỉ hoặc hư hỏng.', 800000.00),
(3, 'Rửa gầm', 'HoatDong', '\"Loại bỏ bùn đất, dầu mỡ, bảo vệ khung gầm và hệ thống treo của xe.\"\r\n\r\nGầm xe là nơi chịu nhiều tác động nhất từ bùn đất, nước mưa, muối và các hóa chất trên đường, dễ dẫn đến tình trạng rỉ sét và hư hỏng. Dịch vụ rửa gầm của chúng tôi sử dụng cầu nâng chuyên dụng và thiết bị phun áp lực cao để làm sạch toàn bộ gầm xe một cách triệt để. Việc vệ sinh gầm xe định kỳ không chỉ giúp kéo dài tuổi thọ của hệ thống khung gầm và treo, mà còn giúp bạn dễ dàng phát hiện sớm các sự cố rò rỉ hoặc hư hỏng.', 350000.00),
(4, 'Sơn gầm chống ồn', 'HoatDong', '\"Bảo vệ toàn diện, giảm tiếng ồn, mang lại sự êm ái cho mỗi chuyến đi.\"\r\n\r\nSơn phủ gầm là giải pháp hiệu quả để bảo vệ \"xế yêu\" của bạn khỏi những tác động khắc nghiệt từ môi trường như sỏi đá văng, nước mưa, bùn đất và hóa chất ăn mòn. Lớp sơn chuyên dụng có thành phần từ cao su non hoặc nhựa tổng hợp sẽ tạo một lớp màng bảo vệ chắc chắn, ngăn chặn rỉ sét và giảm thiểu rung động từ gầm xe. Nhờ vậy, dịch vụ này không chỉ giúp kéo dài tuổi thọ của xe mà còn hỗ trợ giảm tiếng ồn vọng từ lốp xe và mặt đường, mang lại trải nghiệm lái êm ái, yên tĩnh hơn.', 3000000.00),
(5, 'Dọn nội thất trong/ngoài', 'HoatDong', '\"Tân trang lại vẻ ngoài, làm sạch sâu bên trong, giúp xe của bạn như mới.\"\n\nDịch vụ chăm sóc xe toàn diện của chúng tôi sẽ mang đến một diện mạo hoàn toàn mới cho chiếc xe của bạn. Chúng tôi thực hiện vệ sinh và chăm sóc tỉ mỉ từ nội thất đến ngoại thất, bao gồm:\n\nNội thất: Hút bụi, làm sạch sâu ghế da/nỉ, thảm sàn, tapi cửa, trần xe, táp-lô và các chi tiết nhựa. Chúng tôi sử dụng dung dịch chuyên dụng để loại bỏ các vết bẩn cứng đầu, khử mùi và diệt khuẩn, mang lại không gian bên trong xe sạch sẽ và thơm mát.\n\nNgoại thất: Rửa xe chi tiết, làm sạch các vết ố, bụi sơn trên thân xe. Chúng tôi cũng vệ sinh và dưỡng lốp, mâm xe, kính lái, giúp chiếc xe của bạn luôn sáng bóng và nổi bật.\n\nVới đội ngũ kỹ thuật viên chuyên nghiệp và trang thiết bị hiện đại, chúng tôi cam kết mang lại sự hài lòng cao nhất cho khách hàng.', 2500000.00),
(6, 'Thay dầu', 'HoatDong', '\"Thay dầu đúng lúc, bảo vệ động cơ, giúp xe vận hành êm ái và bền bỉ.\"\r\n\r\nDầu động cơ và dầu hộp số là yếu tố sống còn để chiếc xe của bạn luôn hoạt động trơn tru. Dịch vụ thay dầu của chúng tôi đảm bảo sử dụng dầu chính hãng, phù hợp với từng loại xe và dòng động cơ. Việc thay dầu định kỳ không chỉ giúp động cơ được bôi trơn tối ưu, giảm ma sát và tản nhiệt hiệu quả, mà còn loại bỏ các cặn bẩn, giúp xe bạn tiết kiệm nhiên liệu và kéo dài tuổi thọ động cơ.\r\n\r\nChúng tôi cung cấp cả dịch vụ thay dầu động cơ và thay dầu hộp số (tự động/số sàn) với quy trình chuyên nghiệp, nhanh chóng và chính xác.', 1500000.00),
(7, 'Đánh bóng xe', 'HoatDong', '\"Tái tạo vẻ đẹp, bảo vệ lớp sơn, giữ cho xe luôn bóng bẩy như ngày đầu.\"\r\n\r\nTheo thời gian, lớp sơn xe bị xuống cấp do tác động của tia UV, bụi bẩn, hóa chất và các vết trầy xước nhỏ. Dịch vụ đánh bóng xe chuyên sâu của chúng tôi sẽ loại bỏ các khuyết điểm này, giúp bề mặt sơn trở nên láng mịn và sáng bóng.\r\n\r\nSau khi đánh bóng, chúng tôi sẽ tiến hành phủ Ceramic hoặc phủ Nano, tạo ra một lớp bảo vệ cứng, trong suốt lên bề mặt sơn. Lớp phủ này có tác dụng:\r\n\r\nBảo vệ sơn: Ngăn chặn tia UV, chống lại tác động ăn mòn của axit từ nước mưa và các hóa chất.\r\n\r\nChống trầy xước nhẹ: Giảm thiểu các vết xoáy, vết trầy do rửa xe sai cách hoặc va chạm nhẹ.\r\n\r\nGiữ độ bóng: Giúp màu sơn sâu và lấp lánh hơn, đồng thời chống bám nước và bụi bẩn, giúp việc vệ sinh xe trở nên dễ dàng hơn.', 5000000.00),
(8, 'Sơn phủ nano', 'HoatDong', '\"Tạo hiệu ứng lá sen, bảo vệ lớp sơn, giúp xe luôn sáng bóng và dễ dàng vệ sinh.\"\n\nSơn phủ Nano là một trong những giải pháp bảo vệ xe phổ biến, được ưa chuộng bởi hiệu quả nhanh chóng và chi phí hợp lý. Đây là một lớp dung dịch polymer lỏng được phủ lên bề mặt sơn, kính và các chi tiết nhựa của xe. Khi khô lại, lớp phủ này sẽ tạo thành một lớp màng mỏng, cứng và trong suốt, mang lại nhiều lợi ích:\n\nChống bám nước và bụi bẩn: Lớp phủ Nano tạo nên hiệu ứng \"lá sen\" cực mạnh, khiến nước và bụi bẩn không thể bám chặt vào bề mặt, giúp xe luôn sạch sẽ và việc rửa xe trở nên nhanh chóng, dễ dàng hơn.\n\nTăng cường độ bóng: Lớp Nano làm tăng độ sâu và độ bóng cho màu sơn xe, giúp chiếc xe của bạn luôn nổi bật.\n\nBảo vệ sơn: Ngăn chặn tia UV, các chất ăn mòn từ môi trường và các vết bẩn từ nhựa đường, phân chim, giúp kéo dài tuổi thọ của lớp sơn nguyên bản.', 1500000.00),
(9, 'Dán phim cách nhiệt', 'HoatDong', '\"Chống nóng, chống tia UV, bảo vệ sức khỏe và nội thất xe.\"\r\n\r\nDán phim cách nhiệt là giải pháp hiệu quả giúp bảo vệ bạn và những người thân yêu khỏi tác hại của ánh nắng mặt trời. Lớp phim mỏng, chuyên dụng này được dán lên kính xe, mang lại những lợi ích vượt trội:\r\n\r\nCách nhiệt và tiết kiệm nhiên liệu: Giảm đáng kể lượng nhiệt từ mặt trời chiếu vào xe, giúp khoang nội thất luôn mát mẻ. Điều này giúp hệ thống điều hòa hoạt động hiệu quả hơn, từ đó tiết kiệm nhiên liệu.\r\n\r\nChống tia UV và IR: Ngăn chặn gần như hoàn toàn tia cực tím (UV) và tia hồng ngoại (IR), bảo vệ làn da của bạn, làm giảm nguy cơ ung thư da và giữ cho nội thất xe không bị bạc màu, nứt nẻ.\r\n\r\nTăng sự riêng tư và an toàn: Lớp phim tối màu giúp tăng tính riêng tư cho không gian bên trong xe. Ngoài ra, trong trường hợp kính bị vỡ do va chạm, lớp phim sẽ giữ lại các mảnh vụn, hạn chế tối đa nguy hiểm cho người ngồi trong xe.', 5100000.00),
(10, 'Dán chống ồn xe', 'HoatDong', '\"Giảm tiếng ồn từ động cơ và mặt đường, tận hưởng không gian yên tĩnh và riêng tư.\"\r\n\r\nBạn cảm thấy khó chịu vì tiếng ồn từ động cơ, lốp xe, hay tiếng gió rít khi di chuyển? Dịch vụ dán cách âm - chống ồn sẽ giúp bạn giải quyết vấn đề này. Chúng tôi sử dụng các vật liệu cách âm chuyên dụng như cao su non, tấm tiêu âm, vật liệu butyl... để dán vào các vị trí dễ bị ồn như: cửa xe, sàn xe, hốc lốp, trần xe và khoang máy.\r\n\r\nLớp vật liệu này có tác dụng:\r\n\r\nGiảm tiếng ồn: Hấp thụ và triệt tiêu các tần số âm thanh từ bên ngoài và từ động cơ, mang lại không gian bên trong xe yên tĩnh và thoải mái hơn.\r\n\r\nChống rung: Tăng cường độ chắc chắn cho khung xe và các chi tiết, giảm rung động, đặc biệt khi xe di chuyển qua các đoạn đường xấu.\r\n\r\nCách nhiệt: Góp phần hạn chế lượng nhiệt từ bên ngoài truyền vào, giúp điều hòa hoạt động hiệu quả hơn.', 3000000.00),
(11, 'Độ La Zang', 'HoatDong', '\"Nâng cấp vẻ ngoài, tăng hiệu suất, thể hiện cá tính riêng của bạn.\"\r\n\r\nLazang (mâm xe) không chỉ là một bộ phận kỹ thuật mà còn là điểm nhấn thẩm mỹ, thể hiện cá tính của chủ xe. Dịch vụ độ lazang của chúng tôi sẽ giúp bạn nâng cấp chiếc xe của mình với nhiều lựa chọn đa dạng, từ việc thay thế lazang nguyên bản bằng các mẫu thiết kế thể thao, sang trọng, cho đến việc sơn lại hoặc phục hồi lazang cũ.\r\n\r\nChúng tôi cam kết sử dụng các sản phẩm chính hãng, đảm bảo chất lượng và an toàn khi vận hành. Việc độ lazang đúng tiêu chuẩn không chỉ làm tăng tính thẩm mỹ mà còn giúp xe bám đường tốt hơn, tản nhiệt phanh hiệu quả, mang lại trải nghiệm lái xe an toàn và thú vị.', 0.00),
(12, 'Độ đèn', 'HoatDong', '\"Nâng cấp ánh sáng, tăng tầm nhìn, đảm bảo an toàn cho mọi hành trình đêm.\"\r\n\r\nHệ thống đèn xe nguyên bản đôi khi không đủ sáng để đáp ứng nhu cầu di chuyển trong điều kiện thiếu sáng hoặc sương mù. Dịch vụ độ đèn của chúng tôi sẽ giúp bạn nâng cấp hệ thống chiếu sáng, mang lại ánh sáng mạnh mẽ, sắc nét và an toàn hơn.\r\n\r\nChúng tôi cung cấp nhiều giải pháp đa dạng, từ việc thay thế bóng đèn halogen bằng LED hoặc Xenon cho đến lắp đặt bi LED, bi Laser hoặc bi Xenon chất lượng cao. Việc độ đèn đúng tiêu chuẩn không chỉ giúp bạn có tầm nhìn tốt hơn, phát hiện sớm chướng ngại vật mà còn làm tăng tính thẩm mỹ và sự sang trọng cho chiếc xe của bạn.', 0.00),
(13, 'Độ âm thanh', 'HoatDong', '\"Nâng cấp hệ thống âm thanh, biến không gian xe thành phòng hòa nhạc di động.\"\r\n\r\nNếu bạn là người yêu âm nhạc và mong muốn có trải nghiệm nghe nhạc đỉnh cao ngay trên chiếc xe của mình, dịch vụ độ âm thanh là lựa chọn lý tưởng. Hệ thống âm thanh nguyên bản của xe thường chỉ đáp ứng nhu cầu cơ bản. Chúng tôi sẽ tư vấn và lắp đặt các thiết bị âm thanh cao cấp, mang đến một không gian giải trí sống động và chân thực.', 0.00),
(14, 'Độ màn hình', 'HoatDong', '\"Nâng cấp giải trí, tích hợp tiện ích, biến chiếc xe của bạn thành trung tâm công nghệ.\"\r\n\r\nMàn hình DVD nguyên bản của xe thường chỉ có các tính năng cơ bản, không đáp ứng được nhu cầu giải trí và tiện ích của người dùng hiện đại. Dịch vụ độ màn hình Android sẽ mang cả thế giới công nghệ vào không gian xe của bạn.', 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondathang`
--

CREATE TABLE `dondathang` (
  `MaDonDatHang` int(11) NOT NULL,
  `TenTaiKhoan` varchar(30) NOT NULL,
  `TongTien` decimal(15,2) DEFAULT NULL,
  `TrangThai` enum('ChoXuLy','DangGiaoHang','DaHoanThanh','Huy','HoanHang','XacNhan') NOT NULL DEFAULT 'ChoXuLy',
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL,
  `MaGiamGia` varchar(50) DEFAULT NULL,
  `GiamGia` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dondathang`
--

INSERT INTO `dondathang` (`MaDonDatHang`, `TenTaiKhoan`, `TongTien`, `TrangThai`, `CreatedAt`, `GhiChu`, `MaGiamGia`, `GiamGia`) VALUES
(7, 'a', 17950000.00, 'Huy', '2025-09-12 06:45:13', ' [Tự động hủy lúc 2025-09-17 20:07:19 do quá 15 phút chưa thanh toán]', 'GIAM50K', 50000),
(8, 'a', 17950000.00, 'Huy', '2025-09-12 06:45:58', ' [Tự động hủy lúc 2025-09-17 20:07:19 do quá 15 phút chưa thanh toán]', 'GIAM50K', 50000),
(9, 'a', 36000000.00, 'Huy', '2025-09-12 06:48:47', '', NULL, 0),
(10, 'a', 17950000.00, 'DaHoanThanh', '2025-09-12 06:49:13', 'Không có', 'GIAM50K', 50000),
(11, 'a', 21400000.00, 'Huy', '2025-09-12 15:12:50', ' [Tự động hủy lúc 2025-09-17 20:07:19 do quá 15 phút chưa thanh toán]', NULL, 0),
(12, 'a', 3350000.00, 'Huy', '2025-09-12 23:44:35', '', 'GIAM50K', 50000),
(13, 'a', 17950000.00, 'DaHoanThanh', '2025-09-12 23:45:20', '', 'GIAM50K', 50000),
(14, 'a', 17000000.00, 'Huy', '2025-09-13 00:28:37', '', NULL, 0),
(15, 'a', 33950000.00, 'HoanHang', '2025-09-13 01:09:14', '', 'GIAM50K', 50000),
(16, 'a', 16950000.00, 'XacNhan', '2025-09-13 03:03:22', '', 'GIAM50K', 50000),
(17, 'a', 3350000.00, 'XacNhan', '2025-09-13 03:34:29', '', 'GIAM50K', 50000),
(18, 'a', 16950000.00, 'XacNhan', '2025-09-13 03:42:27', '', 'GIAM50K', 50000),
(19, 'a', 16950000.00, 'XacNhan', '2025-09-13 03:49:20', '', 'GIAM50K', 50000),
(20, 'a', 16950000.00, 'HoanHang', '2025-09-13 03:54:50', '', 'GIAM50K', 50000),
(21, 'a', 17000000.00, 'HoanHang', '2025-09-13 04:04:12', '', NULL, 0),
(22, 'a', 16950000.00, 'Huy', '2025-09-13 21:27:33', ' [Tự động hủy lúc 2025-09-17 20:07:19 do quá 15 phút chưa thanh toán]', 'GIAM50K', 50000),
(23, 'a', 17000000.00, 'Huy', '2025-09-18 01:11:56', ' [Tự động hủy lúc 2025-09-17 20:31:46 do quá 15 phút chưa thanh toán]', NULL, 0),
(24, 'a', 17000000.00, 'Huy', '2025-09-18 01:18:18', ' [Tự động hủy do quá thời gian thanh toán]', NULL, 0),
(25, 'a', 16950000.00, 'ChoXuLy', '2025-09-18 01:37:05', '', 'GIAM50K', 50000),
(26, 'a', 20400000.00, 'HoanHang', '2025-09-18 01:51:01', NULL, NULL, 0),
(27, 'a', 16950000.00, 'HoanHang', '2025-09-18 01:51:30', NULL, 'GIAM50K', 50000),
(28, 'a', 3350000.00, 'Huy', '2025-09-18 01:53:19', NULL, 'GIAM50K', 50000),
(29, 'a', 3350000.00, 'Huy', '2025-09-18 01:53:20', NULL, 'GIAM50K', 50000),
(30, 'a', 3350000.00, 'Huy', '2025-09-18 01:53:22', NULL, 'GIAM50K', 50000),
(31, 'a', 3350000.00, 'Huy', '2025-09-18 01:53:22', NULL, 'GIAM50K', 50000),
(32, 'a', 3350000.00, 'Huy', '2025-09-18 01:53:23', NULL, 'GIAM50K', 50000),
(33, 'a', 3350000.00, 'Huy', '2025-09-18 01:55:42', NULL, 'GIAM50K', 50000),
(34, 'a', 3350000.00, 'Huy', '2025-09-18 01:55:43', NULL, 'GIAM50K', 50000),
(46, 'a', 900000.00, 'HoanHang', '2025-09-19 00:54:01', '', NULL, 0),
(47, 'a', 17000000.00, 'HoanHang', '2025-09-20 14:42:40', '', NULL, 0),
(48, 'a', 10250000.00, 'DaHoanThanh', '2025-09-23 20:42:20', '', 'GIAM50K', 50000),
(49, 'a', 648000.00, 'Huy', '2025-09-24 02:04:06', ' [Tự động hủy lúc 2025-09-24 16:24:34 do quá 15 phút chưa thanh toán]', 'GIAM50K', 50000),
(50, 'hieu', 16940000.00, 'DaHoanThanh', '2025-09-25 09:55:46', '', 'GIAM50K', 50000),
(51, 'a', 8849000.00, 'ChoXuLy', '2025-09-25 14:09:05', '', NULL, 0),
(52, 'hieu', 16990000.00, 'Huy', '2025-09-25 15:34:40', '', NULL, 0),
(53, 'hieu', 4990000.00, 'DaHoanThanh', '2025-09-25 15:38:13', '', NULL, 0),
(54, 'a', 16990000.00, 'Huy', '2025-09-25 16:06:50', ' [Tự động hủy lúc 2025-09-25 15:30:21 do quá 15 phút chưa thanh toán]', NULL, 0),
(55, 'hieu', 29000000.00, 'DaHoanThanh', '2025-09-25 21:56:14', '', NULL, 0),
(56, 'hieu', 4990000.00, 'ChoXuLy', '2025-09-26 02:09:19', '', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaSP` int(11) NOT NULL,
  `TenTaiKhoan` varchar(30) NOT NULL,
  `SL` int(11) DEFAULT 1,
  `UpdatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHoaDon` int(11) NOT NULL,
  `MaDonDatHang` int(11) NOT NULL,
  `TongTien` decimal(15,2) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`MaHoaDon`, `MaDonDatHang`, `TongTien`, `CreatedAt`, `GhiChu`) VALUES
(2, 10, 17950000.00, '2025-09-12 14:16:36', 'Không có'),
(3, 13, 17950000.00, '2025-09-12 23:48:25', NULL),
(4, 15, 33950000.00, '2025-09-13 01:12:10', NULL),
(5, 20, 16950000.00, '2025-09-13 03:55:37', NULL),
(6, 21, 17000000.00, '2025-09-13 04:05:31', NULL),
(7, 27, 16950000.00, '2025-09-18 01:52:44', NULL),
(8, 26, 20400000.00, '2025-09-18 01:52:50', NULL),
(9, 46, 900000.00, '2025-09-19 00:55:21', NULL),
(10, 47, 17000000.00, '2025-09-20 14:48:38', NULL),
(11, 48, 10250000.00, '2025-09-23 20:51:34', NULL),
(12, 50, 16940000.00, '2025-09-25 10:11:19', NULL),
(13, 53, 4990000.00, '2025-09-25 15:43:07', NULL),
(14, 55, 29000000.00, '2025-09-25 22:07:18', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadondichvu`
--

CREATE TABLE `hoadondichvu` (
  `MaHoaDonDichVu` int(11) NOT NULL,
  `MaDatDichVu` int(11) NOT NULL,
  `NguoiLap` varchar(50) DEFAULT NULL,
  `TongTien` decimal(15,2) NOT NULL,
  `PhuongThucTT` enum('TienMat','ChuyenKhoan','The') DEFAULT NULL,
  `TrangThaiTT` enum('ChuaThanhToan','DaThanhToan') DEFAULT 'ChuaThanhToan',
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL,
  `TenTaiKhoan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadondichvu`
--

INSERT INTO `hoadondichvu` (`MaHoaDonDichVu`, `MaDatDichVu`, `NguoiLap`, `TongTien`, `PhuongThucTT`, `TrangThaiTT`, `CreatedAt`, `GhiChu`, `TenTaiKhoan`) VALUES
(2, 3, NULL, 5800000.00, NULL, 'ChuaThanhToan', '2025-09-13 01:51:55', NULL, 'Admin'),
(4, 3, NULL, 5800000.00, NULL, 'ChuaThanhToan', '2025-09-13 01:52:24', NULL, 'Admin'),
(6, 3, NULL, 5800000.00, NULL, 'ChuaThanhToan', '2025-09-13 01:55:23', NULL, 'Admin'),
(7, 6, NULL, 5120000.00, NULL, 'ChuaThanhToan', '2025-09-24 01:55:45', NULL, 'a'),
(8, 5, NULL, 120000.00, NULL, 'ChuaThanhToan', '2025-09-24 01:55:46', NULL, 'a'),
(9, 7, NULL, 120000.00, NULL, 'ChuaThanhToan', '2025-09-25 10:12:27', NULL, 'hieu'),
(10, 8, NULL, 920000.00, NULL, 'ChuaThanhToan', '2025-09-25 15:44:07', NULL, 'hieu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisp`
--

CREATE TABLE `loaisp` (
  `MaLoaiSP` int(11) NOT NULL,
  `TenLoaiSP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisp`
--

INSERT INTO `loaisp` (`MaLoaiSP`, `TenLoaiSP`) VALUES
(1, 'Màn hình'),
(2, 'Đèn xe'),
(3, 'Camera hành trình'),
(4, 'Cảm biến'),
(5, 'Nước hoa hoa - sáp thơm xe hơi'),
(6, 'Loa '),
(8, 'Lazang - Mâm xe'),
(9, 'Lọc không khí'),
(10, 'Bọc vô lăng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `magiamgia`
--

CREATE TABLE `magiamgia` (
  `MaGiamGia` varchar(50) NOT NULL,
  `GiaTri` int(11) NOT NULL,
  `Kieu` enum('PERCENT','AMOUNT') DEFAULT NULL,
  `HanSuDung` date DEFAULT NULL,
  `SoLanSuDung` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `magiamgia`
--

INSERT INTO `magiamgia` (`MaGiamGia`, `GiaTri`, `Kieu`, `HanSuDung`, `SoLanSuDung`) VALUES
('GIAM50K', 50000, 'AMOUNT', '2025-12-31', 39),
('NEWUSER', 100000, 'AMOUNT', '2025-10-31', 10),
('SALE10', 10, 'PERCENT', '2025-12-31', 97),
('SALE20', 20, 'PERCENT', '2025-09-30', 47),
('VIP30', 30, 'PERCENT', '2025-12-31', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(100) NOT NULL,
  `SDT` varchar(15) NOT NULL,
  `Fax` varchar(13) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `SDT`, `Fax`, `DiaChi`) VALUES
(1, 'GOTECH TRADING AND PRODUCTION., JSC', '0942283336', '0109149600', 'Số 31 lô E2/D21 khu ĐTM Cầu Giấy, đường Tôn Thất Thuyết, , Thành phố Hà Nội, Việt Nam'),
(2, 'Nhà cung cấp A', '0999888777', '01091496111', 'TP. Hải Phòng'),
(3, 'Nhà cung cấp B', '0777888999', '0109149622', 'TP. Hồ Chí Minh'),
(4, 'Nhà cung cấp C', '0333193979', '0109149622', 'Thành Tô Hải An Hải Phòng'),
(5, 'Nhà cung cấp D', '0999888777', '0109149601', 'TP. Hải Phòng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieubaohanh`
--

CREATE TABLE `phieubaohanh` (
  `MaBH` int(11) NOT NULL,
  `NgayDen` datetime NOT NULL,
  `LyDo` text DEFAULT NULL,
  `XuLy` text DEFAULT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieubaohanh_chitiet`
--

CREATE TABLE `phieubaohanh_chitiet` (
  `MaChiTietBH` int(11) NOT NULL,
  `MaBH` int(11) NOT NULL,
  `MaChiTietHoaDon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieukiem`
--

CREATE TABLE `phieukiem` (
  `MaKiem` int(11) NOT NULL,
  `NguoiKiemKho` varchar(50) NOT NULL,
  `TGKiem` datetime DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieukiem`
--

INSERT INTO `phieukiem` (`MaKiem`, `NguoiKiemKho`, `TGKiem`, `GhiChu`) VALUES
(1, 'Vũ Minh Hiếu', '2025-09-13 20:37:00', 'Kiếm chất lượng'),
(2, 'Vũ Minh Hiếu', '2025-09-20 09:46:03', ''),
(3, 'Vũ Minh Hiếu', '2025-09-25 17:13:25', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaNhap` int(11) NOT NULL,
  `TGNhap` datetime DEFAULT current_timestamp(),
  `MaNCC` int(11) NOT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`MaNhap`, `TGNhap`, `MaNCC`, `GhiChu`) VALUES
(2, '2025-09-13 00:25:24', 1, ''),
(4, '2025-09-13 13:30:26', 2, 'Màn'),
(5, '2025-09-18 02:32:58', 2, ''),
(6, '2025-09-18 02:34:03', 2, ''),
(7, '2025-09-18 02:34:37', 3, ''),
(8, '2025-09-18 02:35:04', 3, ''),
(9, '2025-09-25 22:11:53', 4, ''),
(10, '2025-09-26 02:42:55', 3, ''),
(11, '2025-09-26 02:43:46', 3, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuat`
--

CREATE TABLE `phieuxuat` (
  `MaXuat` int(11) NOT NULL,
  `MaDonDatHang` int(11) DEFAULT NULL,
  `NguoiLap` varchar(50) DEFAULT NULL,
  `LyDoXuat` enum('BanHang','TraHang','Hong') NOT NULL DEFAULT 'BanHang',
  `TrangThai` enum('DaXuat','Huy') NOT NULL DEFAULT 'DaXuat',
  `TongTien` decimal(12,2) NOT NULL DEFAULT 0.00,
  `TGXuat` datetime DEFAULT current_timestamp(),
  `GhiChu` text DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `phieuxuat`
--

INSERT INTO `phieuxuat` (`MaXuat`, `MaDonDatHang`, `NguoiLap`, `LyDoXuat`, `TrangThai`, `TongTien`, `TGXuat`, `GhiChu`) VALUES
(1, 16, NULL, 'BanHang', 'DaXuat', 19500000.00, '2025-09-13 03:38:52', NULL),
(2, 17, NULL, 'BanHang', 'DaXuat', 3400000.00, '2025-09-13 03:39:00', NULL),
(3, 18, NULL, 'BanHang', 'DaXuat', 19500000.00, '2025-09-13 03:43:10', NULL),
(4, 19, NULL, 'BanHang', 'DaXuat', 19500000.00, '2025-09-13 03:49:59', NULL),
(5, 20, NULL, 'BanHang', 'Huy', 19500000.00, '2025-09-13 03:55:06', NULL),
(6, 21, 'Vũ Minh Hiếu', 'BanHang', 'Huy', 17000000.00, '2025-09-13 04:04:40', ''),
(10, NULL, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 3400000.00, '2025-09-13 12:52:13', ''),
(11, NULL, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 20400000.00, '2025-09-13 13:16:47', 'Xuất hàng hỏng'),
(12, 26, NULL, 'BanHang', 'Huy', 20400000.00, '2025-09-18 01:51:01', NULL),
(13, 27, NULL, 'BanHang', 'Huy', 17000000.00, '2025-09-18 01:51:30', NULL),
(15, 47, 'Vũ Minh Hiếu', 'BanHang', 'Huy', 17000000.00, '2025-09-20 14:47:52', ''),
(16, 48, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 10300000.00, '2025-09-23 20:50:50', ''),
(17, 50, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 16990000.00, '2025-09-25 10:10:46', ''),
(18, 53, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 4990000.00, '2025-09-25 15:42:27', ''),
(19, 55, 'Vũ Minh Hiếu', 'BanHang', 'DaXuat', 29000000.00, '2025-09-25 22:06:46', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quangcao`
--

CREATE TABLE `quangcao` (
  `MaQC` int(11) NOT NULL,
  `TenQC` varchar(255) DEFAULT NULL,
  `MoTa` varchar(255) DEFAULT NULL,
  `AnhQC` varchar(255) DEFAULT NULL,
  `TinhTrang` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quangcao`
--

INSERT INTO `quangcao` (`MaQC`, `TenQC`, `MoTa`, `AnhQC`, `TinhTrang`) VALUES
(1, 'QC 1', 'Mô tả QC 1', '/Salon/assets/img/sliders/s1.png', 1),
(2, 'QC 2', 'Mô tả QC 2', '/Salon/assets/img/sliders/s2.png', 1),
(3, 'QC 3', 'Mô tả QC 3', '/Salon/assets/img/sliders/s3.png', 1),
(4, 'QC 4', 'Mô tả QC 4', '/Salonoto/assets/img/sliders/s4.png', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `MaQuyen` int(11) NOT NULL,
  `TenQuyen` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`MaQuyen`, `TenQuyen`) VALUES
(1, 'Quản trị viên'),
(2, 'Nhân viên'),
(3, 'Khách hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `NhaSanXuat` varchar(100) DEFAULT NULL,
  `ThongSo` text DEFAULT NULL,
  `TinhNang` text DEFAULT NULL,
  `Gia` decimal(15,2) NOT NULL,
  `GiaKhuyenMai` decimal(15,2) DEFAULT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `SL` int(11) DEFAULT 0,
  `UpdatedAt` datetime DEFAULT current_timestamp(),
  `MaLoaiSP` int(11) NOT NULL,
  `ThoiGianBaoHanh` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `NhaSanXuat`, `ThongSo`, `TinhNang`, `Gia`, `GiaKhuyenMai`, `HinhAnh`, `SL`, `UpdatedAt`, `MaLoaiSP`, `ThoiGianBaoHanh`) VALUES
(1, 'Màn Hình Gotech 2K GT 13i 360', 'Gotech ', 'Thiết bị chạy hệ điều hành Android 12\r\nTrang bị CPU 8 nhân tốc độ 2.0GHz\r\nRAM 4GB, ROM 64GB và GPU Mali G52 cho hiệu năng mạnh mẽ. \r\nMàn hình QLED 2K sắc nét, độ phân giải 2000x1200.', 'Hỗ trợ kết nối 4G, phát WiFi, Bluetooth, FM/AM Radio, tích hợp cảm biến áp suất lốp, kết nối hệ thống loa trên xe và xử lý âm thanh số DSP 32 kênh. Kho ứng dụng CH Play sẵn sàng phục vụ nhu cầu giải trí và tiện ích thông minh.', 19500000.00, 17000000.00, '/Salonoto/assets/img/sanpham/a8.jpg', 11, '2025-09-11 19:03:44', 1, 1),
(2, 'Camera Hành Trình VietMap C61 Pro', 'VietMap', 'Độ phân giải video: Ultra HD 4K (2880 x 2160 P24), Full HD 1080P (60fps và 30fps)\r\nỐng kính: Góc rộng 170°, ghi hình trước xe\r\nCảm biến hình ảnh: Sony Starvis, hỗ trợ ghi hình ban đêm sắc nét\r\nMàn hình: LCD 2.4 inch\r\nNguồn điện: DC 5V, hỗ trợ thẻ nhớ microSD lên đến 128GB\r\nNgôn ngữ: Tiếng Việt và Tiếng Anh', 'Cảnh báo giao thông: Cảnh báo tốc độ, biển báo giao thông, khu vực cấm vượt, camera phạt nguội, khu vực kiểm tra tốc độ\r\nKết nối Wi-Fi: Chia sẻ video qua ứng dụng VietMap REC (Android/iOS)\r\nG-Sensor: Phát hiện va chạm, khóa video tự động\r\nGhi hình vòng lặp: Tự động ghi đè khi thẻ nhớ đầy', 3400000.00, NULL, '/Salonoto/assets/img/sanpham/a14.png', 26, '2025-09-11 19:02:59', 3, 1),
(3, 'Nước hoa GRASSE', 'Hàn Quốc (sản xuất tại Hàn Quốc, nhập khẩu chính hãng)', 'Dung tích: 105ml\r\nĐược tin dùng trên toàn thế giới ,hương thơm giữ lâu kéo dài 10-12 tiếng mỗi ngày.', 'Nước hoa Grasse L’esterl mang đến những hương thơm tuyệt vời và độc đáo, từ hương trái cây tươi mát đến hương gỗ ấm áp hay hương hoa tinh tế. Mỗi loại hương thơm đều được lựa chọn kỹ càng để tạo ra một trải nghiệm thú vị và lôi cuốn trong cabin xe.\r\nHương thơm: Đa dạng, bao gồm các mùi như hoa hồng Bulgari, đại dương, hoa xạ hương, quả mâm xôi và anh đào', 400000.00, 349000.00, '/Salonoto/assets/img/sanpham/a1.jpg', 14, '2025-09-25 09:22:20', 5, 1),
(4, 'Màn Hình Zestech Z18', 'Zestech', 'Hệ điều hành: Android 10\r\n\r\nChipset: UIS8581, Octa-core ARM Cortex-A55, tốc độ 1.6GHz\r\n\r\nRAM: 2GB\r\n\r\nROM: 32GB\r\n\r\nMàn hình: 9–10 inch, độ phân giải Full HD (1280x720), IPS, kính cường lực 2.5D\r\n\r\nKết nối: Wi-Fi, Bluetooth, 4G (SIM 4G tốc độ cao)\r\n\r\nTính năng nổi bật: Apple CarPlay, trợ lý ảo Kiki hỗ trợ giọng nói 3 miền, giao diện tự động thay đổi theo thời gian\r\n\r\nNăm sản xuất: 2025', 'Trợ lý ảo Kiki: Hỗ trợ điều khiển bằng giọng nói chính xác 3 miền Bắc, Trung, Nam. Người dùng có thể ra lệnh mở ứng dụng, tìm đường, gọi điện thoại mà không cần thao tác tay.\r\n\r\nGiao diện thông minh: Tự động thay đổi màu sắc theo thời gian trong ngày, mang đến không gian nội thất xe hiện đại và sinh động. \r\n\r\nKết nối đa dạng: Hỗ trợ kết nối với các thiết bị ngoại vi như camera hành trình, camera 360, cảm biến áp suất lốp, giúp nâng cao trải nghiệm lái xe.\r\n\r\nCập nhật phần mềm OTA: Tự động cập nhật phần mềm qua mạng, đảm bảo hệ thống luôn được nâng cấp và bảo mật.\r\n\r\nTích hợp Apple CarPlay: Cho phép kết nối và sử dụng các ứng dụng của iPhone trực tiếp trên màn hình xe.', 5800000.00, 4990000.00, '/Salonoto/assets/img/sanpham/a7.jpg', 5, '2025-09-13 21:45:57', 1, 2),
(5, 'Màn hình ô tô Santek X800', 'Santek', 'CPU: 8 nhân 7862 1.8GHz\r\nRam/Bộ nhớ trong: 4GB/32GB\r\nKích thước màn hình: 9/10 Inch\r\nKết nối Wi-Fi: Băng tần 2.4GHz + 5GHz Bluetooth: 4+\r\nHệ điều hành: Android 13 Kết nối 2 cổng USB, thẻ sim, aux\r\nKết nối Apple Carplay, Android Auto', 'Nghe nhạc offline từ USB định dạng: MP3, WAV, OGG, FLAC, …\r\nStream nhạc trực tuyến từ: ZingMP3, Spotify, Nhaccuatui, Apple Music, …\r\nXem video offline từ USB định dạng: MP4, FLV, AVI, MOV, WMV, …\r\nXem video trực tuyến từ: Youtube, TikTok, DailyMotion, Facebook, …\r\nChơi game', 7000000.00, NULL, '/Salonoto/assets/img/sanpham/a6.jpg', 13, '2025-09-13 21:47:27', 1, 1),
(6, 'Đèn Bi Pha Aozoom X - Led Pro Domax', 'Domax ', 'Công suất: 54W (cos) – 60W (pha)\r\n\r\nCường độ sáng (Lumen): 5400 – 6600 lm\r\n\r\nNhiệt độ màu: 6000K (ánh sáng trắng)\r\n\r\nChip LED: 9 - 3\r\n\r\nĐiện áp: 9V – 16V\r\n\r\nTuổi thọ: >30.000 giờ\r\n\r\nChống nước: IP65\r\n\r\nChịu nhiệt: -40°C đến +105°C\r\n\r\nKhoảng cách chiếu xa: 700 – 1000m\r\n\r\nKích thước: 3 inch', 'Hiệu suất chiếu sáng vượt trội: Với công suất lên đến 60W và cường độ sáng cao, Aozoom X - LED Pro Domax cung cấp ánh sáng mạnh mẽ, giúp tài xế dễ dàng quan sát đường và các vật cản từ xa, nâng cao an toàn khi lái xe vào ban đêm.\r\nThiết kế hiện đại và bền bỉ: Đèn được trang bị hệ thống tản nhiệt hiệu quả, giúp duy trì nhiệt độ ổn định trong suốt quá trình sử dụng. Vỏ đèn được làm từ hợp kim cao cấp, tăng cường độ bền và khả năng chống chịu với các tác động từ môi trường.\r\nDễ dàng lắp đặt và tương thích cao: Aozoom X - LED Pro Domax có thiết kế chuẩn 3 inch, phù hợp với nhiều loại xe và dễ dàng thay thế cho các đèn bi pha nguyên bản mà không cần thay đổi cấu trúc xe.', 12000000.00, NULL, '/Salonoto/assets/img/sanpham/a15.png', 6, '2025-09-13 21:50:55', 2, 3),
(7, 'LAZANG DAEWOO GENTRA 14 INCH PCD 4X100', 'Rapidash ', 'Kích thước: 14 inch x 6.0J\r\n\r\nPCD (Pitch Circle Diameter): 4x100\r\n\r\nMàu sắc: Đen đỏ\r\n\r\nChất liệu: Hợp kim nhôm cao cấp\r\n\r\nSố cánh: Nhiều cánh chéo\r\n\r\nCân nặng: 13 kg (bộ 4 chiếc)', 'Dòng lazang độ cho lazang xe Gentra của hãng Rapidash có thông số 14 inch, PCD 4X100, màu đen đỏ được làm từ hợp kim nhôm cao cấp và sơn tĩnh điện cực kỳ bền đẹp.', 58000000.00, NULL, '/Salonoto/assets/img/sanpham/a10.png', 18, '2025-09-13 21:53:11', 8, 3),
(8, 'Loa Sub ô tô Audison APBX 10DS', 'Audison', 'Kích thước loa: 10 inch (250 mm)\r\n\r\nCông suất:\r\n\r\nLiên tục (RMS): 400W\r\n\r\nĐỉnh (Peak): 800W\r\n\r\nTrở kháng: 4 + 4 ohm (2 cuộn dây âm thanh)\r\n\r\nThùng loa: Hộp kín (sealed) dung tích 12 lít\r\n\r\nVật liệu màng loa: Giấy ép sợi bông chống nước\r\n\r\nVật liệu nam châm: Ferrite mật độ cao\r\n\r\nHành trình cơ học: >18 mm, cho khả năng tái tạo âm bass sâu và mạnh mẽ\r\n\r\nKích thước thùng (mm): 472 (Rộng) x 334 (Sâu) x 120 (Cao)\r\n\r\nTrọng lượng: 8.63 kg (19.03 lbs)', 'Thiết kế siêu mỏng: Thùng loa chỉ cao 120 mm, phù hợp với không gian hạn chế trong xe hơi.\r\n\r\nLắp đặt linh hoạt: Có thể lắp đặt theo hướng lên (up-firing) hoặc xuống (down-firing) tùy theo yêu cầu âm thanh và không gian xe.\r\n\r\nChân đế chống trượt: Đi kèm với chân đế có lớp dính Velcro, giúp cố định loa trên thảm xe mà không gây hư hại.\r\n\r\nKết nối dễ dàng: Hệ thống cắm Sub Smart Plug (SSP) với đầu nối 4 chân, hỗ trợ cả kết nối truyền thống và nhanh chóng.', 8500000.00, NULL, '/Salonoto/assets/img/sanpham/a12.png', 17, '2025-09-13 21:54:13', 6, 2),
(9, 'Máy lọc không khí ô tô Hàn Quốc Allo A600 (APS-600)', 'Allo', 'Kích thước: 70 × 70 × 186 mm\r\n\r\nTrọng lượng: 240 g\r\n\r\nNguồn điện: USB 5V (có thể sử dụng trên ô tô, máy tính hoặc sạc dự phòng)\r\n\r\nĐộ ồn: 30–35 dB\r\n\r\nChế độ quạt: 2 tốc độ (thấp và turbo)\r\n\r\nLỗ hút khí: 312 lỗ xung quanh thân máy\r\n\r\nMàng lọc: 3 lớp (cotton, than hoạt tính, HEPA)\r\n\r\nNồng độ ion âm: Lên đến 5 triệu ion/cm³\r\n\r\nMàu sắc: Đen', 'Lọc không khí hiệu quả: Màng lọc 3 lớp giúp loại bỏ đến 99.97% bụi mịn PM2.5, vi khuẩn và mùi hôi.\r\n\r\nTạo ion âm: Giúp khử mùi, khử khuẩn và tạo không khí trong lành.\r\n\r\nThiết kế hiện đại: Phong cách tối giản, phù hợp với không gian nội thất hiện đại.\r\n\r\nLắp đặt linh hoạt: Có thể sử dụng trên ô tô, bàn làm việc hoặc trong phòng ngủ.\r\n\r\nDễ dàng thay thế màng lọc: Màng lọc có thể tháo rời và thay thế sau khoảng 1 năm sử dụng.', 950000.00, 900000.00, '/Salonoto/assets/img/sanpham/a10.jpg', 9, '2025-09-24 01:07:57', 9, 1),
(10, 'Nước hoa ô tô cao cấp Masamune', 'CARALL', 'Dung tích 138 ml\r\n\r\nPhiên bản Platimum Luxury\r\n\r\n Màu sắc : màu bạc sáng như hình', 'Kiểu dáng đẹp sang trọng\r\n\r\nHộp có màu bạc lấp lánh, sang trọng\r\n\r\nMùi thơm nhẹ nhàng sang trọng\r\n\r\nCó tác dụng khử mùi loại bỏ các mùi khó chịu như mùi thuốc lá, mùi da nội thất, mùi mồ hôi\r\n\r\nTạo mùi thơm sang trọng cho chiếc xe\r\n\r\nLà chi tiết trang trí nội thất chiếc xe thêm sang trọng\r\n\r\n- Trên hộp có dán tem chống hàng giả của bộ công an', 740000.00, 620000.00, '/Salonoto/assets/img/sanpham/nchoa.jpg', 8, '2025-09-26 02:27:34', 5, 0),
(11, 'Bọc Vô Lăng Sparco', 'Sparco', 'Màu sắc: Đen nhám\r\nKích thước: 36 – 38 cm (đường kính vô lăng)', 'Chất liệu da PU cao cấp mền mại mang đến cảm giác êm ái vượt trội khi cằm nắm.\r\nThấm hút mồ hôi tốt, không bị trơn tay với các lỗ thoáng khí liti.\r\nVòng cao su cao cấp, nặng 500 – 665 gram mang đến cảm giác đầm chắc vô lăng khi đánh lái.\r\nSản phẩm có thiết kế thể thao, sang trọng, nổi bật.\r\nThương hiệu phụ kiện hàng đầu từ Ý, có mặt tại hơn 120 quốc gia trên thế giới.\r\nSản phẩm phân phối và bảo hành chính hãng trên toàn quốc.', 450000.00, 420000.00, '/Salonoto/assets/img/sanpham/bocvl1.jpg', 6, '2025-09-26 02:31:23', 10, 1),
(12, 'Camera Hành Trình Vietmap Speedmap M2', 'Vietmap ', 'Độ phân giải: Full HD 1080P @30fps\r\nGóc quay: 170 độ\r\nHệ thống cảnh báo ADAS: LDWS, FCWS\r\nGPS	Có, cập nhật dữ liệu tốc độ\r\nCảnh báo tốc độ:Dựa trên dữ liệu GPS\r\nGhi hình khi đỗ xe: Có\r\nHỗ trợ thẻ nhớ	Tối đa:128GB', 'Ghi hình Full HD sắc nét – Chi tiết rõ ràng cả ngày & đêm.\r\nCảnh báo tốc độ chính xác giúp lái xe an toàn, tránh vi phạm giao thông.\r\nTích hợp ADAS – Hỗ trợ cảnh báo chệch làn & khoảng cách xe trước.\r\nGPS theo dõi hành trình & tốc độ di chuyển chi tiết.\r\nGhi hình ngay cả khi xe đỗ – Bảo vệ xe 24/7.', 7990000.00, 7590000.00, '/Salonoto/assets/img/sanpham/cam1.jpg', 9, '2025-09-26 02:44:40', 3, 2),
(13, 'Cảm biến lùi 4 mắt cho xe ô tô', 'Việt Nam', '4 Mắt cảm biến hồng ngoại\r\n\r\nMàn hình hiển thị khoảng cách\r\n\r\nHiển thị khoảng cách từ 0 – 2.5m\r\n\r\nPhạm vi điện áp hoạt động: 9 – 16V\r\n\r\nCó 3 màu: Đen, Trắng, Bạc phù hợp với xe.\r\n\r\nTích hợp chuông kêu, hỗ trợ lùi xe, đỗ xe an toàn', 'Cảm biến lùi hay cảm biến tiến đều có tác dụng phòng tránh và giúp giảm thiểu khả năng va chạm khi lùi xe.\r\n\r\nGiúp tài xế dễ dàng lùi xe, và đỗ xe ở những đoạn đường hẹp và gấp khúc.\r\n\r\nThiết bị cảm biến có thể cảnh báo chướng ngại vật ngoài tầm quan sát giúp hạn chế các điểm mù của xe.\r\n\r\nLùi xe nhanh hơn và an toàn hơn khi có cảm biến lùi.\r\n\r\nVượt xe ở những đoạn đường tắc nghẽn dễ hơn để tránh va chạm.', 400000.00, 350000.00, '/Salonoto/assets/img/sanpham/a13.png', 7, '2025-09-26 02:42:01', 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaTT` int(11) NOT NULL,
  `MaDonDatHang` int(11) DEFAULT NULL,
  `TongTien` decimal(15,2) NOT NULL,
  `PhuongThucTT` varchar(50) NOT NULL,
  `TrangThaiTT` enum('ChoXuLy','HoanTat','Huy') DEFAULT 'ChoXuLy',
  `MaGiaoDich` varchar(100) DEFAULT NULL,
  `NgayTT` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `GhiChu` text DEFAULT NULL,
  `TenTaiKhoan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhtoan`
--

INSERT INTO `thanhtoan` (`MaTT`, `MaDonDatHang`, `TongTien`, `PhuongThucTT`, `TrangThaiTT`, `MaGiaoDich`, `NgayTT`, `UpdatedAt`, `GhiChu`, `TenTaiKhoan`) VALUES
(1, 10, 17950000.00, 'COD', 'HoanTat', 'GD8238414', '2025-09-12 07:08:57', '2025-09-12 14:16:29', 'Không có', 'a'),
(2, 13, 17950000.00, 'COD', 'HoanTat', 'GD6046907', '2025-09-12 23:45:22', '2025-09-12 23:48:22', '', 'a'),
(3, 14, 17000000.00, 'COD', 'ChoXuLy', 'GD9624840', '2025-09-13 00:28:38', '2025-09-13 00:28:38', '', 'a'),
(4, 15, 33950000.00, 'COD', 'HoanTat', 'GD7172477', '2025-09-13 01:09:15', '2025-09-13 01:09:45', '', 'a'),
(5, 16, 16950000.00, 'COD', 'HoanTat', 'GD3124042', '2025-09-13 03:03:23', '2025-09-13 03:30:07', '', 'a'),
(6, 17, 3350000.00, 'COD', 'HoanTat', 'GD6302697', '2025-09-13 03:34:35', '2025-09-13 03:38:59', '', 'a'),
(7, 18, 16950000.00, 'COD', 'HoanTat', 'GD6162448', '2025-09-13 03:42:29', '2025-09-13 03:42:52', '', 'a'),
(8, 19, 16950000.00, 'ChuyenKhoan', 'HoanTat', 'GD4410522', '2025-09-13 03:49:25', '2025-09-13 03:49:39', '', 'a'),
(9, 20, 16950000.00, 'COD', 'HoanTat', 'GD7940108', '2025-09-13 03:54:52', '2025-09-13 03:55:04', '', 'a'),
(10, 21, 17000000.00, 'COD', 'HoanTat', 'GD8971070', '2025-09-13 04:04:13', '2025-09-13 04:04:39', '', 'a'),
(12, 25, 16950000.00, 'ChuyenKhoan', 'ChoXuLy', 'GD20250918014007750', '2025-09-18 01:40:07', '2025-09-18 01:40:07', '', 'a'),
(13, 46, 900000.00, 'COD', 'HoanTat', 'GD20250919005412249', '2025-09-19 00:54:12', '2025-09-19 00:54:50', '', 'a'),
(14, 47, 17000000.00, 'COD', 'HoanTat', 'GD20250920144318491', '2025-09-20 14:43:18', '2025-09-20 14:47:50', '', 'a'),
(15, 48, 10250000.00, 'COD', 'HoanTat', 'GD20250923204315249', '2025-09-23 20:43:15', '2025-09-23 20:50:44', '', 'a'),
(16, 50, 16940000.00, 'COD', 'HoanTat', 'GD20250925100538258', '2025-09-25 10:05:38', '2025-09-25 10:10:33', '', 'hieu'),
(17, 51, 8849000.00, 'COD', 'ChoXuLy', 'GD20250925141007588', '2025-09-25 14:10:07', '2025-09-25 14:10:07', '', 'a'),
(18, 52, 16990000.00, 'ChuyenKhoan', 'ChoXuLy', 'GD20250925153608346', '2025-09-25 15:36:08', '2025-09-25 15:36:08', '', 'hieu'),
(19, 53, 4990000.00, 'COD', 'HoanTat', 'GD20250925153815783', '2025-09-25 15:38:15', '2025-09-25 15:42:12', '', 'hieu'),
(20, 55, 29000000.00, 'ChuyenKhoan', 'HoanTat', 'GD20250925215750748', '2025-09-25 21:57:50', '2025-09-25 22:06:41', '', 'hieu'),
(21, 56, 4990000.00, 'ChuyenKhoan', 'ChoXuLy', 'GD20250926021442880', '2025-09-26 02:14:42', '2025-09-26 02:14:42', '', 'hieu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `TenTaiKhoan` varchar(30) NOT NULL,
  `TenDayDu` varchar(50) NOT NULL,
  `MatKhau` varchar(100) NOT NULL,
  `SDT` varchar(15) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `DiaChi` varchar(100) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `TrangThai` tinyint(4) DEFAULT 1,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `MaQuyen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`TenTaiKhoan`, `TenDayDu`, `MatKhau`, `SDT`, `Email`, `DiaChi`, `Avatar`, `TrangThai`, `CreatedAt`, `MaQuyen`) VALUES
('a', 'Nguyễn Văn A', '$2y$10$3asKel2BaeUFq3O28A6oGerJMsSoyaaSk2hCN7myQF6ifkjFd0FHu', '0123456788', 'user1@gmail.com', 'Thành Tô, Hải An, TP. Hải Phòng', '/Salonoto/assets/img/a.png', 1, '2025-08-26 01:04:39', 3),
('Admin', 'Vũ Minh Hiếu', '$2y$10$TkhZIvgByID1VobpBQS.8eV7iDGHX7eBQVnmXk/6a0s.ZTCJ04Ewa', '0904482072', 'hieuvm.0101@gmail.com', 'TP. Hải Phòng', '/Salonoto/assets/img/hacker.png', 1, '2025-08-26 01:03:01', 1),
('hieu', 'Vũ Minh Hiếu', '$2y$10$.ucTYiYs5PwWxq8wu1hA7OgFVKhBaLmAIBGPtw4.u216WklqiwZJ.', '0904482077', 'hieuvm.0101@gmail.com', 'Số 269 Thành Tô Hải Phòng', '/Salonoto/assets/img/hieu.png', 1, '2025-09-25 00:53:21', 3),
('tinh', 'Lục Đức Tình', '$2y$10$ZRfMNtCiX.OlQ2GqUzF1UO2EG1DMf1XRPKWt4RBoujaBsNf2xbgjW', '0999888777', 'user1@gmail.com', 'TP. Hồ Chí Minh', '/assets/img/user.png', 1, '2025-09-24 01:50:16', 2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD PRIMARY KEY (`MaChiTietDonDatHang`),
  ADD KEY `FK_CTDH_SP` (`MaSP`),
  ADD KEY `FK_CTDH_DDH` (`MaDonDatHang`);

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaChiTietHoaDon`),
  ADD KEY `FK_CTHD_HD` (`MaHoaDon`);

--
-- Chỉ mục cho bảng `chitiethoadondichvu`
--
ALTER TABLE `chitiethoadondichvu`
  ADD PRIMARY KEY (`MaChiTietHoaDonDichVu`),
  ADD KEY `FK_CTHDDV_HDDV` (`MaHoaDonDichVu`);

--
-- Chỉ mục cho bảng `chitietphieukiem`
--
ALTER TABLE `chitietphieukiem`
  ADD PRIMARY KEY (`MaChiTietKiem`),
  ADD KEY `FK_CTPK_PK` (`MaKiem`),
  ADD KEY `FK_CTPK_SP` (`MaSP`);

--
-- Chỉ mục cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`MaChiTietNhap`),
  ADD KEY `FK_CTPN_PN` (`MaNhap`),
  ADD KEY `FK_CTPN_SP` (`MaSP`);

--
-- Chỉ mục cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD PRIMARY KEY (`MaChiTietXuat`),
  ADD KEY `FK_CTX_PX` (`MaXuat`),
  ADD KEY `FK_CTX_SP` (`MaSP`);

--
-- Chỉ mục cho bảng `datdichvu`
--
ALTER TABLE `datdichvu`
  ADD PRIMARY KEY (`MaDatDichVu`),
  ADD KEY `FK_DDVPhieu_User` (`TenTaiKhoan`);

--
-- Chỉ mục cho bảng `datdichvu_chitiet`
--
ALTER TABLE `datdichvu_chitiet`
  ADD KEY `FK_DDVCT_Phieu` (`MaDatDichVu`),
  ADD KEY `FK_DDVCT_DV` (`MaDichVu`);

--
-- Chỉ mục cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`MaDichVu`);

--
-- Chỉ mục cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`MaDonDatHang`),
  ADD KEY `FK_DDH_User` (`TenTaiKhoan`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaSP`,`TenTaiKhoan`),
  ADD KEY `FK_GH_User` (`TenTaiKhoan`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHoaDon`),
  ADD KEY `FK_HD_DDH` (`MaDonDatHang`);

--
-- Chỉ mục cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD PRIMARY KEY (`MaHoaDonDichVu`),
  ADD KEY `FK_HDDV_Phieu` (`MaDatDichVu`),
  ADD KEY `fk_hoadondichvu_tentaikhoan` (`TenTaiKhoan`);

--
-- Chỉ mục cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`MaLoaiSP`);

--
-- Chỉ mục cho bảng `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD PRIMARY KEY (`MaGiamGia`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `phieubaohanh`
--
ALTER TABLE `phieubaohanh`
  ADD PRIMARY KEY (`MaBH`);

--
-- Chỉ mục cho bảng `phieubaohanh_chitiet`
--
ALTER TABLE `phieubaohanh_chitiet`
  ADD PRIMARY KEY (`MaChiTietBH`),
  ADD KEY `FK_PBHC_BH` (`MaBH`),
  ADD KEY `FK_PBHC_CTHD` (`MaChiTietHoaDon`);

--
-- Chỉ mục cho bảng `phieukiem`
--
ALTER TABLE `phieukiem`
  ADD PRIMARY KEY (`MaKiem`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaNhap`),
  ADD KEY `FK_PN_NCC` (`MaNCC`);

--
-- Chỉ mục cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD PRIMARY KEY (`MaXuat`),
  ADD KEY `FK_PX_DDH` (`MaDonDatHang`);

--
-- Chỉ mục cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  ADD PRIMARY KEY (`MaQC`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`MaQuyen`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `FK_SP_LoaiSP` (`MaLoaiSP`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `FK_TT_DDH` (`MaDonDatHang`),
  ADD KEY `fk_thanhtoan_user` (`TenTaiKhoan`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`TenTaiKhoan`),
  ADD KEY `FK_Users_Quyen` (`MaQuyen`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  MODIFY `MaChiTietDonDatHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `MaChiTietHoaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `chitiethoadondichvu`
--
ALTER TABLE `chitiethoadondichvu`
  MODIFY `MaChiTietHoaDonDichVu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `chitietphieukiem`
--
ALTER TABLE `chitietphieukiem`
  MODIFY `MaChiTietKiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  MODIFY `MaChiTietNhap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  MODIFY `MaChiTietXuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `datdichvu`
--
ALTER TABLE `datdichvu`
  MODIFY `MaDatDichVu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `MaDichVu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `MaDonDatHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHoaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  MODIFY `MaHoaDonDichVu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  MODIFY `MaLoaiSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `MaNCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phieubaohanh`
--
ALTER TABLE `phieubaohanh`
  MODIFY `MaBH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieubaohanh_chitiet`
--
ALTER TABLE `phieubaohanh_chitiet`
  MODIFY `MaChiTietBH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phieukiem`
--
ALTER TABLE `phieukiem`
  MODIFY `MaKiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  MODIFY `MaNhap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  MODIFY `MaXuat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quangcao`
--
ALTER TABLE `quangcao`
  MODIFY `MaQC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `quyen`
--
ALTER TABLE `quyen`
  MODIFY `MaQuyen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `MaTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD CONSTRAINT `FK_CTDH_DDH` FOREIGN KEY (`MaDonDatHang`) REFERENCES `dondathang` (`MaDonDatHang`),
  ADD CONSTRAINT `FK_CTDH_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `FK_CTHD_HD` FOREIGN KEY (`MaHoaDon`) REFERENCES `hoadon` (`MaHoaDon`);

--
-- Các ràng buộc cho bảng `chitiethoadondichvu`
--
ALTER TABLE `chitiethoadondichvu`
  ADD CONSTRAINT `FK_CTHDDV_HDDV` FOREIGN KEY (`MaHoaDonDichVu`) REFERENCES `hoadondichvu` (`MaHoaDonDichVu`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitietphieukiem`
--
ALTER TABLE `chitietphieukiem`
  ADD CONSTRAINT `FK_CTPK_PK` FOREIGN KEY (`MaKiem`) REFERENCES `phieukiem` (`MaKiem`),
  ADD CONSTRAINT `FK_CTPK_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `FK_CTPN_PN` FOREIGN KEY (`MaNhap`) REFERENCES `phieunhap` (`MaNhap`),
  ADD CONSTRAINT `FK_CTPN_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD CONSTRAINT `FK_CTX_PX` FOREIGN KEY (`MaXuat`) REFERENCES `phieuxuat` (`MaXuat`),
  ADD CONSTRAINT `FK_CTX_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `datdichvu`
--
ALTER TABLE `datdichvu`
  ADD CONSTRAINT `FK_DDVPhieu_User` FOREIGN KEY (`TenTaiKhoan`) REFERENCES `users` (`TenTaiKhoan`);

--
-- Các ràng buộc cho bảng `datdichvu_chitiet`
--
ALTER TABLE `datdichvu_chitiet`
  ADD CONSTRAINT `FK_DDVCT_DV` FOREIGN KEY (`MaDichVu`) REFERENCES `dichvu` (`MaDichVu`),
  ADD CONSTRAINT `FK_DDVCT_Phieu` FOREIGN KEY (`MaDatDichVu`) REFERENCES `datdichvu` (`MaDatDichVu`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `FK_DDH_User` FOREIGN KEY (`TenTaiKhoan`) REFERENCES `users` (`TenTaiKhoan`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `FK_GH_SP` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`),
  ADD CONSTRAINT `FK_GH_User` FOREIGN KEY (`TenTaiKhoan`) REFERENCES `users` (`TenTaiKhoan`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `FK_HD_DDH` FOREIGN KEY (`MaDonDatHang`) REFERENCES `dondathang` (`MaDonDatHang`);

--
-- Các ràng buộc cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD CONSTRAINT `FK_HDDV_Phieu` FOREIGN KEY (`MaDatDichVu`) REFERENCES `datdichvu` (`MaDatDichVu`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hoadondichvu_tentaikhoan` FOREIGN KEY (`TenTaiKhoan`) REFERENCES `users` (`TenTaiKhoan`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieubaohanh_chitiet`
--
ALTER TABLE `phieubaohanh_chitiet`
  ADD CONSTRAINT `FK_PBHC_BH` FOREIGN KEY (`MaBH`) REFERENCES `phieubaohanh` (`MaBH`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_PBHC_CTHD` FOREIGN KEY (`MaChiTietHoaDon`) REFERENCES `chitiethoadon` (`MaChiTietHoaDon`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `FK_PN_NCC` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`);

--
-- Các ràng buộc cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD CONSTRAINT `FK_PX_DDH` FOREIGN KEY (`MaDonDatHang`) REFERENCES `dondathang` (`MaDonDatHang`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `FK_SP_LoaiSP` FOREIGN KEY (`MaLoaiSP`) REFERENCES `loaisp` (`MaLoaiSP`);

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `FK_TT_DDH` FOREIGN KEY (`MaDonDatHang`) REFERENCES `dondathang` (`MaDonDatHang`),
  ADD CONSTRAINT `fk_thanhtoan_user` FOREIGN KEY (`TenTaiKhoan`) REFERENCES `users` (`TenTaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_Users_Quyen` FOREIGN KEY (`MaQuyen`) REFERENCES `quyen` (`MaQuyen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
