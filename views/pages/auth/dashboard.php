<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=variable('name')?> · Dashboard</title>
  <?=_bootstrap_css()?>
  <?=assets_css("auth")?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

  <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
  <div class="sidebar-overlay toogleSideBar" id="sidebarOverlay"></div>

 <?=include_page("auth/sidebar")?>

  <!-- ===== MAIN WRAPPER ===== -->
  <div class="main-wrapper" id="mainWrapper">

    <?=include_page("auth/nav")?>

    <!-- ===== PAGE CONTENT ===== -->
    <div class="page-content">

      <!-- stats row -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon blue"><i class="fas fa-rocket"></i></div>
              <div>
                <div class="stat-value">12</div>
                <div class="stat-label">Active Projects</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon green"><i class="fas fa-users"></i></div>
              <div>
                <div class="stat-value">28</div>
                <div class="stat-label">Total Clients</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon purple"><i class="fas fa-tasks"></i></div>
              <div>
                <div class="stat-value">43</div>
                <div class="stat-label">Tasks Completed</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon orange"><i class="fas fa-dollar-sign"></i></div>
              <div>
                <div class="stat-value">$24.5k</div>
                <div class="stat-label">Revenue</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- charts and activity -->
      <div class="row g-3 g-md-4">
        <!-- chart placeholder -->
        <div class="col-lg-8">
          <div class="chart-placeholder">
            <div class="text-center">
              <i class="fas fa-chart-bar mb-3"></i>
              <p class="text-secondary mb-0">📊 Revenue Chart (Coming Soon)</p>
              <small class="text-muted">Weekly performance overview</small>
            </div>
          </div>
        </div>

        <!-- recent activity -->
        <div class="col-lg-4">
          <div class="bg-white rounded-4 p-3 p-md-4 border border-light h-100">
            <h6 class="fw-bold mb-3 d-flex align-items-center">
              <i class="fas fa-clock me-2 text-primary"></i>Recent Activity
            </h6>
            <div class="activity-item d-flex gap-3 align-items-start">
              <span class="activity-dot blue mt-1"></span>
              <div>
                <div class="small fw-semibold">New project: Finlytics CRM</div>
                <div class="text-secondary small">2 hours ago</div>
              </div>
            </div>
            <div class="activity-item d-flex gap-3 align-items-start">
              <span class="activity-dot green mt-1"></span>
              <div>
                <div class="small fw-semibold">Task completed: API integration</div>
                <div class="text-secondary small">5 hours ago</div>
              </div>
            </div>
            <div class="activity-item d-flex gap-3 align-items-start">
              <span class="activity-dot orange mt-1"></span>
              <div>
                <div class="small fw-semibold">New client: GreenSpace Co.</div>
                <div class="text-secondary small">1 day ago</div>
              </div>
            </div>
            <div class="activity-item d-flex gap-3 align-items-start">
              <span class="activity-dot red mt-1"></span>
              <div>
                <div class="small fw-semibold">Server maintenance scheduled</div>
                <div class="text-secondary small">2 days ago</div>
              </div>
            </div>
            <div class="activity-item d-flex gap-3 align-items-start">
              <span class="activity-dot blue mt-1"></span>
              <div>
                <div class="small fw-semibold">Deployment: v2.4.0 live</div>
                <div class="text-secondary small">3 days ago</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- quick actions -->
      <div class="row g-3 mt-3">
        <div class="col-12">
          <div class="bg-white rounded-4 p-3 p-md-4 border border-light">
            <h6 class="fw-bold mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-flex flex-wrap gap-2">
              <button class="btn btn-primary rounded-pill"><i class="fas fa-plus me-2"></i>New Project</button>
              <button class="btn btn-outline-primary rounded-pill"><i class="fas fa-user-plus me-2"></i>Add Client</button>
              <button class="btn btn-outline-secondary rounded-pill"><i class="fas fa-server me-2"></i>Manage Hosting</button>
              <button class="btn btn-outline-success rounded-pill"><i class="fas fa-file-invoice me-2"></i>Generate Invoice</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <?=include_page("auth/footer")?>

  </div>

  <?=_bootstrap_js()?>
</body>
</html>