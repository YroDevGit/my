<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Global Chat</title>
  <?=_bootstrap_css()?>
  <?=assets_css("auth")?>
  <?=assets_css("auth/chat")?>
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
          <h4 class="fw-bold mb-1 text-dark">Global Chat</h4>
          <p class="text-secondary small mb-0">Connect with your team in real-time</p>
        </div>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-users me-2"></i>Create Group
          </a>
          <a href="#" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newChatModal">
            <i class="fas fa-plus me-2"></i>New Chat
          </a>
        </div>
      </div>

      <!-- chat container -->
      <div class="chat-container bg-white rounded-4 border border-light overflow-hidden">
        <div class="row g-0">

          <!-- ===== CHAT SIDEBAR ===== -->
          <div class="col-lg-3 col-md-4 border-end">
            
            <!-- chat search -->
            <div class="p-3 border-bottom">
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                  <i class="fas fa-search text-secondary"></i>
                </span>
                <input type="text" class="form-control bg-light border-start-0 rounded-end-pill" 
                       placeholder="Search conversations...">
              </div>
            </div>

            <!-- chat list -->
            <div class="chat-list" style="max-height: 600px; overflow-y: auto;">
              
              <!-- chat item 1 - active -->
              <a href="#" class="chat-item d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none active-chat">
                <div class="position-relative flex-shrink-0">
                  <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                       style="width: 48px; height: 48px; font-weight: 700; color: #1b3a6b; font-size: 0.9rem;">
                    JD
                  </div>
                  <span class="position-absolute bottom-0 end-0 rounded-circle bg-success border border-white" 
                        style="width: 14px; height: 14px;"></span>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 small">GLOBAL CHAT</h6>
                    <span class="text-secondary small" style="font-size: 0.6rem;">2 min ago</span>
                  </div>
                  <p class="text-secondary small mb-0 text-truncate" style="font-size: 0.75rem;">
                    Hey, can you review the PR?
                  </p>
                </div>
                <span class="badge bg-danger rounded-pill flex-shrink-0">3</span>
              </a>

              <!-- chat item 2 -->
              <a href="#" style="display: none;" class="chat-item d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none">
                <div class="position-relative flex-shrink-0">
                  <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" 
                       style="width: 48px; height: 48px; font-weight: 700; color: #065f46; font-size: 0.9rem;">
                    SM
                  </div>
                  <span class="position-absolute bottom-0 end-0 rounded-circle bg-success border border-white" 
                        style="width: 14px; height: 14px;"></span>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 small">TEST</h6>
                    <span class="text-secondary small" style="font-size: 0.6rem;">1 hour ago</span>
                  </div>
                  <p class="text-secondary small mb-0 text-truncate" style="font-size: 0.75rem;">
                    Deployed to staging ✅
                  </p>
                </div>
              </a>


             

            </div>
          </div>

          <!-- ===== MAIN CHAT AREA ===== -->
          <div class="col-lg-9 col-md-8 d-flex flex-column" style="height: 650px;">

            <!-- chat header -->
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom flex-shrink-0">
              <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                  <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                       style="width: 40px; height: 40px; font-weight: 700; color: #1b3a6b; font-size: 0.8rem;">
                    JD
                  </div>
                  <span class="position-absolute bottom-0 end-0 rounded-circle bg-success border border-white" 
                        style="width: 12px; height: 12px;"></span>
                </div>
                <div>
                  <h6 class="fw-bold mb-0 small">GLOBAL</h6>
                  <span class="text-success small" style="font-size: 0.65rem;"><i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>Online</span>
                </div>
              </div>
              <div class="d-flex gap-2">
                <a href="#" class="btn btn-light btn-sm rounded-circle" style="width: 36px; height: 36px;">
                  <i class="fas fa-phone"></i>
                </a>
                <a href="#" class="btn btn-light btn-sm rounded-circle" style="width: 36px; height: 36px;">
                  <i class="fas fa-video"></i>
                </a>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown" style="width: 36px; height: 36px;">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>View Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Mute Notifications</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete Chat</a></li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- chat messages -->
            <div class="flex-grow-1 p-3 overflow-auto" style="background: #f8f9fa;">
              
              <!-- date divider -->
              <div class="text-center mb-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-2">Today</span>
              </div>

              <!-- message 1 - received -->
              <div class="d-flex gap-3 mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #1b3a6b; font-size: 0.7rem;">
                  JD
                </div>
                <div>
                  <div class="bg-white rounded-4 p-3 shadow-sm" style="max-width: 70%;">
                    <p class="mb-0 small">Hey team! The PR is ready for review. Can you guys take a look?</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">9:30 AM</span>
                </div>
              </div>

              <!-- message 2 - sent -->
              <div class="d-flex gap-3 mb-3 justify-content-end">
                <div class="text-end">
                  <div class="bg-primary text-white rounded-4 p-3 shadow-sm" style="max-width: 100%;">
                    <p class="mb-0 small">Sure! I'll review it right now.</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">9:32 AM</span>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #065f46; font-size: 0.7rem;">
                  SM
                </div>
              </div>

              <!-- message 3 - received -->
              <div class="d-flex gap-3 mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #1b3a6b; font-size: 0.7rem;">
                  JD
                </div>
                <div>
                  <div class="bg-white rounded-4 p-3 shadow-sm" style="max-width: 70%;">
                    <p class="mb-0 small">Great! Let me know if you find any issues.</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">9:33 AM</span>
                </div>
              </div>

              <!-- date divider -->
              <div class="text-center my-3">
                <span class="badge bg-light text-secondary rounded-pill px-3 py-2">Yesterday</span>
              </div>

              <!-- message 4 - received -->
              <div class="d-flex gap-3 mb-3">
                <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #b45309; font-size: 0.7rem;">
                  MR
                </div>
                <div>
                  <div class="bg-white rounded-4 p-3 shadow-sm" style="max-width: 70%;">
                    <p class="mb-0 small">Database migration is complete. All tests are passing.</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">4:15 PM</span>
                </div>
              </div>

              <!-- message 5 - sent -->
              <div class="d-flex gap-3 mb-3 justify-content-end">
                <div class="text-end">
                  <div class="bg-primary text-white rounded-4 p-3 shadow-sm" style="max-width: 100%;">
                    <p class="mb-0 small">Excellent work Mike! 👏</p>
                  </div>
                  <span class="text-secondary small" style="font-size: 0.6rem;">4:20 PM</span>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #065f46; font-size: 0.7rem;">
                  SM
                </div>
              </div>

              <!-- typing indicator -->
              <div class="d-flex gap-3 mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 36px; height: 36px; font-weight: 700; color: #1b3a6b; font-size: 0.7rem;">
                  JD
                </div>
                <div class="bg-white rounded-4 p-3 shadow-sm">
                  <div class="typing-indicator d-flex gap-1">
                    <span class="rounded-circle bg-secondary" style="width: 6px; height: 6px; animation: typing 1.4s infinite;"></span>
                    <span class="rounded-circle bg-secondary" style="width: 6px; height: 6px; animation: typing 1.4s infinite 0.2s;"></span>
                    <span class="rounded-circle bg-secondary" style="width: 6px; height: 6px; animation: typing 1.4s infinite 0.4s;"></span>
                  </div>
                </div>
              </div>

            </div>

            <!-- chat input -->
            <div class="p-3 border-top flex-shrink-0 bg-white">
              <div class="d-flex gap-2">
                <button class="btn btn-light rounded-circle" style="width: 40px; height: 40px;">
                  <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" id="msg" class="form-control rounded-pill" placeholder="Type a message...">
                <button class="btn btn-primary rounded-pill px-4 sendbtn">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>

    <?=include_page("auth/footer")?>

  </div>

  <!-- ===== NEW CHAT MODAL ===== -->
  <div class="modal fade" id="newChatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>New Chat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Select User</label>
            <select class="form-select rounded-pill">
              <option value="">Choose a team member...</option>
              <option value="1">John Doe - Lead Developer</option>
              <option value="2">Sarah Mitchell - Full Stack Dev</option>
              <option value="3">Mike Rodriguez - Backend Engineer</option>
              <option value="4">Alex Chen - DevOps Engineer</option>
              <option value="5">Emma Wilson - UI/UX Designer</option>
              <option value="6">Karen Liu - Frontend Developer</option>
              <option value="7">Rachel Nguyen - QA Engineer</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold small">Message</label>
            <textarea class="form-control rounded-3" rows="3" placeholder="Type your first message..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary rounded-pill px-4">Start Chat</button>
        </div>
      </div>
    </div>
  </div>

  <?=_bootstrap_js()?>

</body>
</html>