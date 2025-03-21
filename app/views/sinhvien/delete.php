<h2>XÓA THÔNG TIN</h2>
<div class="alert alert-danger">
    Are you sure you want to delete this?
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($sinhVien['HoTen']); ?></h5>
        <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($sinhVien['MaSV']); ?></p>
        <p><strong>Giới Tính:</strong> <?php echo htmlspecialchars($sinhVien['GioiTinh']); ?></p>
        <p><strong>Ngày Sinh:</strong> <?php echo date('d/m/Y H:i:s A', strtotime($sinhVien['NgaySinh'])); ?></p>
        
        <?php if (!empty($sinhVien['Hinh'])): ?>
            <p><strong>Hình:</strong></p>
            <img src="<?php echo htmlspecialchars($sinhVien['Hinh']); ?>" alt="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" class="student-img mb-2">
        <?php endif; ?>
        
        <p><strong>Mã Ngành:</strong> <?php echo htmlspecialchars($sinhVien['MaNganh']); ?> - <?php echo htmlspecialchars($sinhVien['TenNganh']); ?></p>
    </div>
</div>

<div class="form-group">
    <a href="index.php?controller=sinhvien&action=delete&id=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" class="btn btn-danger">Delete</a>
    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Back to List</a>
</div>