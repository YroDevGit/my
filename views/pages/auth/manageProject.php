<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeYro · Project Details</title>
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

            <!-- breadcrumb & actions -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="#" class="text-secondary text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" class="text-secondary text-decoration-none">Projects</a></li>
                            <li class="breadcrumb-item active fw-semibold text-dark">Finlytics CRM</li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0 text-dark">Finlytics CRM</h4>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="#" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-tasks me-2"></i>Manage Tasks
                    </a>
                </div>
            </div>

            <!-- project overview -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-lg-8">
                    <div class="bg-white rounded-4 p-4 border border-light">
                        <div class="d-flex flex-wrap align-items-start justify-content-between mb-3">
                            <div>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="fas fa-spinner me-1"></i> In Progress
                                </span>
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 ms-2">
                                    <i class="fas fa-flag me-1"></i> High Priority
                                </span>
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 ms-2">
                                    <i class="far fa-calendar-alt me-1"></i> Due: Dec 20, 2024
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-secondary small">Progress</span>
                                <div class="progress" style="width: 120px; height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 65%;"></div>
                                </div>
                                <span class="fw-semibold small">65%</span>
                            </div>
                        </div>

                        <p class="text-secondary mb-3">Custom CRM dashboard with real-time analytics, reporting, and client management features. Built for Finlytics to streamline their operations.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user text-primary"></i>
                                    <span class="text-secondary small">Project Manager:</span>
                                    <span class="fw-semibold small">John Doe</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <i class="fas fa-calendar-plus text-primary"></i>
                                    <span class="text-secondary small">Created:</span>
                                    <span class="small">Nov 1, 2024</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-tag text-primary"></i>
                                    <span class="text-secondary small">Category:</span>
                                    <span class="small">Web Application</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <i class="fas fa-clock text-primary"></i>
                                    <span class="text-secondary small">Est. Time:</span>
                                    <span class="small">8 weeks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white rounded-4 p-4 border border-light h-100">
                        <h6 class="fw-bold mb-3">Assigned Team</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #1b3a6b;">JD</span>
                            <span class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #065f46;">SM</span>
                            <span class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #b45309;">MR</span>
                            <span class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #dc3545;">AC</span>
                            <span class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #0c5460;">EW</span>
                            <span class="rounded-circle bg-purple bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #5b21b6;">KL</span>
                            <span class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600; color: #6c757d;">+3</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary small">Total Hours</span>
                            <span class="fw-semibold small">124 / 180</span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-secondary small">Tasks</span>
                            <span class="fw-semibold small">12 / 18 completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- tabs -->
            <ul class="nav nav-tabs nav-tabs-custom border-0 mb-4" id="projectTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                        <i class="fas fa-info-circle me-2"></i>Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages" type="button" role="tab">
                        <i class="fas fa-file-alt me-2"></i>Pages / Parts
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 py-2" id="workflow-tab" data-bs-toggle="tab" data-bs-target="#workflow" type="button" role="tab">
                        <i class="fas fa-project-diagram me-2"></i>Workflow
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab">
                        <i class="fas fa-tasks me-2"></i>Tasks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                        <i class="fas fa-paperclip me-2"></i>Files
                    </button>
                </li>
            </ul>

            <!-- tab content -->
            <div class="tab-content" id="projectTabContent">

                <!-- ===== OVERVIEW TAB ===== -->
                <div class="tab-pane fade" id="overview" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="bg-white rounded-4 p-4 border border-light">
                                <h6 class="fw-bold mb-3">Project Description</h6>
                                <p class="text-secondary">Finlytics CRM is a comprehensive customer relationship management system designed specifically for financial services companies. It provides real-time analytics, client tracking, and reporting tools.</p>

                                <h6 class="fw-bold mt-4 mb-3">Key Features</h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled small">
                                            <li><i class="fas fa-check-circle text-success me-2"></i>Client management</li>
                                            <li><i class="fas fa-check-circle text-success me-2"></i>Real-time analytics</li>
                                            <li><i class="fas fa-check-circle text-success me-2"></i>Reporting dashboard</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled small">
                                            <li><i class="fas fa-check-circle text-success me-2"></i>Task automation</li>
                                            <li><i class="fas fa-check-circle text-success me-2"></i>Email integration</li>
                                            <li><i class="fas fa-check-circle text-success me-2"></i>API access</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg-white rounded-4 p-4 border border-light">
                                <h6 class="fw-bold mb-3">Quick Info</h6>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-secondary small">Status</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">In Progress</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-secondary small">Priority</span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">High</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-secondary small">Deadline</span>
                                    <span class="fw-semibold small">Dec 20, 2024</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-secondary small">Type</span>
                                    <span class="small">Web Application</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-secondary small">Budget</span>
                                    <span class="fw-semibold small">$15,000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== PAGES / PARTS TAB ===== -->
                <div class="tab-pane fade" id="pages" role="tabpanel">
                    <div class="bg-white rounded-4 border border-light overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold text-secondary small text-uppercase">Page / Part</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Type</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Status</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Assigned To</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Progress</th>
                                        <th class="px-4 py-3 text-end fw-semibold text-secondary small text-uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3 fw-semibold">Login Page</td>
                                        <td class="px-3 py-3"><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">Auth</span></td>
                                        <td class="px-3 py-3"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Completed</span></td>
                                        <td class="px-3 py-3"><span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span></td>
                                        <td class="px-3 py-3">
                                            <div class="progress" style="width: 100px; height: 6px;">
                                                <div class="progress-bar bg-success" style="width: 100%;"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check me-2"></i>Mark Complete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-semibold">Dashboard</td>
                                        <td class="px-3 py-3"><span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">Main</span></td>
                                        <td class="px-3 py-3"><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span></td>
                                        <td class="px-3 py-3"><span class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; color: #065f46; font-size: 0.75rem;">SM</span></td>
                                        <td class="px-3 py-3">
                                            <div class="progress" style="width: 100px; height: 6px;">
                                                <div class="progress-bar bg-warning" style="width: 60%;"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check me-2"></i>Mark Complete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-semibold">Client Management</td>
                                        <td class="px-3 py-3"><span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">CRUD</span></td>
                                        <td class="px-3 py-3"><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span></td>
                                        <td class="px-3 py-3"><span class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; color: #b45309; font-size: 0.75rem;">MR</span></td>
                                        <td class="px-3 py-3">
                                            <div class="progress" style="width: 100px; height: 6px;">
                                                <div class="progress-bar bg-warning" style="width: 40%;"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check me-2"></i>Mark Complete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-4 py-3 border-top">
                            <div class="text-secondary small">Showing 1-3 of 12 parts</div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4 disabled">Previous</a>
                                <a href="#" class="btn btn-primary btn-sm rounded-pill px-4">Next</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== WORKFLOW TAB (Kanban Board) ===== -->
                <div class="tab-pane fade show active" id="workflow" role="tabpanel">

                    <!-- Kanban header with Add Task button -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0">Kanban Board</h6>
                        <div class="d-flex gap-2">
                            <span class="btn btn-primary btn-sm rounded-pill px-4 addtaskbtn">
                                <i class="fas fa-plus me-2"></i>Add Taskd
                            </span>
                        </div>
                    </div>

                    <!-- Kanban Columns -->
                    <div class="kanban-board d-flex gap-3 overflow-auto pb-3" style="min-height: 400px;">

                        <!-- PENDING -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-secondary"><i class="fas fa-inbox me-1"></i> Pending</span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">3</span>
                                </div>
                                <div class="kanban-items" data-column="pending">
                                    <!-- Task Card 1 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary" draggable="true" data-task-id="1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Design login page UI</h6>
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2" style="font-size: 0.6rem;">High</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Create responsive login page with validation</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #1b3a6b; font-size: 0.6rem;">JD</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 5</span>
                                        </div>
                                    </div>
                                    <!-- Task Card 2 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary" draggable="true" data-task-id="2">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">API Documentation</h6>
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2" style="font-size: 0.6rem;">Medium</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Write API documentation for endpoints</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #dc3545; font-size: 0.6rem;">AC</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 10</span>
                                        </div>
                                    </div>
                                    <!-- Task Card 3 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary" draggable="true" data-task-id="3">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Database Schema</h6>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2" style="font-size: 0.6rem;">Not</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Design database schema for CRM</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #b45309; font-size: 0.6rem;">MR</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 12</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DEVELOPMENT -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-primary"><i class="fas fa-code me-1"></i> Development</span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">2</span>
                                </div>
                                <div class="kanban-items" data-column="development">
                                    <!-- Task Card 4 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-primary" draggable="true" data-task-id="4">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Implement Auth API</h6>
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2" style="font-size: 0.6rem;">High</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">JWT authentication with refresh tokens</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #065f46; font-size: 0.6rem;">SM</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 8</span>
                                        </div>
                                    </div>
                                    <!-- Task Card 5 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-primary" draggable="true" data-task-id="5">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Dashboard Layout</h6>
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2" style="font-size: 0.6rem;">Medium</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Build responsive dashboard layout</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #0c5460; font-size: 0.6rem;">EW</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 9</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TESTING -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-warning"><i class="fas fa-vial me-1"></i> Testing</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">1</span>
                                </div>
                                <div class="kanban-items" data-column="testing">
                                    <!-- Task Card 6 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-warning" draggable="true" data-task-id="6">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">User Flow Testing</h6>
                                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2" style="font-size: 0.6rem;">Medium</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Test complete user journey</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #065f46; font-size: 0.6rem;">RN</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 14</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STAGING -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-info"><i class="fas fa-server me-1"></i> Staging</span>
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">1</span>
                                </div>
                                <div class="kanban-items" data-column="staging">
                                    <!-- Task Card 7 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-info" draggable="true" data-task-id="7">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">API Integration</h6>
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2" style="font-size: 0.6rem;">High</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Test API integration in staging</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #dc3545; font-size: 0.6rem;">AC</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Dec 16</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DEPLOYED -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-success"><i class="fas fa-rocket me-1"></i> Deployed</span>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">0</span>
                                </div>
                                <div class="kanban-items" data-column="deployed">
                                    <!-- Empty - no tasks -->
                                    <div class="text-center text-secondary small py-3">No tasks</div>
                                </div>
                            </div>
                        </div>

                        <!-- PUBLISHED -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-purple"><i class="fas fa-check-circle me-1"></i> Published</span>
                                    <span class="badge bg-purple bg-opacity-10 text-purple rounded-pill">1</span>
                                </div>
                                <div class="kanban-items" data-column="published">
                                    <!-- Task Card 8 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-purple" draggable="true" data-task-id="8">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Login Page</h6>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size: 0.6rem;">Done</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Login page live on production</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #1b3a6b; font-size: 0.6rem;">JD</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Nov 30</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DONE -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-secondary"><i class="fas fa-check-double me-1"></i> Done</span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">2</span>
                                </div>
                                <div class="kanban-items" data-column="done">
                                    <!-- Task Card 9 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary opacity-75" draggable="true" data-task-id="9">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Project Setup</h6>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size: 0.6rem;">Done</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Initial project setup completed</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #1b3a6b; font-size: 0.6rem;">JD</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Nov 1</span>
                                        </div>
                                    </div>
                                    <!-- Task Card 10 -->
                                    <div class="kanban-card bg-white rounded-3 p-3 mb-2 shadow-sm border-start border-3 border-secondary opacity-75" draggable="true" data-task-id="10">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold small mb-0">Design System</h6>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size: 0.6rem;">Done</span>
                                        </div>
                                        <p class="text-secondary small mb-2" style="font-size: 0.7rem;">Design system established</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-weight: 600; color: #0c5460; font-size: 0.6rem;">EW</span>
                                            <span class="text-secondary small" style="font-size: 0.6rem;"><i class="far fa-clock me-1"></i>Nov 5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REJECTED -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-danger"><i class="fas fa-times-circle me-1"></i> Rejected</span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">0</span>
                                </div>
                                <div class="kanban-items" data-column="rejected">
                                    <div class="text-center text-secondary small py-3">No tasks</div>
                                </div>
                            </div>
                        </div>

                        <!-- CLOSED -->
                        <div class="kanban-column flex-shrink-0" style="width: 220px;">
                            <div class="bg-light rounded-4 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold small text-secondary"><i class="fas fa-lock me-1"></i> Closed</span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">0</span>
                                </div>
                                <div class="kanban-items" data-column="closed">
                                    <div class="text-center text-secondary small py-3">No tasks</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ===== TASKS TAB ===== -->
                <div class="tab-pane fade" id="tasks" role="tabpanel">
                    <div class="bg-white rounded-4 border border-light overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h6 class="fw-bold mb-0">Project Tasks</h6>
                            <span href="#" class="btn btn-primary btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                <i class="fas fa-plus me-2"></i>Add Task
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold text-secondary small text-uppercase">Task</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Priority</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Assigned To</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Deadline</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Status</th>
                                        <th class="px-4 py-3 text-end fw-semibold text-secondary small text-uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="task1">
                                                <label class="form-check-label fw-semibold small" for="task1">Design login page UI</label>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3"><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">High</span></td>
                                        <td class="px-3 py-3"><span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span></td>
                                        <td class="px-3 py-3 text-secondary small">Dec 5, 2024</td>
                                        <td class="px-3 py-3"><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Done</span></td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ===== FILES TAB ===== -->
                <div class="tab-pane fade" id="files" role="tabpanel">
                    <div class="bg-white rounded-4 border border-light overflow-hidden">
                        <div class="d-flex flex-wrap align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h6 class="fw-bold mb-0">Project Files</h6>
                            <a href="#" class="btn btn-primary btn-sm rounded-pill px-4">
                                <i class="fas fa-upload me-2"></i>Upload File
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold text-secondary small text-uppercase">File Name</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Type</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Size</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Uploaded By</th>
                                        <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Date</th>
                                        <th class="px-4 py-3 text-end fw-semibold text-secondary small text-uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <span class="fw-semibold small">project_requirements.pdf</span>
                                        </td>
                                        <td class="px-3 py-3"><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">PDF</span></td>
                                        <td class="px-3 py-3 text-secondary small">2.4 MB</td>
                                        <td class="px-3 py-3"><span class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span></td>
                                        <td class="px-3 py-3 text-secondary small">Nov 1, 2024</td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Download</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Preview</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?= include_page("auth/footer") ?>

    </div>

    <!-- ===== ADD TASK MODAL ===== -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Task Title</label>
                            <input type="text" class="form-control rounded-pill" placeholder="Enter task title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Description</label>
                            <textarea class="form-control rounded-3" rows="3" placeholder="Enter task description"></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Priority</label>
                                <select class="form-select rounded-pill">
                                    <option value="high">High</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="not">Not</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Deadline</label>
                                <input type="date" class="form-control rounded-pill">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Assign To</label>
                            <select class="form-select rounded-pill">
                                <option value="">Select team member...</option>
                                <option value="1">John Doe (Lead Developer)</option>
                                <option value="2">Sarah Mitchell (Full Stack Dev)</option>
                                <option value="3">Mike Rodriguez (Backend Engineer)</option>
                                <option value="4">Alex Chen (DevOps Engineer)</option>
                                <option value="5">Emma Wilson (UI/UX Designer)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Initial Column</label>
                            <select class="form-select rounded-pill">
                                <option value="pending">Pending</option>
                                <option value="development">Development</option>
                                <option value="testing">Testing</option>
                                <option value="staging">Staging</option>
                                <option value="deployed">Deployed</option>
                                <option value="published">Published</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4">Create Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TASK DETAIL MODAL ===== -->
    <div class="modal fade" id="taskDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-tasks me-2 text-primary"></i>Task Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <h6 class="fw-bold">Design login page UI</h6>
                            <p class="text-secondary small">Create responsive login page with form validation and error handling.</p>

                            <hr>
                            <h6 class="fw-bold small mb-3"><i class="fas fa-comments me-2"></i>Comments</h6>

                            <!-- Comment 1 -->
                            <div class="d-flex gap-3 mb-3">
                                <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #1b3a6b; font-size: 0.75rem;">JD</span>
                                <div>
                                    <div class="fw-semibold small">John Doe <span class="text-secondary fw-normal">· 2 hours ago</span></div>
                                    <p class="text-secondary small mb-0">Added initial design files. Please review when you have time.</p>
                                </div>
                            </div>

                            <!-- Comment 2 -->
                            <div class="d-flex gap-3 mb-3">
                                <span class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #065f46; font-size: 0.75rem;">SM</span>
                                <div>
                                    <div class="fw-semibold small">Sarah Mitchell <span class="text-secondary fw-normal">· 1 hour ago</span></div>
                                    <p class="text-secondary small mb-0">Looks great! Just need to adjust the spacing on mobile view.</p>
                                </div>
                            </div>

                            <!-- Add comment -->
                            <div class="d-flex gap-3 mt-3">
                                <span class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600; color: #6c757d; font-size: 0.75rem;">JD</span>
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control rounded-pill" placeholder="Add a comment...">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="bg-light rounded-4 p-3">
                                <div class="mb-3">
                                    <span class="text-secondary small d-block">Status</span>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-secondary small d-block">Priority</span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">High</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-secondary small d-block">Assigned To</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-weight: 600; color: #1b3a6b; font-size: 0.7rem;">JD</span>
                                        <span class="small">John Doe</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-secondary small d-block">Deadline</span>
                                    <span class="small">Dec 5, 2024</span>
                                </div>
                                <div>
                                    <span class="text-secondary small d-block">Move To</span>
                                    <select class="form-select form-select-sm rounded-pill">
                                        <option value="pending">Pending</option>
                                        <option value="development" selected>Development</option>
                                        <option value="testing">Testing</option>
                                        <option value="staging">Staging</option>
                                        <option value="deployed">Deployed</option>
                                        <option value="published">Published</option>
                                        <option value="done">Done</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <?= _bootstrap_js() ?>
    <?=js('_auth/workflowdefault')?>

    <style>
        /* ===== KANBAN STYLES ===== */
        .kanban-board {
            overflow-x: auto;
            padding-bottom: 1rem;
        }

        .kanban-column {
            min-width: 220px;
            max-width: 220px;
        }

        .kanban-items {
            min-height: 100%;
            transition: background-color 0.2s ease;
            border-radius: 0.75rem;
            padding: 0.25rem;
        }

        .kanban-items.drag-over {
            background-color: rgba(13, 110, 253, 0.05);
            border: 2px dashed #0d6efd;
        }

        .kanban-card {
            cursor: grab;
            transition: all 0.2s ease;
            user-select: none;
        }

        .kanban-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1) !important;
        }

        .kanban-card:active {
            cursor: grabbing;
        }

        .kanban-card.dragging {
            opacity: 0.5;
            transform: scale(0.95);
        }

        .border-purple {
            border-color: #5b21b6 !important;
        }

        .text-purple {
            color: #5b21b6 !important;
        }

        .bg-purple {
            background-color: #ede9fe !important;
        }

        .bg-purple.bg-opacity-10 {
            background-color: rgba(91, 33, 182, 0.1) !important;
        }

        /* Scrollbar styling */
        .kanban-board::-webkit-scrollbar {
            height: 6px;
        }

        .kanban-board::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .kanban-board::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .kanban-board::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Empty state */
        .kanban-items:empty::after {
            content: 'Drop tasks here';
            display: block;
            text-align: center;
            color: #9ca3af;
            font-size: 0.75rem;
            padding: 1.5rem 0;
        }
    </style>

</body>

</html>