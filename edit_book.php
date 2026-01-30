<?php
include "connect.php";

if (!isset($_GET['id'])) {
    header("location: index.php");
    exit;
}
$id = $_GET['id'];
$sql = "SELECT * FROM book WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


if (!$row) {
    echo "Book not found!";
    exit;
}




session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("location: login.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$current_user_role = $_SESSION['role'] ?? 'user';

if ($current_user_role !== 'admin') {
    echo "<script>alert('ไม่มีสิทธิ์แก้ไขหนังสือ (สำหรับผู้ดูแลระบบเท่านั้น)'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลหนังสือ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-custom">
                    <h3 class="card-title text-center mb-4"><i class="bi bi-pencil-square"></i> แก้ไขข้อมูลหนังสือ</h3>

                    <form action="update_book.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="old_file_path" value="<?= $row['file_path']; ?>">
                        <input type="hidden" name="old_cover_image" value="<?= $row['cover_image'] ?? ''; ?>">

                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="title" name="title" placeholder="ชื่อหนังสือ"
                                required value="<?= htmlspecialchars($row['title']); ?>"
                                style="background-color: #2c2c2c; color: white; border: 1px solid #444;">
                            <label for="title" style="color: #bbb;">ชื่อหนังสือ</label>
                        </div>

                        <div class="form-floating mb-4">
                            <select class="form-select" id="category" name="category" required
                                style="background-color: #2c2c2c; color: white; border: 1px solid #444;"
                                style="background-color: #2c2c2c; color: white; border: 1px solid #444;">
                                <option value="novel" <?= $row['category'] == 'novel' ? 'selected' : ''; ?>>นิยาย (Novel)
                                </option>
                                <option value="comic" <?= $row['category'] == 'comic' ? 'selected' : ''; ?>>การ์ตูน
                                    (Comic)</option>
                            </select>
                            <label for="category" style="color: #bbb;">หมวดหมู่</label>
                        </div>

                        <div class="mb-4">
                            <label for="cover_image" class="form-label" style="color: #bbb;">เปลี่ยนรูปปกหนังสือ
                                (เฉพาะไฟล์รูปภาพ)</label>
                            <input class="form-control" type="file" id="cover_image" name="cover_image" accept="image/*"
                                style="background-color: #2c2c2c; color: white; border: 1px solid #444;">
                            <?php if (!empty($row['cover_image'])): ?>
                                <div class="mt-2 text-center">
                                    <small class="d-block text-muted mb-1">รูปปัจจุบัน:</small>
                                    <img src="<?= htmlspecialchars($row['cover_image']); ?>" alt="Current Cover"
                                        class="img-thumbnail"
                                        style="max-height: 150px; background-color: #2c2c2c; border-color: #444;">
                                </div>
                            <?php endif; ?>
                        </div>

                        

                        <div class="form-floating mb-4">
                            <textarea class="form-control" id="description" name="description"
                                placeholder="รายละเอียดหนังสือ"
                                style="height: 100px; background-color: #2c2c2c; color: white; border: 1px solid #444;"><?= htmlspecialchars($row['description'] ?? ''); ?></textarea>
                            <label for="description" style="color: #bbb;">รายละเอียดหนังสือ</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="number" class="form-control" id="borrow_duration" name="borrow_duration"
                                placeholder="จำนวนวันที่ยืมได้" required value="<?= $row['borrow_duration']; ?>" min="1"
                                style="background-color: #2c2c2c; color: white; border: 1px solid #444;">
                            <label for="borrow_duration" style="color: #bbb;">จำนวนวันที่ยืมได้ (วัน)</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom py-2">บันทึกการแก้ไข</button>
                            <a href="index.php" class="btn btn-outline-secondary py-2">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>