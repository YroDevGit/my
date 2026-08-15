<?php
use Classes\Ctrx;
?>
 <!-- ===== SIDEBAR ===== -->
 <nav class="sidebar" id="sidebar">
     <!-- brand -->
     <div class="sidebar-brand d-flex align-items-center">
         <i class="fas fa-code brand-icon"></i>
         <span class="brand-text">CodeYro</span>
     </div>

     <!-- navigation -->
     <div class="mt-2">
         <div class="nav-section-title">Main</div>
         <a href="#" class="nav-link <?=active_class('auth/dashboard')?>">
             <i class="fas fa-th-large"></i>
             <span class="nav-text">Dashboard</span>
         </a>
         <a href="#" class="nav-link">
             <i class="fas fa-project-diagram"></i>
             <span class="nav-text">Projects</span>
         </a>
         <a href="#" class="nav-link">
             <i class="fas fa-users"></i>
             <span class="nav-text">Clients</span>
         </a>
         <a href="/auth/inquiries" class="nav-link <?=active_class('auth/inquiries')?>">
             <i class="fas fa-users"></i>
             <span class="nav-text">Inquiries</span>
         </a>
         <a href="/auth/notes" class="nav-link <?=active_class('auth/notes')?>">
             <i class="fa fa-sticky-note"></i>
             <span class="nav-text">Notes</span>
         </a>
         <a href="#" class="nav-link">
             <i class="fas fa-tasks"></i>
             <span class="nav-text">Tasks</span>
         </a>

         <div class="nav-section-title mt-3">Management</div>
         <a href="#" class="nav-link">
             <i class="fas fa-server"></i>
             <span class="nav-text">Hosting</span>
         </a>

         <div class="nav-section-title mt-3">Support</div>
         <?php if (Ctrx::get_user_role() == "SA"): ?>
             <a href="/ctrxtools" class="nav-link">
                 <i class="fas fa-question-circle"></i>
                 <span class="nav-text">Help</span>
             </a>
         <?php endif; ?>
         <a href="#" class="nav-link logout-btn">
             <i class="fas fa-sign-out-alt"></i>
             <span class="nav-text">Logout</span>
         </a>
     </div>
 </nav>

 <?=js("_auth/sidebar")?>