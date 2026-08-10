<?php

use Classes\Ctrx;
use Models\InquieryTypeModel;
use Tables\Emails;

$page =  get("page") ?: 1;

$result = Emails::paginatedFind(["active" => 1], $page, extra:["order by"=>"created_at desc"]);
$data = $result['data'];
$pagination = $result['pagination'];
$hasNext = $pagination['has_next'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=variable('name')?> · Client Inquiries</title>
    <?= _bootstrap_css() ?>
    <?= assets_css("auth") ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- ===== SIDEBAR OVERLAY (mobile) ===== -->
    <div class="sidebar-overlay toogleSideBar" id="sidebarOverlay"></div>

    <?= include_page("auth/sidebar") ?>

    <!-- ===== MAIN WRAPPER ===== -->
    <div class="main-wrapper" id="mainWrapper">

        <?= include_page("auth/nav") ?>

        <!-- ===== PAGE CONTENT ===== -->
        <div class="page-content">

            <!-- page header -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Client Inquiries</h4>
                    <p class="text-secondary small mb-0">Manage all client requests and messages</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary rounded-pill px-4" onclick="filterInquiries()">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <button class="btn btn-primary rounded-pill px-4" onclick="exportInquiries()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>

            <!-- stats row -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon blue"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="stat-value" id="totalCount"><?=$pagination['total_records']?></div>
                                <div class="stat-label">Total Inquiries</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                            <div>
                                <div class="stat-value" id="pendingCount">8</div>
                                <div class="stat-label">Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <div class="stat-value" id="respondedCount">12</div>
                                <div class="stat-label">Responded</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon purple"><i class="fas fa-star"></i></div>
                            <div>
                                <div class="stat-value" id="convertedCount">4</div>
                                <div class="stat-label">Converted</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- inquiry table -->
            <div class="bg-white rounded-4 border border-light overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="inquiryTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">
                                    <input class="form-check-input" type="checkbox" id="selectAll" onchange="selectAllInquiries()">
                                </th>
                                <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Client</th>
                                <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Project Type</th>
                                <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Message</th>
                                <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Status</th>
                                <th class="px-3 py-3 fw-semibold text-secondary small text-uppercase">Date</th>
                                <th class="px-4 py-3 text-end fw-semibold text-secondary small text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody id="inquiryBody">
                            <!-- inquiry 1 -->
                            <?php foreach ($data as $k => $row): ?>
                                <tr data-id="<?= encrypt($row['id']) ?>">
                                    <td class="px-4 py-3">
                                        <input class="form-check-input inquiry-checkbox" type="checkbox" data-id="1">
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; color: #1b3a6b; font-weight: 600; font-size: 0.9rem;">
                                                U
                                            </div>
                                            <div>
                                                <div class="fw-semibold small"><?= $row['email'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <?php $iqtype = InquieryTypeModel::getById($row['itype']);  ?>
                                        <span class="badge bg-<?=$iqtype['color'] ?? 'primary'?> bg-opacity-10 text-<?=$iqtype['color'] ?? 'primary'?> rounded-pill px-3 py-2 fw-normal">
                                            <?=$iqtype['type'] ?? null?>
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="text-truncate msgpop" style="max-width: 200px;" msg="<?= $row['message'] ?? "" ?>">
                                            <?= $row['message'] ?? "" ?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-normal status-badge" data-status="pending">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-secondary small">2024-12-15</td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#" onclick="viewInquiry(1)"><i class="fas fa-eye me-2"></i>View</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="replyInquiry(1)"><i class="fas fa-reply me-2"></i>Reply</a></li>
                                                <li><a class="dropdown-item text-success" href="#" onclick="markResponded(1)"><i class="fas fa-check me-2"></i>Mark Responded</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger action-del" data-id="<?= encrypt($row['id']) ?>" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- table footer with simple pagination -->
                <div class="d-flex flex-wrap align-items-center justify-content-between px-4 py-3 border-top">
                    <div class="text-secondary small">
                        <span id="startRange"><span id="totalRecords"><?= $pagination['total_records'] ?></span> inquiries
                    </div>
                    <div class="d-flex gap-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>">
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-4" id="prevPage">
                                <i class="fas fa-chevron-left me-1"></i> Previous
                            </button>
                            </a>
                        <? endif; ?>
                        <?php if ($hasNext): ?>
                            <a href="?page=<?= $page + 1 ?>">
                            <button class="btn btn-primary btn-sm rounded-pill px-4" id="nextPage">
                                Next <i class="fas fa-chevron-right ms-1"></i>
                            </button>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <?= include_page("auth/footer") ?>

    </div>

    <?= _bootstrap_js() ?>
    <script>

        // ===== FUNCTION: SELECT ALL =====
        function selectAllInquiries() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.inquiry-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        }

        // ===== FUNCTION: FILTER INQUIRIES =====
        function filterInquiries() {
            // You can implement your filter logic here
            alert('Filter functionality coming soon!');
        }

        // ===== FUNCTION: EXPORT INQUIRIES =====
        function exportInquiries() {
            // You can implement your export logic here
            alert('Export functionality coming soon!');
        }

        // ===== FUNCTION: VIEW INQUIRY =====
        function viewInquiry(id) {
            // You can implement your view logic here
            alert('Viewing inquiry #' + id);
        }

        // ===== FUNCTION: REPLY INQUIRY =====
        function replyInquiry(id) {
            // You can implement your reply logic here
            alert('Replying to inquiry #' + id);
        }

        // ===== FUNCTION: MARK AS RESPONDED =====
        function markResponded(id) {
            // You can implement your mark responded logic here
            if (confirm('Mark inquiry #' + id + ' as responded?')) {
                alert('Inquiry #' + id + ' marked as responded!');
                // Example: update the status badge
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    const badge = row.querySelector('.status-badge');
                    badge.className = 'badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-normal status-badge';
                    badge.setAttribute('data-status', 'responded');
                    badge.innerHTML = '<i class="fas fa-check-circle me-1"></i> Responded';
                }
            }
        }

        // ===== FUNCTION: DELETE INQUIRY =====
        function deleteInquiry(id) {
            if (confirm('Are you sure you want to delete inquiry #' + id + '?')) {
                // You can implement your delete logic here
                alert('Inquiry #' + id + ' deleted!');
                // Example: remove the row
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.remove();
                    totalRows = document.querySelectorAll('#inquiryBody tr').length;
                    totalPages = Math.ceil(totalRows / rowsPerPage);
                    // Refresh current page
                    goToPage(currentPage);
                }
            }
        }

        // ===== INITIALIZE =====
        document.addEventListener('DOMContentLoaded', function() {
            goToPage(1);
        });
    </script>
</body>

</html>