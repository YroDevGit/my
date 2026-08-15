<?php

use Classes\Collection;
use Classes\Date;
use Models\NoteCategoryModel;
use Tables\Note_category;
use Tables\Notes;

$notes = Note_category::getAll();
$notes = Collection::data($notes)->encrypt("id")->exec();

$page = get("page");
$category = get("category") ?? null;
$search = get("search") ?? null;

$searchData = [];

if ($category) {
  $searchData['category'] = decrypt($category);
}

if ($search) {
  $searchData['or']['like'] = [
    "title" => $search,
    "description" => $search,
    "date" => $search
  ];
}

$page = get("page") ?? 1;

$allNotesResult = Notes::paginatedFind($searchData, $page, 9, ["order by"=>"created_at desc"]);

$NotesPagination = $allNotesResult['pagination'];
$hasNext = $NotesPagination['has_next'] ?? false;
$hasPrev = $NotesPagination['has_previous'] ?? false;
$totalPages = $NotesPagination['total_pages'] ?? 0;
$allNotes = Collection::data($allNotesResult['data'])->encrypt("id")->exec();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeYro · Notes & Schedule</title>
  <?= _bootstrap_css() ?>
  <?= assets_css("auth") ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

  <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

  <?= include_page("auth/sidebar") ?>

  <!-- ===== MAIN WRAPPER ===== -->
  <div class="main-wrapper" id="mainWrapper">

    <?= include_page("auth/nav") ?>

    <!-- ===== PAGE CONTENT ===== -->
    <div class="page-content">

      <!-- page header -->
      <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
          <h4 class="fw-bold mb-1 text-dark">Notes & Schedule</h4>
          <p class="text-secondary small mb-0">Manage your tasks, notes, and upcoming events</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-primary rounded-pill px-4 addnote">
            <i class="fas fa-plus me-2"></i>Add Note
          </button>
          <button class="btn btn-outline-primary rounded-pill px-4 refreshbtn">
            <i class="fas fa-refresh me-2"></i>Refresh
          </button>
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
                  placeholder="Search notes..." value="<?= $search ?>" time="true" id="searchNotes">
              </div>
            </div>
            <select class="form-select form-select-sm rounded-pill" style="width: auto; min-width: 140px;" id="filterNotesCategory">
              <option value="">All Notes</option>
              <?php foreach ($notes as $k => $v): ?>
                <option <?= compare_decrypt($category, $v['id']) ? 'selected' : ''; ?> value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-primary fa fa-search" id="searchbtn"></button>
          </div>

          <!-- notes grid -->
          <div class="row g-3" id="notesGrid" style="padding-bottom: 20px;">

            <?php if(! $allNotes): ?>
              <div align='center' style="padding: 10px 0px;">No notes found. <span class="addnote text-primary" style="cursor:pointer;">Add note</span></div>
            <?php endif; ?>

            <?php foreach ($allNotes as $k => $v): ?>
              <?php $selectedNote = NoteCategoryModel::getNoteCategoryById($v['category']); ?>
              <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 note-card" data-category="work">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <span class="badge bg-<?= $selectedNote['theme'] ?> bg-opacity-10 text-<?= $selectedNote['theme'] ?> rounded-pill px-3 py-1"><?= val($selectedNote['name']) ?></span>
                      <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                          <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="#" onclick="editNote(1)"><i class="fas fa-edit me-2"></i>Edit</a></li>
                          <li><a class="dropdown-item" href="#" onclick="duplicateNote(1)"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item text-danger deletebtn" data-id="<?= $v['id'] ?>"><i class="fas fa-trash me-2"></i>Delete</a></li>
                        </ul>
                      </div>
                    </div>
                    <h6 class="fw-bold mb-2"><?= val($v['title']) ?></h6>
                    <p class="text-secondary small mb-3"><?= val($v['description']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-secondary small"><i class="far fa-clock me-1"></i><?= Date::timeDif($v['created_at']) ?></span>
                      <span class="text-secondary small"><i class="far fa-calendar me-1"></i><?=Date::get_name($v['date'], "M d, Y")?></span>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <!-- note 1 -->

            <!-- notes pagination -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
              <div class="text-secondary small">
                Showing <span id="notesStart"><?=$page?></span> of <span id="notesTotal"><?=$totalPages?></span> pages
              </div>
              <div>
                <?php if ($hasPrev): $newPage = $page-1; ?>
                  <a href="<?=append_url_params(["page"=>$newPage])?>">
                  <button class="btn btn-primary btn-sm rounded-pill px-4" id="notesNext">
                    <i class="fas fa-chevron-left ms-1"></i> Previous
                  </button>
                  </a>
                <?php endif; ?>
                <?php if ($hasNext): $newPage = $page+1; ?>
                  <a href="<?=append_url_params(["page"=>$newPage])?>">
                  <button class="btn btn-primary btn-sm rounded-pill px-4" id="notesNext">
                    Next <i class="fas fa-chevron-right ms-1"></i>
                  </button>
                  </a>
                <?php endif; ?>
              </div>
            </div>

          </div>


        </div>

      </div>

      <?= include_page("auth/footer") ?>

    </div>

    <?= _bootstrap_js() ?>
</body>

</html>