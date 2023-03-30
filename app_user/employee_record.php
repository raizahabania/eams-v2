<?php
include '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

if (!($g_user_role == "END_USER")) {
    return_role($g_user_role);
}
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

<script>
  <?php ## sweetalert msg session
  $msg_success = $session_class->getValue('msg_success');
  if (isset($msg_success) && $msg_success != "") {
    echo "success_notif('" . $msg_success . "');";
    $session_class->dropValue('msg_success');
  }
  $msg_error = $session_class->getValue('msg_error');
  if (isset($msg_error) && $msg_error != "") {
    echo "error_notif('" . $msg_error . "');";
    $session_class->dropValue('msg_error');
  }
  ?>
</script>

</html>