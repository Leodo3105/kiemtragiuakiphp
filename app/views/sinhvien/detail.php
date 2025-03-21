<h2>THÔNG TIN CHI TIẾT</h2>
<div>
    <h5>Sinh Viên</h5>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($sinhVien['MaSV']); ?></p>
                <p><strong>Họ Tên:</strong> <?php echo htmlspecialchars($sinhVien['HoTen']); ?></p>
                <p><strong>Giới Tính:</strong> <?php echo htmlspecialchars($sinhVien['GioiTinh']); ?></p>
                <p><strong>Ngày Sinh:</strong> <?php echo date('d/m/Y H:i:s A', strtotime($sinhVien['NgaySinh'])); ?></p>
                <p><strong>Mã Ngành:</strong> <?php echo htmlspecialchars($sinhVien['MaNganh']); ?> - <?php echo htmlspecialchars($sinhVien['TenNganh']); ?></p>
            </div>
            
            <?php if (!empty($sinhVien['Hinh'])): ?>
                <div class="col-md-6">
                    <p><strong>Hình:</strong></p>
                    <img src="<?php echo htmlspecialchars($sinhVien['Hinh']); ?>" alt="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" style="max-width: 200px;">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="form-group">
    <a href="index.php?controller=sinhvien&action=edit&id=<?php echo htmlspecialchars($sinhVien['MaSV']); ?>" class="btn btn-primary">Edit</a>
    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Back to List</a>
</div>