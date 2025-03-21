<?php
/**
 * File kiểm tra kết nối database và dữ liệu
 * Đặt file này ở thư mục gốc và chạy trực tiếp
 * http://localhost/kiemtragk/check_data.php
 */

// Thông tin kết nối database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test1';

echo "<h1>Kiểm tra kết nối và dữ liệu</h1>";

// Kiểm tra kết nối
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("<p style='color:red'>Lỗi kết nối: " . $conn->connect_error . "</p>");
}

echo "<p style='color:green'>Kết nối database thành công!</p>";

// Kiểm tra bảng NganhHoc
echo "<h2>Bảng NganhHoc</h2>";
$result_nganh = $conn->query("SELECT * FROM NganhHoc");

if (!$result_nganh) {
    echo "<p style='color:red'>Lỗi truy vấn bảng NganhHoc: " . $conn->error . "</p>";
} else {
    if ($result_nganh->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Mã Ngành</th><th>Tên Ngành</th></tr>";
        
        while ($row = $result_nganh->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['MaNganh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TenNganh']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='color:orange'>Không có dữ liệu trong bảng NganhHoc</p>";
    }
}

// Kiểm tra bảng SinhVien
echo "<h2>Bảng SinhVien</h2>";
$result_sv = $conn->query("SELECT * FROM SinhVien");

if (!$result_sv) {
    echo "<p style='color:red'>Lỗi truy vấn bảng SinhVien: " . $conn->error . "</p>";
} else {
    if ($result_sv->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Mã SV</th><th>Họ Tên</th><th>Giới Tính</th><th>Ngày Sinh</th><th>Hình</th><th>Mã Ngành</th></tr>";
        
        while ($row = $result_sv->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['MaSV']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HoTen']) . "</td>";
            echo "<td>" . htmlspecialchars($row['GioiTinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NgaySinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Hinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['MaNganh']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='color:orange'>Không có dữ liệu trong bảng SinhVien</p>";
    }
}

// Kiểm tra truy vấn join
echo "<h2>Kiểm tra JOIN</h2>";
$query_join = "SELECT sv.*, ng.TenNganh FROM SinhVien sv LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh";
$result_join = $conn->query($query_join);

if (!$result_join) {
    echo "<p style='color:red'>Lỗi truy vấn JOIN: " . $conn->error . "</p>";
} else {
    if ($result_join->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Mã SV</th><th>Họ Tên</th><th>Giới Tính</th><th>Mã Ngành</th><th>Tên Ngành</th></tr>";
        
        while ($row = $result_join->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['MaSV']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HoTen']) . "</td>";
            echo "<td>" . htmlspecialchars($row['GioiTinh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['MaNganh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TenNganh']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='color:orange'>Không có dữ liệu từ truy vấn JOIN</p>";
    }
}

// Đóng kết nối
$conn->close();
echo "<p>Đã đóng kết nối.</p>";
?>