<?php
/**
 * Điểm khởi đầu của ứng dụng
 * Xử lý định tuyến và khởi tạo controller tương ứng
 */

// Khởi tạo session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Tạo autoloader đơn giản
spl_autoload_register(function ($class_name) {
    // Tìm kiếm file class trong thư mục app
    $dirs = [
        'app/models/',
        'app/controllers/',
        'app/config/'
    ];
    
    foreach ($dirs as $dir) {
        $file = $dir . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Lấy tham số controller và action từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'sinhvien';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Khởi tạo controller tương ứng
switch ($controller) {
    case 'sinhvien':
        require_once 'app/controllers/SinhVienController.php';
        $controller = new SinhVienController();
        
        // Gọi action tương ứng
        switch ($action) {
            case 'index':
                $controller->index();
                break;
                
            case 'create':
                $controller->create();
                break;
                
            case 'store':
                $controller->store();
                break;
                
            case 'edit':
                $controller->edit($id);
                break;
                
            case 'update':
                $controller->update();
                break;
                
            case 'showDelete':
                $controller->showDelete($id);
                break;
                
            case 'delete':
                $controller->delete($id);
                break;
                
            case 'detail':
                $controller->detail($id);
                break;
                
            default:
                // Mặc định hiển thị danh sách
                $controller->index();
                break;
        }
        break;
        
    case 'hocphan':
        require_once 'app/controllers/HocPhanController.php';
        $controller = new HocPhanController();
        
        // Gọi action tương ứng
        switch ($action) {
            case 'index':
                $controller->index();
                break;
                
            case 'dangKy':
                $controller->dangKy($id);
                break;
                
            default:
                // Mặc định hiển thị danh sách
                $controller->index();
                break;
        }
        break;
        
    case 'login':
        require_once 'app/controllers/LoginController.php';
        $controller = new LoginController();
        
        // Gọi action tương ứng
        switch ($action) {
            case 'index':
                $controller->index();
                break;
                
            case 'login':
                $controller->login();
                break;
                
            case 'logout':
                $controller->logout();
                break;
                
            default:
                // Mặc định hiển thị form đăng nhập
                $controller->index();
                break;
        }
        break;
        
    case 'dangky':
        require_once 'app/controllers/DangKyController.php';
        $controller = new DangKyController();
        
        // Gọi action tương ứng
        switch ($action) {
            case 'index':
                $controller->index();
                break;
                
            case 'delete':
                $controller->delete($id);
                break;
                
            case 'deleteAll':
                $controller->deleteAll();
                break;
                
            case 'save':
                $controller->save();
                break;
                
            default:
                // Mặc định hiển thị danh sách đăng ký
                $controller->index();
                break;
        }
        break;
        
    default:
        // Mặc định xử lý controller SinhVien
        require_once 'app/controllers/SinhVienController.php';
        $controller = new SinhVienController();
        $controller->index();
        break;
}