<?php
session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit();
}

include_once "lang_config.php";

$role = $_SESSION['role'] ?? 'user';
if ($role !== 'admin' && $role !== 'writer') {
    echo "<script>alert('" . __('unauthorized_add') . "'); window.location='index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('add_book_title') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="style.css">
    <script>
        
        const theme = localStorage.getItem('theme');
        if (theme === 'light') {
            document.body.classList.add('light-mode');
        }
    </script>
</head>

<body class="<?= isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'light' ? 'light-mode' : '' ?>">
    <script>
        
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
        }
    </script>

    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-custom">
                    <h3 class="card-title text-center mb-4"><i class="bi bi-book-fill"></i> <?= __('add_book_title') ?>
                    </h3>

                    <form action="save_book.php" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="<?= __('form_title') ?>" required>
                            <label for="title"><?= __('form_title') ?></label>
                        </div>

                        <div class="form-floating mb-4">
                            <select class="form-select" id="category" name="category" required>
                                <option value="" selected disabled><?= __('form_select_cat') ?></option>
                                <option value="novel"><?= __('novel') ?> (Novel)</option>
                                <option value="comic"><?= __('comic') ?> (Comic)</option>
                            </select>
                            <label for="category"><?= __('form_category') ?></label>
                        </div>

                        <div class="mb-4">
                            <label for="cover_image" class="form-label"><?= __('form_cover') ?></label>
                            <input class="form-control" type="file" id="cover_image" name="cover_image"
                                accept="image/*">
                        </div>

                        

                        <div class="form-floating mb-4">
                            <textarea class="form-control" id="description" name="description"
                                placeholder="<?= __('form_desc') ?>" style="height: 100px;"></textarea>
                            <label for="description"><?= __('form_desc') ?></label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="number" class="form-control" id="borrow_duration" name="borrow_duration"
                                placeholder="<?= __('form_duration') ?>" required value="7" min="1">
                            <label for="borrow_duration"><?= __('form_duration') ?></label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary-custom py-2"><?= __('btn_save') ?></button>
                            <a href="index.php" class="btn btn-outline-secondary py-2"><?= __('btn_cancel') ?></a>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>