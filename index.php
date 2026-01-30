<?php
session_start();
include "connect.php";
include_once "lang_config.php";
?>
<!DOCTYPE html>
<html lang="<?= $lang_code ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('page_title_index') ?></title>
    
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

    <?php
    include "navbar.php";

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $category_filter = isset($_GET['category']) ? $_GET['category'] : '';

    $search_param = "%" . $search . "%";

    if ($category_filter) {
        $sql = "SELECT * FROM book WHERE title LIKE ? AND category = ? ORDER BY id DESC";
        try {
            $stmt = $con->prepare($sql);
        } catch (mysqli_sql_exception $e) {
            
            if ($e->getCode() == 1054 || strpos($e->getMessage(), "Unknown column 'category'") !== false) {
                
                $con->query("ALTER TABLE book ADD COLUMN category VARCHAR(50) NOT NULL DEFAULT 'novel' AFTER title");
                
                $stmt = $con->prepare($sql);
            } else {
                throw $e;
            }
        }
        $stmt->bind_param("ss", $search_param, $category_filter);
    } else {
        $sql = "SELECT * FROM book WHERE title LIKE ? ORDER BY id DESC";
        $stmt = $con->prepare($sql); 
        $stmt->bind_param("s", $search_param);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="color: var(--accent-color);"><i class="bi bi-journal-album"></i>
                <?= __('book_list') ?>
            </h2>
            <?php
            
            $can_add = false;
            if (isset($_SESSION['is_logged_in']) && isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'admin') {
                    $can_add = true;
                }
            }
            ?>
            <?php if ($can_add): ?>
                <a href="add_book.php" class="btn btn-primary-custom"><i class="bi bi-plus-lg"></i>
                    <?= __('add_book') ?></a>
            <?php endif; ?>
        </div>

        <div class="mb-4 text-center">
            <div class="btn-group" role="group">
                <a href="index.php"
                    class="btn btn-outline-custom <?= !$category_filter ? 'active' : '' ?>"><?= __('all') ?></a>
                <a href="index.php?category=novel"
                    class="btn btn-outline-custom <?= $category_filter == 'novel' ? 'active' : '' ?>"><?= __('novel') ?></a>
                <a href="index.php?category=comic"
                    class="btn btn-outline-custom <?= $category_filter == 'comic' ? 'active' : '' ?>"><?= __('comic') ?></a>
            </div>
        </div>

        <div class="mb-4">
            <form action="index.php" method="get" class="d-flex">
                <input class="form-control me-2" type="search" name="search"
                    placeholder="<?= __('search_placeholder') ?>" value="<?= htmlspecialchars($search); ?>"
                    style="background-color: #2c2c2c; color: white; border: 1px solid #444;">
                <button class="btn btn-primary-custom" type="submit"><?= __('search_btn') ?></button>
            </form>
        </div>

        <div class="card-custom">
            <table class="table table-dark-custom table-hover">
                <thead>
                    <tr>
                        <th width="5%"><?= __('th_id') ?></th>
                        <th width="25%"><?= __('th_title') ?></th>
                        <th width="15%"><?= __('th_category') ?></th>
                        <th width="15%" class="text-center"><?= __('th_duration') ?></th>
                        <th width="20%" class="text-center"><?= __('th_status') ?></th>
                        <th width="20%" class="text-center"><?= __('th_manage') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($row['cover_image'])): ?>
                                            <img src="<?= htmlspecialchars($row['cover_image']); ?>" alt="Cover"
                                                class="me-2 rounded" style="width: 40px; height: 60px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="me-2 rounded bg-secondary d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 60px;">
                                                <i class="bi bi-book text-white-50"></i>
                                            </div>
                                        <?php endif; ?>
                                        <a href="book_details.php?id=<?= $row['id']; ?>"
                                            class="table-title-link hover-underline">
                                            <?= htmlspecialchars($row['title']); ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $cat = isset($row['category']) ? $row['category'] : '';
                                    if ($cat == 'novel')
                                        echo __('novel');
                                    elseif ($cat == 'comic')
                                        echo __('comic');
                                    else
                                        echo htmlspecialchars($cat);
                                    ?>
                                </td>
                                <td class="text-center"><?= $row['borrow_duration']; ?>         <?= __('days') ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] == '0'): ?>
                                        <span class="status-badge status-available"><?= __('status_available') ?></span>
                                    <?php else:
                                        $borrowed_at = $row['borrowed_at'];
                                        $duration = $row['borrow_duration'];
                                        
                                        $due_time = strtotime($borrowed_at . " + $duration days");
                                        $is_overdue = time() > $due_time;
                                        $due_date_str = date('d/m/Y', $due_time);
                                        ?>
                                        <?php if ($is_overdue): ?>
                                            <span class="status-badge bg-danger text-white"><?= __('status_overdue') ?></span>
                                            <div class="small text-danger mt-1"><?= __('return_due') ?>                 <?= $due_date_str; ?></div>
                                        <?php else: ?>
                                            <span class="status-badge status-borrowed"><?= __('status_borrowed') ?></span>
                                            <div class="small text-muted mt-1"><?= __('return_due') ?>                 <?= $due_date_str; ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] == '0'): ?>
                                        <?php if (isset($_SESSION['is_logged_in'])): ?>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="confirm_borrow.php?id=<?= $row['id']; ?>"
                                                    class="btn btn-sm btn-primary-custom"><?= __('btn_borrow') ?></a>
                                                <a href="book_details.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-custom"
                                                    title="<?= __('btn_view') ?>">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php
                                                
                                                $can_edit = false;
                                                if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
                                                    if ($_SESSION['role'] === 'admin') {
                                                        $can_edit = true;
                                                    }
                                                }
                                                ?>
                                                <?php if ($can_edit): ?>
                                                    <a href="edit_book.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info"
                                                        title="<?= __('btn_edit') ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="delete_book.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger"
                                                        title="<?= __('btn_delete') ?>" onclick="return confirm('<?= __('confirm_delete') ?>');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-sm btn-primary-custom w-100"><?= __('btn_borrow_full') ?></a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($_SESSION['is_logged_in'])): ?>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="return.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning"
                                                    onclick="return confirm('<?= __('confirm_return') ?>')"><?= __('btn_return') ?></a>
                                                <a href="book_details.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-custom"
                                                    title="<?= __('btn_view') ?>">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php
                                                
                                                $can_edit = false;
                                                if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
                                                    if ($_SESSION['role'] === 'admin') {
                                                        $can_edit = true;
                                                    }
                                                }
                                                ?>
                                                <?php if ($can_edit): ?>
                                                    <a href="edit_book.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info"
                                                        title="<?= __('btn_edit') ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="delete_book.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger"
                                                        title="<?= __('btn_delete') ?>" onclick="return confirm('<?= __('confirm_delete') ?>');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary w-100" disabled><?= __('status_unavailable') ?></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted"><?= __('no_data') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>