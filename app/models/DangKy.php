<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Class DangKy - Model xử lý dữ liệu đăng ký học phần
 */
class DangKy
{
    private $conn;
    private $table = 'DangKy';
    private $table_chitiet = 'ChiTietDangKy';
    private $table_hocphan = 'HocPhan';

    // Thuộc tính đối tượng đăng ký
    public $maDK;
    public $ngayDK;
    public $maSV;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Lấy thông tin đăng ký theo mã sinh viên
     * @param string $maSV
     * @return array|null
     */
    public function getByMaSV($maSV)
    {
        try {
            $query = "SELECT * FROM {$this->table} WHERE MaSV = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $maSV);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Exception trong getByMaSV(): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy danh sách chi tiết đăng ký
     * @param int $maDK
     * @return array
     */
    public function getChiTietDangKy($maDK)
    {
        try {
            if (!$maDK) {
                return [];
            }
            
            $query = "SELECT ctdk.*, hp.TenHP, hp.SoTinChi 
                      FROM {$this->table_chitiet} ctdk
                      JOIN {$this->table_hocphan} hp ON ctdk.MaHP = hp.MaHP
                      WHERE ctdk.MaDK = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $maDK);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $list = [];
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $list[] = $row;
                }
            }
            
            return $list;
        } catch (Exception $e) {
            error_log("Exception trong getChiTietDangKy(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Xóa chi tiết đăng ký
     * @param int $maDK
     * @param string $maHP
     * @return bool
     */
    public function deleteChiTietDangKy($maDK, $maHP)
    {
        try {
            $query = "DELETE FROM {$this->table_chitiet} WHERE MaDK = ? AND MaHP = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("is", $maDK, $maHP);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Exception trong deleteChiTietDangKy(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa tất cả chi tiết đăng ký
     * @param int $maDK
     * @return bool
     */
    public function deleteAllChiTietDangKy($maDK)
    {
        try {
            $query = "DELETE FROM {$this->table_chitiet} WHERE MaDK = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $maDK);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Exception trong deleteAllChiTietDangKy(): " . $e->getMessage());
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
            $query = "UPDATE {$this->table_hocphan} SET SoLuongDangKy = 
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
     * Cập nhật ngày đăng ký
     * @param string $maSV
     * @return bool
     */
    public function updateNgayDangKy($maSV)
    {
        try {
            $ngayDK = date('Y-m-d');
            
            $query = "UPDATE {$this->table} SET NgayDK = ? WHERE MaSV = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $ngayDK, $maSV);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Exception trong updateNgayDangKy(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tổng số tín chỉ đã đăng ký
     * @param int $maDK
     * @return int
     */
    public function getTongSoTinChi($maDK)
    {
        try {
            if (!$maDK) {
                return 0;
            }
            
            $query = "SELECT SUM(hp.SoTinChi) as TongSoTinChi
                      FROM {$this->table_chitiet} ctdk
                      JOIN {$this->table_hocphan} hp ON ctdk.MaHP = hp.MaHP
                      WHERE ctdk.MaDK = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $maDK);
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['TongSoTinChi'] ?? 0;
            }
            
            return 0;
        } catch (Exception $e) {
            error_log("Exception trong getTongSoTinChi(): " . $e->getMessage());
            return 0;
        }
    }
}