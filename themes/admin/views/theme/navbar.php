<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="<?=url("/painel")?>">
        <img width="120" height="40" src="<?=theme("/assets/images/ccb_logo/logo-ccb-light.png")?>">
    </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="bi bi-list"></i></button>

        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
            <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                    id="bd-theme"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                    aria-label="Toggle theme (auto)">
                <svg class="bi bi-circle-half my-1 theme-icon-active" width="16" height="16"><use href="#circle-half"></use></svg>
                <span class="d-lg-none ms-2" id="bd-theme-text">Alternar tema</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme-text">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                        <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16"><use href="#sun-fill"></use></svg>
                        Light
                        <i class="bi bi-check2 ms-auto d-none"></i>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                        <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16"><use href="#moon-stars-fill"></use></svg>
                        Dark
                        <i class="bi bi-check2 ms-auto d-none"></i>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                        <svg class="bi me-2 opacity-50 theme-icon" width="16" height="16"><use href="#circle-half"></use></svg>
                        Auto
                        <i class="bi bi-check2 ms-auto d-none"></i>
                    </button>
                </li>
            </ul>
        </li>
    </ul>
<!--    </form>-->
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php if (user()->photo()): ?>
                <img class="rounded-circle m-2" width="32" height="32" alt="<?= user()->user_name; ?>" title="<?= user()->user_name; ?>"
                        src="<?= image(user()->photo, 260, 260); ?>"/>
            <?php else: ?>
                <img class="rounded-circle m-2" width="32" height="32" alt="<?= user()->user_name; ?>" title="<?= user()->user_name; ?>"
                        src="<?= theme("/assets/images/avatar.jpg", CONF_VIEW_APP); ?>"/>
            <?php endif; ?></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?=url("/painel/perfil")?>"><i class="bi bi-person-fill-gear"></i> Perfil</a></li>
            </ul>
        </li>
    </ul>
</nav>

<?= $this->insert("views/modalSystem"); ?>