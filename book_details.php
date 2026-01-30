<?php
include "connect.php";
session_start();
include_once "lang_config.php";

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
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($book['title']); ?> - <?= __('book_details_page_title') ?>
    </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h2 class="text-white fw-bold"><i class="bi bi-book"></i>
                            <?= htmlspecialchars($book['title']); ?>
                        </h2>
                        <span class="badge bg-secondary fs-6">
                            <?= $book['category'] == 'novel' ? __('novel') : ($book['category'] == 'comic' ? __('comic') : htmlspecialchars($book['category'])) ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <?php if (!empty($book['cover_image'])): ?>
                            <div class="mb-3 text-center">
                                <img src="<?= $book['cover_image']; ?>" alt="Cover Image"
                                    class="img-fluid rounded shadow-lg" style="max-height: 400px; max-width: 100%;">
                            </div>
                        <?php endif; ?>

                        <h5 class="text-warning mb-3"><?= __('details_header') ?></h5>
                        <div class="p-3 rounded"
                            style="background-color: #2c2c2c; border: 1px solid #444; color: #e0e0e0; min-height: 100px;">
                            <?= nl2br(htmlspecialchars($book['description'] ?? __('no_desc'))); ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-light"><i class="bi bi-clock-history text-info"></i>
                                <strong><?= __('borrow_duration_label') ?></strong>
                                <?= $book['borrow_duration']; ?> <?= __('days') ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-light">
                                <i class="bi bi-info-circle text-info"></i> <strong><?= __('status_label') ?></strong>
                                <?php if ($book['status'] == '0'): ?>
                                    <span
                                        class="badg bg-success text-white px-2 py-1 rounded"><?= __('status_available') ?></span>
                                <?php else:
                                    $borrowed_at = $book['borrowed_at'];
                                    $duration = $book['borrow_duration'];
                                    $due_time = strtotime($borrowed_at . " + $duration days");
                                    $due_date_str = date('d/m/Y', $due_time);
                                    ?>
                                    <span class="badge bg-danger text-white"><?= __('status_borrowed') ?></span>
                                    <span class="small text-muted ms-2"><?= __('return_due') ?>
                                        <?= $due_date_str; ?>
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <hr class="border-secondary mb-4">

                    <?php if ($book['status'] != '0' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div class="mb-4">
                            <h5 class="text-danger"><i class="bi bi-geo-alt-fill"></i> <?= __('delivery_address') ?></h5>
                            <div class="p-3 bg-dark rounded border border-secondary">
                                <p><strong><?= __('address_label') ?></strong>
                                    <?= htmlspecialchars($book['delivery_address'] ?? 'ไม่ระบุ') ?>
                                </p>

                                <?php if (!empty($book['delivery_lat']) && !empty($book['delivery_lng'])): ?>
                                    <div id="admin-map" style="height: 300px; width: 100%; border-radius: 8px;"></div>
                                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            var adminMap = L.map('admin-map').setView([<?= $book['delivery_lat'] ?>, <?= $book['delivery_lng'] ?>], 15);
                                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                attribution: 'OpenStreetMap'
                                            }).addTo(adminMap);
                                            L.marker([<?= $book['delivery_lat'] ?>, <?= $book['delivery_lng'] ?>]).addTo(adminMap)
                                                .bindPopup("<?= __('delivery_point') ?>").openPopup();
                                        });
                                    </script>
                                <?php else: ?>
                                    <p class="text-muted"><?= __('no_map') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex gap-2">
                        <?php if ($book['status'] == '0'): ?>
                            <?php if (isset($_SESSION['is_logged_in'])): ?>
                                <a href="confirm_borrow.php?id=<?= $book['id']; ?>" class="btn btn-primary-custom flex-grow-1">
                                    <i class="bi bi-bag-plus"></i> <?= __('btn_borrow_full') ?>
                                </a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary-custom flex-grow-1">
                                    <i class="bi bi-box-arrow-in-right"></i> <?= __('btn_login_borrow') ?>
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (isset($_SESSION['is_logged_in'])): ?>
                                <a href="return.php?id=<?= $book['id']; ?>" class="btn btn-outline-warning flex-grow-1"
                                    onclick="return confirm('<?= __('confirm_return') ?>')">
                                    <i class="bi bi-arrow-return-left"></i> <?= __('btn_return_full') ?>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary flex-grow-1" disabled><?= __('status_unavailable') ?></button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php
                        
                        $can_edit = false;
                        if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
                            if ($_SESSION['role'] === 'admin') {
                                $can_edit = true;
                            }
                        }
                        ?>
                        <?php if ($can_edit): ?>
                            <a href="edit_book.php?id=<?= $book['id']; ?>" class="btn btn-outline-info">
                                <i class="bi bi-pencil"></i> <?= __('btn_edit') ?>
                            </a>
                            <a href="delete_book.php?id=<?= $book['id']; ?>" class="btn btn-outline-danger"
                                onclick="return confirm('<?= __('confirm_delete') ?>');">
                                <i class="bi bi-trash"></i> <?= __('btn_delete') ?>
                            </a>
                        <?php endif; ?>

                        <a href="index.php" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left"></i> <?= __('btn_back') ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>