<?php
// Thêm debug để kiểm tra dữ liệu
//echo "<!-- DEBUG: " . (empty($sinhViens) ? "Không có sinh viên" : "Có " . count($sinhViens) . " sinh viên") . " -->";
?>

<h2>TRANG SINH VIÊN</h2>
<p>Danh sách sinh viên</p>

<div class="mb-3">
    <a href="index.php?controller=sinhvien&action=create" class="btn btn-success">Thêm Sinh Viên</a>
</div>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Mã Ngành</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($sinhViens)): ?>
            <?php foreach ($sinhViens as $sv): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sv['MaSV']); ?></td>
                    <td><?php echo htmlspecialchars($sv['HoTen']); ?></td>
                    <td><?php echo htmlspecialchars($sv['GioiTinh']); ?></td>
                    <td><?php echo date('d/m/Y H:i:s A', strtotime($sv['NgaySinh'])); ?></td>
                    <td>
                        <?php if (!empty($sv['Hinh'])): ?>
                            <img src="/kiemtragk/<?php echo htmlspecialchars($sv['Hinh']); ?>" alt="<?php echo htmlspecialchars($sv['HoTen']); ?>" class="student-img">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($sv['TenNganh']); ?></td>
                    <td class="action-links">
                        <a href="index.php?controller=sinhvien&action=edit&id=<?php echo htmlspecialchars($sv['MaSV']); ?>">Edit</a> |
                        <a href="index.php?controller=sinhvien&action=detail&id=<?php echo htmlspecialchars($sv['MaSV']); ?>">Details</a> |
                        <a href="index.php?controller=sinhvien&action=showDelete&id=<?php echo htmlspecialchars($sv['MaSV']); ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Không có dữ liệu sinh viên</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>