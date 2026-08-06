<!-- ===== TOP NAVBAR ===== -->
<nav class="top-navbar d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
        <button class="navbar-toggle toogleSideBar" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="fw-semibold text-dark d-none d-sm-inline">Dashboard</span>
    </div>

    <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- search -->
        <div class="d-none d-md-block">
            <input type="text" class="navbar-search" placeholder="Search...">
        </div>

        <!-- notifications -->
        <button class="btn btn-light btn-sm rounded-circle position-relative" style="width: 38px; height: 38px;">
            <i class="fas fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                3
            </span>
        </button>

        <!-- avatar -->
        <div class="nav-avatar" data-bs-toggle="dropdown" aria-expanded="false">
            JD
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="/login"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </div>
</nav>