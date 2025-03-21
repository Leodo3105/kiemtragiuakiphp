<?php
require_once __DIR__ . '/../models/SinhVien.php';

/**
 * Class LoginController - Xử lý đăng nhập
 */
class LoginController
{
    private $sinhVienModel;
    
    public function __construct()
    {
        $this->sinhVienModel = new SinhVien();
        
        // Khởi tạo session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Hiển thị form đăng nhập
     */
    public function index()
    {
        // Load view form đăng nhập
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/login/index.php';
    }
    
    /**
     * Xử lý đăng nhập
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['maSV'];
            
            // Kiểm tra sinh viên tồn tại
            $sinhVien = $this->sinhVienModel->getByID($maSV);
            
            if ($sinhVien) {
                // Lưu thông tin sinh viên vào session
                $_SESSION['maSV'] = $sinhVien['MaSV'];
                $_SESSION['hoTen'] = $sinhVien['HoTen'];
                $_SESSION['ngaySinh'] = $sinhVien['NgaySinh'];
                $_SESSION['maNganh'] = $sinhVien['MaNganh'];
                
                // Chuyển hướng về trang chủ
                header('Location: index.php?controller=hocphan&action=index');
                exit;
            } else {
                // Không tìm thấy sinh viên
                echo "Không tìm thấy thông tin sinh viên với mã: " . $maSV;
                return;
            }
        }
        
        // Nếu không phải method POST, quay về trang đăng nhập
        header('Location: index.php?controller=login&action=index');
        exit;
    }
    
    /**
     * Đăng xuất
     */
    public function logout()
    {
        // Xóa session
        session_unset();
        session_destroy();
        
        // Chuyển hướng về trang đăng nhập
        header('Location: index.php?controller=login&action=index');
        exit;
    }
}