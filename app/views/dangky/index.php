<h2>Đăng Kí Học Phần</h2>

<?php
// Lấy tổng số tín chỉ
$tongSoTinChi = 0;
foreach ($chiTietDangKy as $ct) {
    $tongSoTinChi += $ct['SoTinChi'];
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã HP</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($chiTietDangKy)): ?>
            <?php foreach ($chiTietDangKy as $ct): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ct['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($ct['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($ct['SoTinChi']); ?></td>
                    <td>
                        <a href="index.php?controller=dangky&action=delete&id=<?php echo htmlspecialchars($ct['MaHP']); ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Chưa đăng ký học phần nào</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right"><strong>Số học phần: <?php echo count($chiTietDangKy); ?></strong></td>
            <td colspan="2"><strong>Tổng số tín chỉ: <?php echo $tongSoTinChi; ?></strong></td>
        </tr>
    </tfoot>
</table>

<?php if (!empty($chiTietDangKy)): ?>
    <div class="mb-3">
        <a href="index.php?controller=dangky&action=deleteAll" class="btn btn-danger">Xóa Đăng Ký</a>
        <a href="index.php?controller=dangky&action=save" class="btn btn-success">Lưu đăng ký</a>
    </div>
<?php endif; ?>

<div class="mt-4">
    <h4>Thông tin Đăng kí</h4>
    
    <p><strong>Mã số sinh viên:</strong> <?php echo htmlspecialchars($sinhVien['MaSV']); ?></p>
    <p><strong>Họ Tên Sinh Viên:</strong> <?php echo htmlspecialchars($sinhVien['HoTen']); ?></p>
    <p><strong>Ngày Sinh:</strong> <?php echo date('d/m/Y', strtotime($sinhVien['NgaySinh'])); ?></p>
    <p><strong>Ngành Học:</strong> <?php echo htmlspecialchars($sinhVien['MaNganh']); ?></p>
    
    <?php if (!empty($dangKy)): ?>
        <p><strong>Ngày Đăng Kí:</strong> <?php echo date('d/m/Y', strtotime($dangKy['NgayDK'])); ?></p>
    <?php endif; ?>
    
    <a href="index.php?controller=hocphan&action=index" class="btn btn-primary">Trở về</a>
</div>