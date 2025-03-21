<h2>ĐĂNG NHẬP</h2>

<form action="index.php?controller=login&action=login" method="post">
    <div class="form-group row">
        <label for="maSV" class="col-sm-2 col-form-label">Mã SV</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="maSV" name="maSV" required>
        </div>
    </div>
    
    <div class="form-group row mt-3">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
            <a href="index.php" class="btn btn-link">Back to List</a>
        </div>
    </div>
</form>