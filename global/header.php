<?php
$f_name = $session_class->getValue('f_name');
$m_name = $session_class->getValue('m_name');
$l_name = $session_class->getValue('l_name');
$suffix = $session_class->getValue('suffix');
$fullname = $session_class->getValue('fullname');
$name = substr($f_name, 0, 1) . '.' . ' ' . ($m_name != '' || $m_name != null ? substr($m_name, 0, 1) . '.' : '') . ' ' . $l_name . ' ' . $suffix;
$position = $session_class->getValue('position');
$photo = $session_class->getValue('photo');
$role = $session_class->getValue('role_id');
$user_id = $session_class->getValue('user_id');

?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    <?php if($role!='END_USER') {?>
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="<?php echo BASE_URL; ?>assets/img/logo-light.png" alt="">
            <span class="d-none d-lg-block"><?php echo PAGE_TITLE;  ?> </span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <?php } else{ ?>
       
            <a href="<?php echo BASE_URL?>/app_user/index.php" class="logo d-flex align-items-center">
            <img src="<?php echo BASE_URL; ?>assets/img/logo-light.png" alt="">
            <span class="d-none d-lg-block"><?php echo PAGE_TITLE; ?></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
            <?php }  ?>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
        

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?php echo BASE_URL . "assets/img/" . $photo . "?v=" . FILE_VERSION; ?>" alt="" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $name; ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $fullname; ?></h6>
                        <span><?php echo $position; ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_URL; ?>user-profile.php?v=<?php echo FILE_VERSION;?>">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_URL; ?>logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->