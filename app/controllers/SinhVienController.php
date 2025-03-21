<?php
require_once __DIR__ . '/../models/SinhVien.php';
require_once __DIR__ . '/../models/NganhHoc.php';

/**
 * Class SinhVienController - Xử lý các thao tác CRUD với sinh viên
 */
class SinhVienController
{
    private $sinhVienModel;
    private $nganhHocModel;
    
    public function __construct()
    {
        $this->sinhVienModel = new SinhVien();
        $this->nganhHocModel = new NganhHoc();
    }
    
    /**
     * Hiển thị danh sách sinh viên
     */
    public function index()
    {
        $sinhViens = $this->sinhVienModel->getAll();
        
        // Load view hiển thị danh sách sinh viên
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/sinhvien/index.php';
    }
    
    /**
     * Hiển thị form thêm sinh viên
     */
    public function create()
    {
        $nganhHocs = $this->nganhHocModel->getAllAsArray();
        
        // Load view form thêm sinh viên
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/sinhvien/create.php';
    }
    
    /**
     * Xử lý thêm sinh viên từ form submit
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Gán dữ liệu từ form
            $this->sinhVienModel->maSV = $_POST['maSV'];
            $this->sinhVienModel->hoTen = $_POST['hoTen'];
            $this->sinhVienModel->gioiTinh = $_POST['gioiTinh'];
            $this->sinhVienModel->ngaySinh = $_POST['ngaySinh'];
            $this->sinhVienModel->maNganh = $_POST['maNganh'];
            
            // Xử lý upload hình ảnh
            $this->sinhVienModel->hinh = '';
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $upload_dir = __DIR__ . '/../../public/uploads/';
                
                // Đảm bảo thư mục tồn tại
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $temp_name = $_FILES['hinh']['tmp_name'];
                $file_name = time() . '_' . $_FILES['hinh']['name'];
                
                if (move_uploaded_file($temp_name, $upload_dir . $file_name)) {
                    $this->sinhVienModel->hinh = 'public/uploads/' . $file_name;
                }
            }
            
            if ($this->sinhVienModel->create()) {
                // Chuyển hướng về trang danh sách
                header('Location: index.php?controller=sinhvien&action=index');
                exit;
            } else {
                echo "Lỗi: Không thể thêm sinh viên.";
            }
        }
    }
    
    /**
     * Hiển thị form sửa thông tin sinh viên
     * @param string $id Mã sinh viên
     */
    public function edit($id)
    {
        $sinhVien = $this->sinhVienModel->getByID($id);
        $nganhHocs = $this->nganhHocModel->getAllAsArray();
        
        // Load view form sửa sinh viên
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/sinhvien/edit.php';
    }
    
    /**
     * Xử lý cập nhật thông tin sinh viên từ form submit
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Gán dữ liệu từ form
            $this->sinhVienModel->maSV = $_POST['maSV'];
            $this->sinhVienModel->hoTen = $_POST['hoTen'];
            $this->sinhVienModel->gioiTinh = $_POST['gioiTinh'];
            $this->sinhVienModel->ngaySinh = $_POST['ngaySinh'];
            $this->sinhVienModel->maNganh = $_POST['maNganh'];
            
            // Giữ lại hình cũ nếu không upload hình mới
            $this->sinhVienModel->hinh = $_POST['hinhCu'];
            
            // Xử lý upload hình ảnh nếu có
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $upload_dir = __DIR__ . '/../../public/uploads/';
                
                // Đảm bảo thư mục tồn tại
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $temp_name = $_FILES['hinh']['tmp_name'];
                $file_name = time() . '_' . $_FILES['hinh']['name'];
                
                if (move_uploaded_file($temp_name, $upload_dir . $file_name)) {
                    $this->sinhVienModel->hinh = 'public/uploads/' . $file_name;
                }
            }
            
            if ($this->sinhVienModel->update()) {
                // Chuyển hướng về trang danh sách
                header('Location: index.php?controller=sinhvien&action=index');
                exit;
            } else {
                echo "Lỗi: Không thể cập nhật thông tin sinh viên.";
            }
        }
    }
    
    /**
     * Hiển thị trang xác nhận xóa sinh viên
     * @param string $id Mã sinh viên
     */
    public function showDelete($id)
    {
        $sinhVien = $this->sinhVienModel->getByID($id);
        
        // Load view xác nhận xóa
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/sinhvien/delete.php';
    }
    
    /**
     * Xử lý xóa sinh viên
     * @param string $id Mã sinh viên
     */
    public function delete($id)
    {
        if ($this->sinhVienModel->delete($id)) {
            // Chuyển hướng về trang danh sách
            header('Location: index.php?controller=sinhvien&action=index');
            exit;
        } else {
            echo "Lỗi: Không thể xóa sinh viên.";
        }
    }
    
    /**
     * Hiển thị thông tin chi tiết sinh viên
     * @param string $id Mã sinh viên
     */
    public function detail($id)
    {
        $sinhVien = $this->sinhVienModel->getByID($id);
        
        // Load view hiển thị chi tiết
        require_once __DIR__ . '/../views/layouts/main.php';
        require_once __DIR__ . '/../views/sinhvien/detail.php';
    }
}