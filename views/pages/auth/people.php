<?php

use Classes\Collection;
use Tables\Roles;
use Tables\Task;
use Tables\Users;

$roles = Roles::getAll();

$where = [];

$searchName = get("q");
if($searchName){
    $where["or"]['like'] = [
        "fname" => $searchName,
        "lname" => $searchName
    ];
}
$searchRole = get_decrypt("role");
if($searchRole){
    $where["type"] = $searchRole;
}
$page = get("page") || 1;
$result = Users::paginatedFind($where, $page);
$users = $result['data'];
$pagination = $result['pagination'];

$getRole = function($roleId) use ($roles){
    $d = Collection::data($roles)->equal(["id"=>$roleId])->exec();
    if($d){
        return $d[0];
    }else{
        return [];
    }
};

function countTask($userId){
    $count = Task::count(["assign"=>$userId, "status <"=>7]);
    return $count ?? 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeYro · Employees</title>
    <?= _bootstrap_css() ?>
    <?= assets_css("auth") ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .err-field {border-color: #dc3545; background: #fff5f5;}
        .err-field:hover {border-color: #bbb;}
    </style>
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
                    <h4 class="fw-bold mb-1 text-dark">Team Members</h4>
                    <p class="text-secondary small mb-0">Manage your development team</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-filter me-2"></i>Filter
                    </a>
                    <a href="#" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="fas fa-user-plus me-2"></i>Add Employee
                    </a>
                </div>
            </div>

            <!-- stats row -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                            <div>
                                <div class="stat-value">12</div>
                                <div class="stat-label">Total Employees</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                            <div>
                                <div class="stat-value">8</div>
                                <div class="stat-label">Active</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon orange"><i class="fas fa-user-clock"></i></div>
                            <div>
                                <div class="stat-value">3</div>
                                <div class="stat-label">On Leave</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon purple"><i class="fas fa-user-graduate"></i></div>
                            <div>
                                <div class="stat-value">1</div>
                                <div class="stat-label">New Hires</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- search & filter -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <div class="flex-grow-1" style="max-width: 300px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input id="nameSearch" value="<?=$searchName?>" type="text" class="form-control bg-light border-start-0 rounded-end-pill"
                            placeholder="Search employees...">
                    </div>
                </div>
                <select class="form-select form-select-sm rounded-pill" id="roleSearch" style="width: auto; min-width: 140px;">
                    <option value="">All Roles</option>
                    <?php foreach($roles as $k=>$v): ?>
                      <option 
                      <?php if($searchRole){echo $v['id'] == $searchRole ? "selected" : "";} ?>
                      value="<?=encrypt($v['id'])?>"><?= $v['role_desc'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-primary searchbtn">Search</button>
            </div>

            <!-- employees grid -->
            <div class="row g-3">
            <?php foreach($users as $k=>$v): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: 700; color: #1b3a6b;">
                                    JD
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold mb-0"><?=val($v['fname'], "")." ".val($v['lname'], "")?></h6>
                                            <span class="text-secondary small"><?= $getRole($v['type'])['role_desc'] ?></span>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal"><i class="fas fa-eye me-2"></i>View</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Active</span>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">Full-time</span>
                                    </div>
                                    <div class="d-flex gap-3 mt-2">
                                        <span class="text-secondary small"><i class="fas fa-envelope me-1"></i><?= val($v['email']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary small">Task</span>
                                <span class="fw-semibold small usertask-count"><?= countTask($v['id']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary small">Joined</span>
                                <span class="small">Jan 2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>

            <!-- pagination -->
            <div class="d-flex flex-wrap align-items-center justify-content-between mt-3 pt-2">
                <div class="text-secondary small">
                    Showing 1-6 of 12 employees
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

        <?= include_page("auth/footer") ?>

    </div>

    <!-- ===== ADD EMPLOYEE MODAL ===== -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="addEmployeeForm">
                <div class="modal-content rounded-4">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2 text-primary"></i>Add New Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">First Name</label>
                                <input type="text" name="fname" class="form-control rounded-pill" placeholder="First name">
                                <?= error_text("fname") ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Last Name</label>
                                <input type="text" name="lname" class="form-control rounded-pill" placeholder="Last name">
                                <?= error_text("lname") ?>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-pill" placeholder="email@company.com">
                            <?= error_text("email") ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Phone Number</label>
                            <input type="text" name="phone" class="form-control rounded-pill" placeholder="+1 (555) 000-0000">
                            <?= error_text("phone") ?>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Role</label>
                                <select class="form-select rounded-pill" name="role">
                                    <option value="">SELECT ROLE</option>
                                    <?php foreach ($roles as $k => $v): ?>
                                        <?php if ($v['id'] == 1) continue; ?>
                                        <option value="<?= encrypt($v['id']) ?>"><?= val($v['role_desc']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= error_text("role") ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Status</label>
                                <select class="form-select rounded-pill" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <?= error_text("status") ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Add Employee</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== VIEW EMPLOYEE MODAL ===== -->
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user me-2 text-primary"></i>Employee Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto"
                            style="width: 80px; height: 80px; font-size: 2rem; font-weight: 700; color: #1b3a6b;">
                            JD
                        </div>
                        <h5 class="fw-bold mt-2">John Doe</h5>
                        <span class="text-secondary small">Lead Developer</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <span class="text-secondary small d-block">Email</span>
                            <span class="small">john@codeyro.dev</span>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary small d-block">Phone</span>
                            <span class="small">+1 (555) 123-4567</span>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary small d-block">Status</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Active</span>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary small d-block">Type</span>
                            <span class="small">Full-time</span>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary small d-block">Joined</span>
                            <span class="small">Jan 2024</span>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary small d-block">Projects</span>
                            <span class="small">4</span>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold small">Skills</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">React</span>
                        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">Node.js</span>
                        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">PostgreSQL</span>
                        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">AWS</span>
                        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">TypeScript</span>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== EDIT EMPLOYEE MODAL ===== -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-primary"></i>Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">First Name</label>
                                <input type="text" class="form-control rounded-pill" value="John">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Last Name</label>
                                <input type="text" class="form-control rounded-pill" value="Doe">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" class="form-control rounded-pill" value="john@codeyro.dev">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Phone Number</label>
                            <input type="text" class="form-control rounded-pill" value="+1 (555) 123-4567">
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Role</label>
                                <select class="form-select rounded-pill">
                                    <option value="developer" selected>Developer</option>
                                    <option value="designer">Designer</option>
                                    <option value="manager">Manager</option>
                                    <option value="qa">QA Engineer</option>
                                    <option value="devops">DevOps</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Employment Type</label>
                                <select class="form-select rounded-pill">
                                    <option value="full-time" selected>Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="contract">Contract</option>
                                    <option value="intern">Intern</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label fw-semibold small">Status</label>
                            <select class="form-select rounded-pill">
                                <option value="active" selected>Active</option>
                                <option value="on-leave">On Leave</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Skills</label>
                            <input type="text" class="form-control rounded-pill" value="React, Node.js, PostgreSQL, AWS, TypeScript">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <?= _bootstrap_js() ?>
</body>

</html>