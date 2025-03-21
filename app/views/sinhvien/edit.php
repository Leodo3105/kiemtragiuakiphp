<h2>HIỆU CHỈNH THÔNG TIN SINH VIÊN</h2>


<form action="index.php?controller=sinhvien&action=update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($sinhVien['MaSV']); ?>">
    <input type="hidden" name="hinhCu" value="<?php echo htmlspecialchars($sinhVien['Hinh']); ?>">
    
    <div class="form-group row">
        <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
        <div class="col-sm-4">
            <select class="form-control" id="gioiTinh" name="gioiTinh">
                <option value="Nam" <?php echo ($sinhVien['GioiTinh'] == 'Nam' ? 'selected' : ''); ?>>Nam</option>
                <option value="Nữ" <?php echo ($sinhVien['GioiTinh'] == 'Nữ' ? 'selected' : ''); ?>>Nữ</option>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" 
                   value="<?php echo date('Y-m-d', strtotime($sinhVien['NgaySinh'])); ?>">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="hinh" class="col-sm-2 col-form-label">Hình</label>
        <div class="col-sm-4">
            <input type="file" class="form-control-file" id="hinh" name="hinh">
            <?php if(!empty($sinhVien['Hinh'])): ?>
                <div class="mt-2">
                    <img src="<?php echo htmlspecialchars($sinhVien['Hinh']); ?>" alt="<?php echo htmlspecialchars($sinhVien['HoTen']); ?>" class="student-img">
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="maNganh" class="col-sm-2 col-form-label">Mã Ngành</label>
        <div class="col-sm-4">
            <select class="form-control" id="maNganh" name="maNganh">
                <?php foreach ($nganhHocs as $ma => $ten): ?>
                    <option value="<?php echo htmlspecialchars($ma); ?>" <?php echo ($ma == $sinhVien['MaNganh']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($ten); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php?controller=sinhvien&action=index" class="btn btn-link">Back to List</a>
        </div>
    </div>
</form>