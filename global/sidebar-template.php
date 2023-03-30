<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'index' ? '' : 'collapsed'; ?>" href="index.html">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            
            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'employee_record' ? '' : 'collapsed'; ?>" href="<?php echo BASE_URL; ?>app_main/employee_record.php">
                    <i class="bi bi-person-square"></i>
                    <span>My Attendance</span>
                </a>
            </li><!-- End My Attendance Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'dropdown1' ? '' : 'collapsed'; ?>" data-bs-target="#dropdown1-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Dropdown 1</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dropdown1-nav" class="nav-content <?php echo $activePage == 'dropdown1' ? '' : 'collapse'; ?> " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="components-alerts.html">
                            <i class="bi bi-circle"></i><span>Option 1</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-accordion.html">
                            <i class="bi bi-circle"></i><span>Option 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-badges.html">
                            <i class="bi bi-circle"></i><span>Option 3</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-breadcrumbs.html">
                            <i class="bi bi-circle"></i><span>Option 4</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-buttons.html">
                            <i class="bi bi-circle"></i><span>Option 5</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-cards.html">
                            <i class="bi bi-circle"></i><span>Option 6</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'dropdown2' ? '' : 'collapsed'; ?>" data-bs-target="#dropdown2-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Dropdown 2</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dropdown2-nav" class="nav-content <?php echo $activePage == 'dropdown2' ? '' : 'collapse'; ?> " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="forms-elements.html">
                            <i class="bi bi-circle"></i><span>Option 1</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-layouts.html">
                            <i class="bi bi-circle"></i><span>Option 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-editors.html">
                            <i class="bi bi-circle"></i><span>Option 3</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Dropdown 2 Nav -->

            <li class="nav-heading">Page Divider (Title)</li>

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'module1' ? '' : 'collapsed'; ?>" href="users-profile.html">
                    <i class="bi bi-person"></i>
                    <span>Module 1</span>
                </a>
            </li><!-- End Module 1 Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'module2' ? '' : 'collapsed'; ?>" href="pages-faq.html">
                    <i class="bi bi-question-circle"></i>
                    <span>Module 2</span>
                </a>
            </li><!-- End Module 2 Page Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo $activePage == 'module3' ? '' : 'collapsed'; ?>" href="pages-contact.html">
                    <i class="bi bi-envelope"></i>
                    <span>Module 3</span>
                </a>
            </li><!-- End Module 3 Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->