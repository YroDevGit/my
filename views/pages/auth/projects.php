<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Projects</title>
  <?=_bootstrap_css()?>
  <?=assets_css("auth")?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

  <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <?=include_page("auth/sidebar")?>

  <!-- ===== MAIN WRAPPER ===== -->
  <div class="main-wrapper" id="mainWrapper">

    <?=include_page("auth/nav")?>

    <!-- ===== PAGE CONTENT ===== -->
    <div class="page-content">

      <!-- page header -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1 text-dark">Projects</h4>
          <p class="text-secondary small mb-0">Manage all your web app projects</p>
        </div>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-filter me-2"></i>Filter
          </a>
          <span class="btn btn-primary rounded-pill px-4 addproject">
            <i class="fas fa-plus me-2"></i>New Project
          </span>
        </div>
      </div>

      <!-- stats row -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon blue"><i class="fas fa-project-diagram"></i></div>
              <div>
                <div class="stat-value">12</div>
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
            <input type="text" class="form-control bg-light border-start-0 rounded-end-pill" 
                   placeholder="Search projects...">
          </div>
        </div>
        <select class="form-select form-select-sm rounded-pill" style="width: auto; min-width: 140px;">
          <option value="all">All Status</option>
          <option value="completed">Completed</option>
          <option value="in-progress">In Progress</option>
          <option value="pending">Pending</option>
          <option value="on-hold">On Hold</option>
        </select>
        <select class="form-select form-select-sm rounded-pill" style="width: auto; min-width: 140px;">
          <option value="newest">Newest First</option>
          <option value="oldest">Oldest First</option>
          <option value="a-z">A-Z</option>
          <option value="z-a">Z-A</option>
        </select>
      </div>

      <!-- projects grid -->
      <div class="row g-3">

        <!-- project 1 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Completed</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">Finlytics CRM</h5>
              <p class="text-secondary small mb-3">Custom CRM dashboard with real-time analytics and reporting.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">React</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Node.js</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">PostgreSQL</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #1b3a6b; margin-right: -6px;">JD</span>
                    <span class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #065f46;">SM</span>
                  </div>
                  <span class="text-secondary small">+2 more</span>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>Dec 2024</span>
              </div>
            </div>
          </div>
        </div>

        <!-- project 2 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">GreenSpace Dashboard</h5>
              <p class="text-secondary small mb-3">Real-time analytics dashboard for environmental data tracking.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Vue.js</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Python</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">MongoDB</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #b45309; margin-right: -6px;">MR</span>
                    <span class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #dc3545;">AC</span>
                  </div>
                  <span class="text-secondary small">+1 more</span>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>Jan 2025</span>
              </div>
            </div>
          </div>
        </div>

        <!-- project 3 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">Pending</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">PropView Portal</h5>
              <p class="text-secondary small mb-3">Client portal for real estate agents with property listings and scheduling.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Laravel</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">MySQL</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Bootstrap</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #0c5460; margin-right: -6px;">EW</span>
                    <span class="rounded-circle bg-purple bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #5b21b6;">KL</span>
                  </div>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>Feb 2025</span>
              </div>
            </div>
          </div>
        </div>

        <!-- project 4 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">SaaS Platform MVP</h5>
              <p class="text-secondary small mb-3">Project management tool with built-in invoicing and time tracking.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Next.js</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Prisma</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Tailwind</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #1b3a6b; margin-right: -6px;">TP</span>
                    <span class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #065f46;">RN</span>
                  </div>
                  <span class="text-secondary small">+2 more</span>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>Mar 2025</span>
              </div>
            </div>
          </div>
        </div>

        <!-- project 5 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">On Hold</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">Mobile App Backend</h5>
              <p class="text-secondary small mb-3">REST API for fitness tracking mobile app with real-time sync.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Node.js</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Express</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Firebase</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #dc3545; margin-right: -6px;">DB</span>
                    <span class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #0c5460;">LW</span>
                  </div>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>Apr 2025</span>
              </div>
            </div>
          </div>
        </div>

        <!-- project 6 -->
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Completed</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
              <h5 class="fw-bold mb-1">E-Commerce Platform</h5>
              <p class="text-secondary small mb-3">Custom e-commerce solution with subscription management and analytics.</p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Django</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">PostgreSQL</span>
                <span class="badge bg-light text-secondary rounded-pill px-3 py-1">Redis</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                  <div class="d-flex">
                    <span class="rounded-circle bg-purple bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #5b21b6; margin-right: -6px;">AG</span>
                    <span class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem; font-weight: 600; color: #b45309;">JM</span>
                  </div>
                  <span class="text-secondary small">+1 more</span>
                </div>
                <span class="text-secondary small"><i class="far fa-calendar-alt me-1"></i>May 2025</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- pagination -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
        <div class="text-secondary small">
          Showing 1-6 of 12 projects
        </div>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4 disabled">
            <i class="fas fa-chevron-left me-1"></i> Previous
          </a>
          <a href="#" class="btn btn-primary btn-sm rounded-pill px-4">
            Next <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
      </div>

    </div>

    <?=include_page("auth/footer")?>

  </div>

  <?=_bootstrap_js()?>
</body>
</html>