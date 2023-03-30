<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<header>
    <nav class="navbar navbar-dark navbar-expand-md sticky-top shadow py-3 bgc-navCCC">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="platformSG.php">
                <span class="bs-icon-lg bs-icon-rounded d-flex justify-content-center align-items-center me-2 bs-icon">
                    <img class="img-fluid" width="100%" src="<?php echo BASE_URL; ?>assets/img/logo-light.png">
                </span>
                <span>Employee Attendance Monitoring System</span>
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3">
                <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link <?php echo $activePage == 'index' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>app_onsite/index.php">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link <?php echo $activePage == 'timeLog' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>app_onsite/timeLog.php">Time Log</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link settings" id="settings">Default Settings</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>logout.php" role="button">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>