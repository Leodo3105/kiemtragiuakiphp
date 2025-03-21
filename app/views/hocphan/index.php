<h2>DANH SÁCH HỌC PHẦN</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Số lượng dự kiến</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($hocPhans)): ?>
            <?php foreach ($hocPhans as $hp): ?>
                <tr>
                    <td><?php echo htmlspecialchars($hp['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($hp['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($hp['SoTinChi']); ?></td>
                    <td>
                        <?php 
                        // Hiển thị số lượng dự kiến nếu có
                        echo isset($hp['SoLuongDuKien']) ? htmlspecialchars($hp['SoLuongDuKien']) : '50'; 
                        ?>
                    </td>
                    <td>
                        <a href="index.php?controller=hocphan&action=dangKy&id=<?php echo htmlspecialchars($hp['MaHP']); ?>" class="btn btn-success btn-sm">Đăng Ký</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Không có học phần nào</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>