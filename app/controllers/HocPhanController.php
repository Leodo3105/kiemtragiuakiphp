<?php
require_once __DIR__ . '/../models/HocPhan.php';

/**
 * Class HocPhanController - Xử lý các thao tác liên quan đến học phần
 */
class HocPhanController
{
    private $hocPhanModel;
    
    public function __construct()
    {
        $this->hocPhanModel = new HocPhan();
        
        // Đảm bảo cột SoLuongDuKien tồn tại
        $this->hocPhanModel->addSoLuongDuKienColumn();
    }
    
    /**
     * Hiển thị danh sách học phần
     */
    public function index()
    {
        $hocPhans = $this->hocPhanModel->getAll();
        
        // Load view hiển thị danh sách học phần
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/hocphan/index.php';
    }
    
    /**
     * Xử lý đăng ký học phần
     */
    public function dangKy($maHP)
    {
        // Kiểm tra đăng nhập
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
        
        $maSV = $_SESSION['maSV'];
        $ngayDK = date('Y-m-d');
        
        // Kiểm tra học phần tồn tại
        $hocPhan = $this->hocPhanModel->getByID($maHP);
        if (!$hocPhan) {
            echo "Học phần không tồn tại.";
            return;
        }
        
        // Kiểm tra số lượng đăng ký còn
        // Thay vì sử dụng 'SoLuongDangKy', sử dụng 'SoLuongConLai'
        if (isset($hocPhan['SoLuongConLai']) && $hocPhan['SoLuongConLai'] <= 0) {
            echo "Học phần đã đủ số lượng đăng ký.";
            return;
        }
        
        // Kiểm tra sinh viên đã đăng ký học phần này chưa
        if ($this->hocPhanModel->checkDangKy($maSV, $maHP)) {
            echo "Bạn đã đăng ký học phần này rồi.";
            return;
        }
        
        // Thực hiện đăng ký
        if ($this->hocPhanModel->dangKy($maSV, $maHP, $ngayDK)) {
            // Cập nhật số lượng đăng ký
            $this->hocPhanModel->updateSoLuongDangKy($maHP);
            
            // Chuyển hướng đến trang giỏ hàng
            header('Location: index.php?controller=dangky&action=index');
            exit;
        } else {
            echo "Lỗi: Không thể đăng ký học phần.";
        }
    }
}