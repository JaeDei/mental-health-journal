<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="admin-mhj.php" class="brand-link">
    <img src="../../assets/images/mhj-logo.jpg" alt="Logo" class="brand-image img-circle elevation-2" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../assets/profile_img/<?php echo $fetch['profile_pic'];?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="admin-profile.php" class="d-block"><?php echo $fetch['firstname'];?>  <?php echo $fetch['lastname'];?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="admin-mhj.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="journal-entries.php" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Students Journals
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="journal-entries.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Journal Entries</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="daily-entries.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daily Journal Entries</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="calendar.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Calendar
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="achievement.php" class="nav-link">
            <i class="nav-icon fas fa-star"></i>
            <p>
              Achievements
            </p>
          </a>
        </li>
        <br>
        <li class="nav-item">
          <a href="../../logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>

      </ul>
    </nav>
  <!-- /.sidebar-menu -->
  </div>
<!-- /.sidebar -->
</aside>