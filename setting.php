<?php
include "connect.php";
include "lang_config.php";


if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: setting.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="<?= $lang_code ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= __('setting') ?>
    </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="style.css">
    <script>
        
        const theme = localStorage.getItem('theme');
        if (theme === 'light') {
            document.documentElement.classList.add('light-mode'); 
        }
    </script>
</head>

<body>
    
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="card-custom">
            <h2 class="card-title mb-4"><i class="bi bi-gear-fill"></i>
                <?= __('system_setting') ?>
            </h2>

            
            <div class="setting-section">
                <h4 class="mb-3 text-secondary"><i class="bi bi-palette"></i>
                    <?= __('appearance') ?>
                </h4>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>
                        <?= __('dark_mode') ?>
                    </span> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
            </div>

            
            <div class="setting-section">
                <h4 class="mb-3 text-secondary"><i class="bi bi-translate"></i>
                    <?= __('language') ?>
                </h4>
                <div class="mb-3">
                    <label for="languageSelect" class="form-label">
                        <?= __('select_lang') ?>
                    </label>
                    <select class="form-select" id="languageSelect">
                        <option value="th" <?= $lang_code == 'th' ? 'selected' : '' ?>>ไทย (Thai)</option>
                        <option value="en" <?= $lang_code == 'en' ? 'selected' : '' ?>>English</option>
                    </select>
                </div>
            </div>

            
            <div class="setting-section">
                <h4 class="mb-3 text-secondary"><i class="bi bi-person-circle"></i>
                    <?= __('manage_account') ?>
                </h4>

                <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']): ?>
                    
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>
                            <?= __('welcome') ?>, <strong>
                                <?= htmlspecialchars($_SESSION['username']); ?>
                            </strong>
                        </div>
                    </div>
                    <a href="setting.php?action=logout" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        <?= __('logout') ?>
                    </a>

                <?php else: ?>
                    
                    <div class="card p-4" style="background-color: var(--input-bg); border: 1px solid var(--input-border);">
                        <h5 class="text-center mb-3">
                            <?= __('login') ?>
                        </h5>
                        <form action="check_login.php" method="post">
                            <input type="hidden" name="redirect" value="setting.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="<?= __('username') ?>" required>
                                <label for="username">
                                    <?= __('username') ?>
                                </label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="<?= __('password') ?>" required>
                                <label for="password">
                                    <?= __('password') ?>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                <?= __('login') ?>
                            </button>

                            <p class="text-center text-secondary mt-3 small">
                                <?= __('no_account') ?> <a href="register.php" class="text-decoration-none fw-bold"
                                    style="color: var(--accent-color);">
                                    <?= __('register') ?>
                                </a>
                            </p>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggle = document.getElementById('themeToggle');
            const languageSelect = document.getElementById('languageSelect');
            const html = document.documentElement;
            const body = document.body;

            
            const currentTheme = localStorage.getItem('theme');

            
            
            

            if (currentTheme === 'light') {
                body.classList.add('light-mode');
                
                themeToggle.checked = true; 
            } else {
                themeToggle.checked = false; 
            }

            themeToggle.addEventListener('change', function () {
                if (this.checked) {
                    body.classList.add('light-mode');
                    
                    localStorage.setItem('theme', 'light');
                } else {
                    body.classList.remove('light-mode');
                    
                    localStorage.setItem('theme', 'dark');
                }
            });

            
            languageSelect.addEventListener('change', function () {
                const lang = this.value;
                
                window.location.href = `setting.php?lang=${lang}`;
            });
        });
    </script>
</body>

</html>