<?php $activePage = ACTIVE_PAGE; //for active page (e.g. "index") 
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Navigation</li>

        <?php if ($g_user_role == 'ADMIN') { ?> <!-- admin navigation -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'index' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/index.php">
                    <i class="bi bi-person-square"></i>
                    <span>My Attendance</span>
                </a>
            </li><!-- End My Attendance Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'user_management' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL ?>app_main/user_management.php">
                    <i class="bi bi-people-fill"></i>
                    <span>User Management</span>
                </a>
            </li><!-- End User Management Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_list' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/employee_list.php">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>List of Employee</span>
                </a>
            </li><!-- End List of Employee Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_schedule' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/employee_schedule.php">
                    <i class="bi bi-calendar-week-fill"></i>
                    <span>Employee Schedule</span>
                </a>
            </li><!-- End Employee Schedule Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_attendance' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/employee_attendance.php">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Employee Record</span>
                </a>
            </li><!-- End Employee Record Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'report' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/report.php">
                    <i class="bi bi-person-fill"></i>
                    <span>Employee Report</span>
                </a>
            </li><!-- End Employee Report Page Nav -->
            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'building' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/building.php">
                    <i class="bi bi-menu-button-fill"></i>
                    <span>Building Management</span>
                </a>
            </li><!-- End Building Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'building' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/new.php">
                    <i class="bi bi-menu-button-fill"></i>
                    <span>NEW</span>
                </a>
            </li><!-- End Building Page Nav -->

            
        <?php } elseif ($g_user_role == 'ADMIN_STAFF') { ?> <!-- admin staff navigation -->
            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'index' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/index.php">
                    <i class="bi bi-person-square"></i>
                    <span>My Attendance</span>
                </a>
            </li><!-- End My Attendance Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_list' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/employee_list.php">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>List of Employee</span>
                </a>
            </li><!-- End List of Employee Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_attendance' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/employee_attendance.php">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Employee Record</span>
                </a>
            </li><!-- End Employee Record Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'report' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/report.php">
                    <i class="bi bi-person-fill"></i>
                    <span>Employee Report</span>
                </a>
            </li><!-- End Employee Report Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_schedule' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/employee_schedule.php">
                    <i class="bi bi-calendar-week-fill"></i>
                    <span>Employee Schedule</span>
                </a>
            </li><!-- End Module 3 Page Nav -->
            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'physical_checking' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_admin/physical_checking.php">
                    <i class="bi-list-check"></i>
                    <span>Physical Checking</span>
                </a>
            </li><!-- End Module 3 Page Nav -->


        <?php } elseif ($g_user_role == 'END_USER') { ?> <!-- end user navigation -->
            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'index' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_user/index.php">
                    <i class="bi bi-person-square"></i>
                    <span>My Attendance</span>
                </a>
            </li><!-- End My Attendance Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'user_schedule' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_user/user_schedule.php">
                    <i class="bi bi-person-square"></i>
                    <span>My Schedule</span>
                </a>
            </li><!-- End My Attendance Page Nav -->
        <?php } ?>

    </ul>
</aside><!-- End Sidebar-->