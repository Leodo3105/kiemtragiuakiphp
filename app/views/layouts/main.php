<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test1 - Quản lý sinh viên</title>
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
        .student-img {
            max-width: 100px;
            height: auto;
        }
        .action-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="index.php">Test1</a>
                    <a href="index.php?controller=sinhvien&action=index">Sinh Viên</a>
                    <a href="#">Học Phần</a>
                    <a href="#">Đăng Ký</a>
                    <a href="#">Đăng Nhập</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Nội dung trang sẽ được chèn ở đây -->
        <?php if (isset($content)) echo $content; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>