<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test1 - Quản lý sinh viên và học phần</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .header {
            background-color: #222;
            color: white;
            padding: 10px 0;
        }
        .header a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .header a:hover {
            color: #ccc;
        }
        .header a.active {
            font-weight: bold;
            color: #fff;
            text-decoration: underline;
        }
        .student-img {
            max-width: 100px;
            height: auto;
        }
        .action-links a {
            margin-right: 10px;
        }
        .user-info {
            color: #fff;
            margin-left: 20px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="index.php" <?php if(!isset($_GET['controller']) || $_GET['controller'] == 'sinhvien' && (!isset($_GET['action']) || $_GET['action'] == 'index')) echo 'class="active"'; ?>>Test1</a>
                    <a href="index.php?controller=sinhvien&action=index" <?php if(isset($_GET['controller']) && $_GET['controller'] == 'sinhvien' && (!isset($_GET['action']) || $_GET['action'] == 'index')) echo 'class="active"'; ?>>Sinh Viên</a>
                    <a href="index.php?controller=hocphan&action=index" <?php if(isset($_GET['controller']) && $_GET['controller'] == 'hocphan') echo 'class="active"'; ?>>Học Phần</a>
                    <a href="index.php?controller=dangky&action=index" <?php if(isset($_GET['controller']) && $_GET['controller'] == 'dangky') echo 'class="active"'; ?>>Đăng Ký</a>
                    
                    <?php if(isset($_SESSION['maSV'])): ?>
                        <div class="float-right user-info">
                            <?php echo htmlspecialchars($_SESSION['hoTen'] ?? $_SESSION['maSV']); ?> |
                            <a href="index.php?controller=login&action=logout" style="margin-left: 10px;">Đăng Xuất</a>
                        </div>
                    <?php else: ?>
                        <a href="index.php?controller=login&action=index" class="float-right <?php if(isset($_GET['controller']) && $_GET['controller'] == 'login') echo 'active'; ?>">Đăng Nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Nội dung trang sẽ được nhúng vào đây -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>