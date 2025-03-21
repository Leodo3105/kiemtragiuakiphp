<h2>THÊM SINH VIÊN</h2>
<p>Sinh Viên</p>

<form action="index.php?controller=sinhvien&action=store" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <label for="maSV" class="col-sm-2 col-form-label">Mã SV</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="maSV" name="maSV" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="hoTen" name="hoTen" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
        <div class="col-sm-4">
            <select class="form-control" id="gioiTinh" name="gioiTinh">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="hinh" class="col-sm-2 col-form-label">Hình</label>
        <div class="col-sm-4">
            <input type="file" class="form-control-file" id="hinh" name="hinh">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="maNganh" class="col-sm-2 col-form-label">Mã Ngành</label>
        <div class="col-sm-4">
            <select class="form-control" id="maNganh" name="maNganh">
                <?php foreach ($nganhHocs as $ma => $ten): ?>
                    <option value="<?php echo htmlspecialchars($ma); ?>"><?php echo htmlspecialchars($ten); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="index.php?controller=sinhvien&action=index" class="btn btn-link">Back to List</a>
        </div>
    </div>
</form>