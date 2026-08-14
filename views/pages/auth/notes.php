<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Notes & Schedule</title>
  <?=_bootstrap_css()?>
  <?=assets_css("auth")?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

  <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <?=include_page("auth/sidebar")?>

  <!-- ===== MAIN WRAPPER ===== -->
  <div class="main-wrapper" id="mainWrapper">

    <?=include_page("auth/nav")?>

    <!-- ===== PAGE CONTENT ===== -->
    <div class="page-content">

      <!-- page header -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1 text-dark">Notes & Schedule</h4>
          <p class="text-secondary small mb-0">Manage your tasks, notes, and upcoming events</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-primary rounded-pill px-4" id="addnote">
            <i class="fas fa-plus me-2"></i>Add Note
          </button>
          <button class="btn btn-outline-primary rounded-pill px-4" onclick="addEvent()">
            <i class="fas fa-calendar-plus me-2"></i>Add Event
          </button>
        </div>
      </div>

      <!-- stats row -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon blue"><i class="fas fa-sticky-note"></i></div>
              <div>
                <div class="stat-value" id="totalNotes">18</div>
                <div class="stat-label">Total Notes</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon orange"><i class="fas fa-calendar-day"></i></div>
              <div>
                <div class="stat-value" id="todayEvents">3</div>
                <div class="stat-label">Today's Events</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
              <div>
                <div class="stat-value" id="completedTasks">7</div>
                <div class="stat-label">Completed</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
              <div>
                <div class="stat-value" id="pendingTasks">11</div>
                <div class="stat-label">Pending</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- tabs for Notes and Schedule -->
      <ul class="nav nav-tabs nav-tabs-custom border-0 mb-4" id="scheduleTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active rounded-pill px-4 py-2" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
            <i class="fas fa-sticky-note me-2"></i>Notes
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link rounded-pill px-4 py-2" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab">
            <i class="fas fa-calendar-alt me-2"></i>Schedule
          </button>
        </li>
      </ul>

      <!-- tab content -->
      <div class="tab-content" id="scheduleTabContent">

        <!-- ===== NOTES TAB ===== -->
        <div class="tab-pane fade show active" id="notes" role="tabpanel">

          <!-- search & filter -->
          <div class="d-flex flex-wrap gap-2 mb-3">
            <div class="flex-grow-1" style="max-width: 300px;">
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                  <i class="fas fa-search text-secondary"></i>
                </span>
                <input type="text" class="form-control bg-light border-start-0 rounded-end-pill" 
                       placeholder="Search notes..." time="true" id="searchNotes">
              </div>
            </div>
            <select class="form-select form-select-sm rounded-pill" style="width: auto; min-width: 140px;" id="filterNotes" onchange="filterNotes()">
              <option value="all">All Notes</option>
              <option value="personal">Personal</option>
              <option value="work">Work</option>
              <option value="client">Client</option>
              <option value="idea">Idea</option>
            </select>
          </div>

          <!-- notes grid -->
          <div class="row g-3" id="notesGrid">
            
            <!-- note 1 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="work">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">Work</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(1)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(1)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(1)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">Client Meeting Notes</h6>
                  <p class="text-secondary small mb-3">Discussed new CRM features with Finlytics team. Need to prepare proposal by Friday.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>2 hours ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#crm #proposal</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- note 2 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="personal">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Personal</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(2)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(2)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(2)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">Blog Post Ideas</h6>
                  <p class="text-secondary small mb-3">- Web app development trends<br>- Why custom apps beat off-the-shelf<br>- Client success stories</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>1 day ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#blog #content</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- note 3 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="client">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">Client</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(3)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(3)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(3)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">GreenSpace Requirements</h6>
                  <p class="text-secondary small mb-3">Dashboard requirements: real-time analytics, user roles, API integration with existing CRM.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>2 days ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#greenspace #dashboard</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- note 4 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="idea">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Idea</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(4)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(4)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(4)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">SaaS Product Idea</h6>
                  <p class="text-secondary small mb-3">Project management tool for freelancers with built-in invoicing and time tracking. MVP in 6 weeks.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>3 days ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#saas #mvp</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- note 5 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="work">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">Work</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(5)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(5)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(5)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">Server Maintenance Plan</h6>
                  <p class="text-secondary small mb-3">Schedule for monthly updates, backup verification, and security patches for all client hosting.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>4 days ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#devops #maintenance</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- note 6 -->
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 shadow-sm h-100 note-card" data-category="personal">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Personal</span>
                    <div class="dropdown">
                      <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="editNote(6)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="duplicateNote(6)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote(6)"><i class="fas fa-trash me-2"></i>Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <h6 class="fw-bold mb-2">Learning Plan 2025</h6>
                  <p class="text-secondary small mb-3">- Advanced React patterns<br>- Docker & Kubernetes<br>- Cloud architecture (AWS)</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small"><i class="far fa-clock me-1"></i>5 days ago</span>
                    <span class="text-secondary small"><i class="far fa-tag me-1"></i>#learning #skills</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- notes pagination -->
          <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
            <div class="text-secondary small">
              Showing <span id="notesStart">1</span>-<span id="notesEnd">6</span> of <span id="notesTotal">6</span> notes
            </div>
            <button class="btn btn-primary btn-sm rounded-pill px-4" id="notesNext" onclick="nextNotes()">
              Next <i class="fas fa-chevron-right ms-1"></i>
            </button>
          </div>

        </div>

        <!-- ===== SCHEDULE TAB ===== -->
        <div class="tab-pane fade" id="schedule" role="tabpanel">

          <!-- schedule header -->
          <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
              <h6 class="fw-bold mb-0">Upcoming Events</h6>
              <small class="text-secondary">Manage your schedule and deadlines</small>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary btn-sm rounded-pill" onclick="viewCalendar()">
                <i class="fas fa-calendar-alt me-1"></i>Calendar View
              </button>
              <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="addEvent()">
                <i class="fas fa-plus me-1"></i>Add Event
              </button>
            </div>
          </div>

          <!-- schedule list -->
          <div class="schedule-list">
            
            <!-- event 1 - today -->
            <div class="bg-white rounded-4 p-3 p-md-4 border border-light mb-3">
              <div class="d-flex flex-wrap align-items-start gap-3">
                <div class="text-center" style="min-width: 60px;">
                  <div class="fw-bold text-primary">10:00</div>
                  <div class="text-secondary small">AM</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0">Client Meeting - Finlytics</h6>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Urgent</span>
                  </div>
                  <p class="text-secondary small mb-0">Discuss project scope and timeline for the CRM dashboard.</p>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="text-secondary small"><i class="fas fa-video me-1"></i>Google Meet</span>
                    <span class="text-secondary small"><i class="fas fa-clock me-1"></i>2 hours</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="editEvent(1)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-success btn-sm rounded-pill" onclick="completeEvent(1)">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteEvent(1)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- event 2 - today -->
            <div class="bg-white rounded-4 p-3 p-md-4 border border-light mb-3">
              <div class="d-flex flex-wrap align-items-start gap-3">
                <div class="text-center" style="min-width: 60px;">
                  <div class="fw-bold text-primary">2:30</div>
                  <div class="text-secondary small">PM</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0">Code Review Session</h6>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">In Progress</span>
                  </div>
                  <p class="text-secondary small mb-0">Review PRs for the API integration project.</p>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="text-secondary small"><i class="fab fa-github me-1"></i>GitHub</span>
                    <span class="text-secondary small"><i class="fas fa-clock me-1"></i>1.5 hours</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="editEvent(2)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-success btn-sm rounded-pill" onclick="completeEvent(2)">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteEvent(2)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- event 3 - tomorrow -->
            <div class="bg-white rounded-4 p-3 p-md-4 border border-light mb-3">
              <div class="d-flex flex-wrap align-items-start gap-3">
                <div class="text-center" style="min-width: 60px;">
                  <div class="fw-bold text-primary">9:00</div>
                  <div class="text-secondary small">AM</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0">New Client Onboarding</h6>
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-1">Tomorrow</span>
                  </div>
                  <p class="text-secondary small mb-0">Onboard GreenSpace Co. - walk through their requirements.</p>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="text-secondary small"><i class="fas fa-users me-1"></i>Team meeting</span>
                    <span class="text-secondary small"><i class="fas fa-clock me-1"></i>3 hours</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="editEvent(3)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-success btn-sm rounded-pill" onclick="completeEvent(3)">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteEvent(3)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- event 4 - next week -->
            <div class="bg-white rounded-4 p-3 p-md-4 border border-light mb-3">
              <div class="d-flex flex-wrap align-items-start gap-3">
                <div class="text-center" style="min-width: 60px;">
                  <div class="fw-bold text-primary">11:30</div>
                  <div class="text-secondary small">AM</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0">Hosting Migration</h6>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">Next Week</span>
                  </div>
                  <p class="text-secondary small mb-0">Migrate Finlytics app to new AWS infrastructure.</p>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="text-secondary small"><i class="fas fa-server me-1"></i>AWS</span>
                    <span class="text-secondary small"><i class="fas fa-clock me-1"></i>4 hours</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="editEvent(4)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-success btn-sm rounded-pill" onclick="completeEvent(4)">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteEvent(4)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- event 5 - next week -->
            <div class="bg-white rounded-4 p-3 p-md-4 border border-light">
              <div class="d-flex flex-wrap align-items-start gap-3">
                <div class="text-center" style="min-width: 60px;">
                  <div class="fw-bold text-primary">3:00</div>
                  <div class="text-secondary small">PM</div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0">Proposal Deadline</h6>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Deadline</span>
                  </div>
                  <p class="text-secondary small mb-0">Submit final proposal for the SaaS platform project.</p>
                  <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="text-secondary small"><i class="fas fa-file-pdf me-1"></i>Proposal</span>
                    <span class="text-secondary small"><i class="fas fa-clock me-1"></i>Due date</span>
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary btn-sm rounded-pill" onclick="editEvent(5)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-outline-success btn-sm rounded-pill" onclick="completeEvent(5)">
                    <i class="fas fa-check"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="deleteEvent(5)">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>

          </div>

          <!-- schedule pagination -->
          <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
            <div class="text-secondary small">
              Showing <span id="scheduleStart">1</span>-<span id="scheduleEnd">5</span> of <span id="scheduleTotal">5</span> events
            </div>
            <button class="btn btn-primary btn-sm rounded-pill px-4" id="scheduleNext" onclick="nextSchedule()">
              Next <i class="fas fa-chevron-right ms-1"></i>
            </button>
          </div>

        </div>

      </div>

    </div>

    <?=include_page("auth/footer")?>

  </div>

  <?=_bootstrap_js()?>
</body>
</html>