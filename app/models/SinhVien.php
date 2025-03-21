<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Class SinhVien - Model xử lý dữ liệu sinh viên
 */
class SinhVien
{
    private $conn;
    private $table = 'SinhVien';

    // Thuộc tính đối tượng sinh viên
    public $maSV;
    public $hoTen;
    public $gioiTinh;
    public $ngaySinh;
    public $hinh;
    public $maNganh;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Lấy danh sách tất cả sinh viên
     * @return array
     */
    public function getAll()
    {
        try {
            // Truy vấn chính
            $query = "SELECT sv.*, ng.TenNganh FROM {$this->table} sv 
                    LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh";
            
            $result = $this->conn->query($query);
            
            if (!$result) {
                error_log("Lỗi truy vấn SQL: " . $this->conn->error);
                return [];
            }
            
            $list = [];
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $list[] = $row;
                }
            }
            
            return $list;
        } catch (Exception $e) {
            error_log("Exception trong getAll(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy thông tin một sinh viên theo mã
     * @param string $maSV
     * @return array|null
     */
    public function getByID($maSV)
    {
        try {
            $query = "SELECT sv.*, ng.TenNganh FROM {$this->table} sv 
                    LEFT JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh 
                    WHERE sv.MaSV = ?";
            
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi chuẩn bị câu lệnh: " . $this->conn->error);
                return null;
            }
            
            $stmt->bind_param("s", $maSV);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Exception trong getByID(): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Thêm sinh viên mới
     * @return bool
     */
    public function create()
    {
        try {
            $query = "INSERT INTO {$this->table} (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi chuẩn bị câu lệnh Insert: " . $this->conn->error);
                return false;
            }
            
            $stmt->bind_param("ssssss", 
                $this->maSV, 
                $this->hoTen, 
                $this->gioiTinh, 
                $this->ngaySinh,
                $this->hinh,
                $this->maNganh
            );
            
            if ($stmt->execute()) {
                return true;
            }
            
            error_log("Lỗi thực thi Insert: " . $stmt->error);
            return false;
        } catch (Exception $e) {
            error_log("Exception trong create(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật thông tin sinh viên
     * @return bool
     */
    public function update()
    {
        try {
            $query = "UPDATE {$this->table} 
                    SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? 
                    WHERE MaSV = ?";
            
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi chuẩn bị câu lệnh Update: " . $this->conn->error);
                return false;
            }
            
            $stmt->bind_param("ssssss", 
                $this->hoTen, 
                $this->gioiTinh, 
                $this->ngaySinh,
                $this->hinh,
                $this->maNganh,
                $this->maSV
            );
            
            if ($stmt->execute()) {
                return true;
            }
            
            error_log("Lỗi thực thi Update: " . $stmt->error);
            return false;
        } catch (Exception $e) {
            error_log("Exception trong update(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa một sinh viên
     * @param string $maSV
     * @return bool
     */
    public function delete($maSV)
    {
        try {
            // Trước khi xóa sinh viên, cần xóa các bản ghi liên quan trong bảng DangKy
            $query_find_dk = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
            $stmt_find = $this->conn->prepare($query_find_dk);
            if (!$stmt_find) {
                error_log("Lỗi chuẩn bị câu lệnh tìm MaDK: " . $this->conn->error);
                return false;
            }
            
            $stmt_find->bind_param("s", $maSV);
            $stmt_find->execute();
            $result_dk = $stmt_find->get_result();
            
            if ($result_dk->num_rows > 0) {
                while ($row_dk = $result_dk->fetch_assoc()) {
                    $maDK = $row_dk['MaDK'];
                    
                    // Xóa bản ghi trong ChiTietDangKy
                    $query_delete_ctdk = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
                    $stmt_ctdk = $this->conn->prepare($query_delete_ctdk);
                    if ($stmt_ctdk) {
                        $stmt_ctdk->bind_param("i", $maDK);
                        $stmt_ctdk->execute();
                    }
                }
                
                // Xóa bản ghi trong DangKy
                $query_delete_dk = "DELETE FROM DangKy WHERE MaSV = ?";
                $stmt_dk = $this->conn->prepare($query_delete_dk);
                if ($stmt_dk) {
                    $stmt_dk->bind_param("s", $maSV);
                    $stmt_dk->execute();
                }
            }
            
            // Xóa sinh viên
            $query = "DELETE FROM {$this->table} WHERE MaSV = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi chuẩn bị câu lệnh Delete: " . $this->conn->error);
                return false;
            }
            
            $stmt->bind_param("s", $maSV);
            
            if ($stmt->execute()) {
                return true;
            }
            
            error_log("Lỗi thực thi Delete: " . $stmt->error);
            return false;
        } catch (Exception $e) {
            error_log("Exception trong delete(): " . $e->getMessage());
            return false;
        }
    }
}