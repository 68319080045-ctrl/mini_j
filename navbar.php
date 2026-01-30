<nav class="navbar navbar-expand-lg navbar-custom">
    <?php include_once "lang_config.php"; ?>
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="bi bi-book-half"></i> My Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> <?= __('home') ?></a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link btn btn-outline-light px-3" href="setting.php" style="border-radius: 20px;">
                        <i class="bi bi-gear-fill"></i> <?= __('setting') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>