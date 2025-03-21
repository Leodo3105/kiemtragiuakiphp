<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Class NganhHoc - Model xử lý dữ liệu ngành học
 */
class NganhHoc
{
    private $conn;
    private $table = 'NganhHoc';

    // Thuộc tính đối tượng ngành học
    public $maNganh;
    public $tenNganh;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Lấy danh sách tất cả ngành học
     * @return array
     */
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($query);
        $list = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
        }
        
        return $list;
    }

    /**
     * Lấy danh sách ngành học dưới dạng mảng kết hợp mã => tên
     * @return array
     */
    public function getAllAsArray()
    {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($query);
        $list = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $list[$row['MaNganh']] = $row['TenNganh'];
            }
        }
        
        return $list;
    }

    /**
     * Lấy thông tin một ngành học theo mã
     * @param string $maNganh
     * @return array|null
     */
    public function getByID($maNganh)
    {
        $query = "SELECT * FROM {$this->table} WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $maNganh);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}