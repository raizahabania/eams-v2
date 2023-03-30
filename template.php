<?php
require 'config/config.php';

?>
<!DOCTYPE html>
<html lang="<?php echo LANG; ?>" class="h-100">

<head>
  <?php
  include DOMAIN_PATH . "/global/meta_data.php";
  include DOMAIN_PATH . "/global/include_top.php";
  ?>
</head>

<body class="d-flex flex-column h-100">
  <?php
  include DOMAIN_PATH . "/global/header.php";
  include DOMAIN_PATH . "/global/sidebar.php";
  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

    </section>

  </main><!-- End #main -->

  <?php
  include DOMAIN_PATH . "/global/footer.php";
  include DOMAIN_PATH . "/global/include_bottom.php";
  ?>
</body>

</html>