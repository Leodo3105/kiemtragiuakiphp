<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Class HocPhan - Model xử lý dữ liệu học phần
 */
class HocPhan
{
    private $conn;
    private $table = 'HocPhan';
    private $table_dangky = 'DangKy';
    private $table_chitiet = 'ChiTietDangKy';

    // Thuộc tính đối tượng học phần
    public $maHP;
    public $tenHP;
    public $soTinChi;
    public $soLuongDuKien;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Lấy danh sách tất cả học phần
     * @return array
     */
    public function getAll()
    {
        try {
            // Thêm cột SoLuongDangKy từ bảng ChiTietDangKy
            $query = "SELECT hp.*, 
                      (SELECT COUNT(*) FROM {$this->table_chitiet} ctdk WHERE ctdk.MaHP = hp.MaHP) as SoLuongDaDangKy,
                      hp.SoLuongDuKien - (SELECT COUNT(*) FROM {$this->table_chitiet} ctdk WHERE ctdk.MaHP = hp.MaHP) as SoLuongConLai
                      FROM {$this->table} hp";
            
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
     * Lấy thông tin một học phần theo mã
     * @param string $maHP
     * @return array|null
     */
    public function getByID($maHP)
    {
        try {
            $query = "SELECT hp.*,
                      (SELECT COUNT(*) FROM {$this->table_chitiet} ctdk WHERE ctdk.MaHP = hp.MaHP) as SoLuongDaDangKy,
                      hp.SoLuongDuKien - (SELECT COUNT(*) FROM {$this->table_chitiet} ctdk WHERE ctdk.MaHP = hp.MaHP) as SoLuongConLai
                      FROM {$this->table} hp
                      WHERE hp.MaHP = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $maHP);
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
     * Kiểm tra sinh viên đã đăng ký học phần này chưa
     * @param string $maSV
     * @param string $maHP
     * @return bool
     */
    public function checkDangKy($maSV, $maHP)
    {
        try {
            $query = "SELECT ctdk.* FROM {$this->table_chitiet} ctdk
                      JOIN {$this->table_dangky} dk ON ctdk.MaDK = dk.MaDK
                      WHERE dk.MaSV = ? AND ctdk.MaHP = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $maSV, $maHP);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Exception trong checkDangKy(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Thực hiện đăng ký học phần
     * @param string $maSV
     * @param string $maHP
     * @param string $ngayDK
     * @return bool
     */
    public function dangKy($maSV, $maHP, $ngayDK)
    {
        try {
            // Bắt đầu transaction
            $this->conn->begin_transaction();

            // Kiểm tra xem sinh viên đã có đăng ký nào chưa
            $query_check = "SELECT MaDK FROM {$this->table_dangky} WHERE MaSV = ?";
            $stmt_check = $this->conn->prepare($query_check);
            $stmt_check->bind_param("s", $maSV);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            $maDK = null;
            
            if ($result_check->num_rows > 0) {
                // Sinh viên đã có đăng ký, lấy mã đăng ký
                $row = $result_check->fetch_assoc();
                $maDK = $row['MaDK'];
            } else {
                // Sinh viên chưa có đăng ký, tạo mới
                $query_insert_dk = "INSERT INTO {$this->table_dangky} (NgayDK, MaSV) VALUES (?, ?)";
                $stmt_insert_dk = $this->conn->prepare($query_insert_dk);
                $stmt_insert_dk->bind_param("ss", $ngayDK, $maSV);
                
                if (!$stmt_insert_dk->execute()) {
                    $this->conn->rollback();
                    error_log("Lỗi tạo đăng ký: " . $stmt_insert_dk->error);
                    return false;
                }
                
                $maDK = $this->conn->insert_id;
            }

            // Thêm chi tiết đăng ký
            $query_insert_ctdk = "INSERT INTO {$this->table_chitiet} (MaDK, MaHP) VALUES (?, ?)";
            $stmt_insert_ctdk = $this->conn->prepare($query_insert_ctdk);
            $stmt_insert_ctdk->bind_param("is", $maDK, $maHP);
            
            if (!$stmt_insert_ctdk->execute()) {
                $this->conn->rollback();
                error_log("Lỗi thêm chi tiết đăng ký: " . $stmt_insert_ctdk->error);
                return false;
            }

            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Exception trong dangKy(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật số lượng đăng ký của học phần
     * @param string $maHP
     * @return bool
     */
    public function updateSoLuongDangKy($maHP)
    {
        try {
            // Cập nhật số lượng đăng ký dựa trên bảng ChiTietDangKy
            $query = "UPDATE {$this->table} SET SoLuongDangKy = 
                     (SELECT COUNT(*) FROM {$this->table_chitiet} ctdk WHERE ctdk.MaHP = ?)
                     WHERE MaHP = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $maHP, $maHP);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Exception trong updateSoLuongDangKy(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Thêm cột SoLuongDuKien vào bảng HocPhan nếu chưa có
     */
    public function addSoLuongDuKienColumn()
    {
        try {
            // Kiểm tra xem cột đã tồn tại chưa
            $query_check = "SHOW COLUMNS FROM {$this->table} LIKE 'SoLuongDuKien'";
            $result = $this->conn->query($query_check);
            
            if ($result->num_rows == 0) {
                // Thêm cột nếu chưa tồn tại
                $query_add = "ALTER TABLE {$this->table} ADD COLUMN SoLuongDuKien INT DEFAULT 50";
                $this->conn->query($query_add);
                
                // Cập nhật giá trị mặc định
                $query_update = "UPDATE {$this->table} SET SoLuongDuKien = 50 WHERE SoLuongDuKien IS NULL";
                $this->conn->query($query_update);
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Exception trong addSoLuongDuKienColumn(): " . $e->getMessage());
            return false;
        }
    }
}