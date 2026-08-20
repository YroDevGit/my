<?php

use Classes\Date;
use Classes\DB;
use Tables\Clients;
use Tables\Inquiry_type;
use Tables\Projects;

$page = get("page") || 1;

$type = get("type");

$search = get("search");

$where = [];

if ($type) {
  $where["type"] = $type;
}

if ($search) {
  $where["or"]["like"] = [
    "name" => $search,
    "description" => $search
  ];
}

$projType = array_column(Inquiry_type::getAll(), null, "id");
$client = array_column(Clients::getAll(), null, "id");
$find = Projects::paginatedFind($where, $page, 9, ["order by" => "created_at desc"]);
$data = $find['data'];
$paginate = $find['pagination'];
$hasPrev = val($paginate['has_previous']);
$hasNext = val($paginate['has_next']);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Projects</title>
  <?= _bootstrap_css() ?>
  <?= assets_css("auth") ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

  <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <?= include_page("auth/sidebar") ?>

  <!-- ===== MAIN WRAPPER ===== -->
  <div class="main-wrapper" id="mainWrapper">

    <?= include_page("auth/nav") ?>

    <!-- ===== PAGE CONTENT ===== -->
    <div class="page-content">

      <!-- page header -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1 text-dark">Projects</h4>
          <p class="text-secondary small mb-0">Manage all your web app projects</p>
        </div>
        <div class="d-flex gap-2">
          <span class="btn btn-outline-secondary rounded-pill px-4 refreshbtn">
            <i class="fas fa-refresh me-2"></i>Refresh
          </span>
          <span class="btn btn-primary rounded-pill px-4 addproject">
            <i class="fas fa-plus me-2"></i>New Project
          </span>
        </div>
      </div>

      <!-- stats row -->
      <div class="row g-3 g-md-4 mb-4" style="display: none;">
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon blue"><i class="fas fa-project-diagram"></i></div>
              <div>
                <div class="stat-value"><?= $paginate['total_records'] ?></div>
                <div class="stat-label">Total Projects</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
              <div>
                <div class="stat-value">5</div>
                <div class="stat-label">Completed</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon orange"><i class="fas fa-spinner"></i></div>
              <div>
                <div class="stat-value">4</div>
                <div class="stat-label">In Progress</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
              <div>
                <div class="stat-value">3</div>
                <div class="stat-label">Pending</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- filter & search -->
      <div class="d-flex flex-wrap gap-2 mb-3">
        <div class="flex-grow-1" style="max-width: 300px;">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill">
              <i class="fas fa-search text-secondary"></i>
            </span>
            <input type="text" id="searchInput" class="form-control bg-light border-start-0 rounded-end-pill"
              placeholder="Search projects..." value="<?= get('search') ?>">
          </div>
        </div>
        <select class="form-select form-select-sm rounded-pill ptypecb" style="width: auto; min-width: 140px;">
          <option value="">SELECT TYPE</option>
          <?php foreach ($projType as $k => $v): ?>
            <option value="<?= $v['id'] ?>"><?= $v['type'] ?></option>
          <?php endforeach; ?>
        </select>
        <button id="searchFilter" class="btn btn-primary"><i class="fas fa-search text-white"></i></button>
      </div>

      <!-- projects grid -->
      <div class="row g-3">

        <?php foreach ($data as $k => $v): ?>
          <?php $ptype = val($projType[$v['type']]); ?>
          <!-- project 1 -->
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="badge bg-<?= $ptype['color'] ?> bg-opacity-10 text-<?= $ptype['color'] ?> rounded-pill px-3 py-1"><?= $ptype['type'] ?></span>
                  <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                      <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                      <li><a class="dropdown-item" href="#"><i class="fas fa-project-diagram"></i>Manage</a></li>
                      <li><span class="dropdown-item editbtn" id="<?= encrypt($v['id']) ?>"><i class="fas fa-edit me-2"></i>Edit</span></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><span class="dropdown-item text-danger deletebtn" dataid="<?= encrypt($v['id']) ?>"><i class="fas fa-trash me-2"></i>Delete</span></li>
                    </ul>
                  </div>
                </div>
                <h5 class="fw-bold mb-1"><?= val($v['name']) ?></h5>
                <p class="text-secondary small mb-3"><?= val($v['description']) ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <div class="d-flex">

                    </div>
                    <span class="text-secondary small"></span>
                  </div>
                  <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i><?= Date::get_name($v['date'], "M d, Y h:ia") ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- pagination -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
        <div class="text-secondary small">
          Showing 1-6 of 12 projects
        </div>
        <div class="d-flex gap-2">
          <?php if ($hasPrev): ?>
            <a href="<?= append_url_params(["page" => $page - 1]) ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
              <i class="fas fa-chevron-left me-1"></i> Previous
            </a>
          <?php endif; ?>
          <?php if ($hasNext): ?>
            <a href="<?= append_url_params(["page" => $page + 1]) ?>" class="btn btn-primary btn-sm rounded-pill px-4">
              Next <i class="fas fa-chevron-right ms-1"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <?= include_page("auth/footer") ?>

  </div>

  <?= _bootstrap_js() ?>
</body>

</html>