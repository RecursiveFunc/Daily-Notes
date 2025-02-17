<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 690px;">
    <a href="<?php echo BASE_URL . 'main/main.php' ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <img src="../images/logo-notes.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
        <span class="fs-4">Daily Notes Menu</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo BASE_URL . 'main/main.php' ?>" class="nav-link active" aria-current="page">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home" />
                </svg>
                Home
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'write/write.php' ?>" class="nav-link link-dark">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#write" />
                </svg>
                Mulai menulis...
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'mood/mood.php' ?>" class="nav-link link-dark">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#mood" />
                </svg>
                Mood Tracker
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo $nama ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <!-- <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li> -->
            <li><a class="dropdown-item" href="<?php echo BASE_URL . 'regis/logout.php' ?>">Log out</a></li>
        </ul>
    </div>
</div>