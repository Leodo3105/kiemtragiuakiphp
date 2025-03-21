<?php
require_once __DIR__ . '/../models/DangKy.php';
require_once __DIR__ . '/../models/SinhVien.php';


class DangKyController
{
    private $dangKyModel;
    private $sinhVienModel;
    
    public function __construct()
    {
        $this->dangKyModel = new DangKy();
        $this->sinhVienModel = new SinhVien();
        
        // Kiểm tra đăng nhập
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['maSV'])) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }
    
    /**
     * Hiển thị danh sách học phần đã đăng ký
     */
    public function index()
    {
        $maSV = $_SESSION['maSV'];
        
        // Lấy thông tin sinh viên
        $sinhVien = $this->sinhVienModel->getByID($maSV);
        
        // Lấy danh sách học phần đã đăng ký
        $dangKy = $this->dangKyModel->getByMaSV($maSV);
        $chiTietDangKy = $this->dangKyModel->getChiTietDangKy($dangKy['MaDK'] ?? null);
        
        // Load view danh sách đăng ký
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/dangky/index.php';
    }
    
    /**
     * Xóa một học phần đã đăng ký
     */
    public function delete($maHP)
    {
        $maSV = $_SESSION['maSV'];
        
        // Lấy thông tin đăng ký
        $dangKy = $this->dangKyModel->getByMaSV($maSV);
        
        if (!$dangKy) {
            echo "Không tìm thấy thông tin đăng ký.";
            return;
        }
        
        // Xóa chi tiết đăng ký
        if ($this->dangKyModel->deleteChiTietDangKy($dangKy['MaDK'], $maHP)) {
            // Cập nhật số lượng đăng ký
            $this->dangKyModel->updateSoLuongDangKy($maHP);
            
            // Chuyển hướng về trang danh sách
            header('Location: index.php?controller=dangky&action=index');
            exit;
        } else {
            echo "Lỗi: Không thể xóa học phần đã đăng ký.";
        }
    }
    
    /**
     * Xóa tất cả học phần đã đăng ký
     */
    public function deleteAll()
    {
        $maSV = $_SESSION['maSV'];
        
        // Lấy thông tin đăng ký
        $dangKy = $this->dangKyModel->getByMaSV($maSV);
        
        if (!$dangKy) {
            echo "Không tìm thấy thông tin đăng ký.";
            return;
        }
        
        // Lấy danh sách học phần đã đăng ký để cập nhật số lượng
        $chiTietDangKy = $this->dangKyModel->getChiTietDangKy($dangKy['MaDK']);
        
        // Xóa tất cả chi tiết đăng ký
        if ($this->dangKyModel->deleteAllChiTietDangKy($dangKy['MaDK'])) {
            // Cập nhật số lượng đăng ký cho mỗi học phần
            foreach ($chiTietDangKy as $ct) {
                $this->dangKyModel->updateSoLuongDangKy($ct['MaHP']);
            }
            
            // Chuyển hướng về trang danh sách
            header('Location: index.php?controller=dangky&action=index');
            exit;
        } else {
            echo "Lỗi: Không thể xóa các học phần đã đăng ký.";
        }
    }
    
    /**
     * Lưu thông tin đăng ký
     */
    public function save()
    {
        $maSV = $_SESSION['maSV'];
        
        // Cập nhật ngày đăng ký
        $this->dangKyModel->updateNgayDangKy($maSV);
        
        // Hiển thị thông báo thành công
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/dangky/success.php';
    }
}