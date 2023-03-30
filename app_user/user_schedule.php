<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$page_title = "Employee Schedule";

if (!($g_user_role == "END_USER")) {
    return_role($g_user_role);
}
$fullname = $session_class->getValue('fullname');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include_once DOMAIN_PATH . '/global/meta_data.php'; //meta
  include_once DOMAIN_PATH . '/global/include_top.php'; //links
  ?>

</head>
<style>
  #schedule_datatable td:not(:first-child) {
    text-align: center;
  }

  td {
    border: .5px solid;
  }

  th {

    position: sticky;
    top: 0;
    /* Don't forget this, required for the stickiness */
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    background: white !important;
    color: black;
  }

  @media (min-width: 576px) {
    .modal-dialog {
      max-width: 1240px;
      margin: 1.75rem auto;
    }

    .dataTables_info {
      display: none;
    }
  }

  td {
    border: none;
  }

  .message {
    display: none;
    color: red;
    text-align: center;
  }
</style>

<body data-layout="detached">
  <!-- HEADER -->
  <?php
  include_once DOMAIN_PATH . '/global/header.php'; //header
  include_once DOMAIN_PATH . '/global/sidebar.php'; //sidebar
  ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>User Schedule</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_user/index.php">Home</a></li>
          <li class="breadcrumb-item active">User Schedule</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->



    <section class="section">
      <div class="card">
        <div class="card-header bg-primary text-white fw-semibold" style="font-size: large;">
          <i class="bi-calendar2-week"></i>&ensp;Employee Schedule <br>Name: <span class="schedule_name"><?php echo $fullname; ?></span>
        </div>

        <div class="card-body mt-3" style="height:500px;overflow:auto;">
          <table id="schedule_datatable" class="table table-striped cell-border" style="width:100%">
            <thead>
              <th>Time</th>
              <th>Sunday</th>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
              <th>Thursday</th>
              <th>Friday</th>
              <th>Saturday</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>



  <?php 
  include_once DOMAIN_PATH . '/global/include_bottom.php'; //scripts
  include_once FOOTER_PATH; //footer 
  ?>
</body>

<script>
  const employee_id ="<?php echo $employee_id;?>"
 load_schedule(employee_id)

    function load_schedule(employee_id) {
      $('#schedule_datatable').DataTable().destroy();
      var dataTable = $('#schedule_datatable').DataTable({
        "processing": true,
        "searching": false,
        "serverSide": true,
        "paging": false,
        "ordering": false,
        'order': [
          [1, 'desc']
        ],
        "ajax": {
          url: "<?php echo BASE_URL; ?>global_process/schedule_table.php",
          type: "POST",
          data: {
            employee_id: employee_id
          },
        },
      });
 

  }
</script>

</html>