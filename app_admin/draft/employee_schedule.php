<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$page_title = "Employee Schedule";

if (!($g_user_role == "ADMIN_STAFF")) {
    return_role($g_user_role);
}

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
      <h1>Employee Schedule</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>app_admin/index.php">Home</a></li>
          <li class="breadcrumb-item active">Employee Schedule</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white fw-semibold" style="font-size: large;">
          <div>
            <i class="bi-calendar2-week"></i>&ensp;Employee List
          </div>
          <div>
            <button type="button" id="add_new" class="btn btn-outline-light btn-rounded btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#add_schedule">
              <i class="bi bi-plus-circle"></i>&ensp;Add Schedule
            </button>
            <button class="btn btn-outline-light btn-rounded alignToTitle btn-rounded btn-sm ml-1" id="bulk_insert_btn" data-bs-toggle="modal" data-bs-target="#upload_csv_finance"><i class="bi bi-arrow-bar-up bulk"></i>&ensp;Add Bulk Schedule</button>
          </div>
        </div>
        <div class="card-body mt-3">
          <div id="schedule-table"></div>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="card">
        <div class="card-header bg-primary text-white fw-semibold" style="font-size: large;">
          <i class="bi-calendar2-week"></i>&ensp;Employee Schedule <br>Name: <span class="schedule_name"></span>
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
  </main><!-- End #main -->

  <!-- Add schedule -->
  <div class="modal fade" id="add_schedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="schedule_frm">
          <div class="modal-body">
            <div class="row g-2">
              <div class="col-md">
                <div class="form-floating">
                  <input type="text" class="form-control employee_name" id="floatingInputGrid" placeholder="Employee Name" required>
                  <label for="floatingInputGrid">Employee Name</label>
                </div>
              </div>
            </div>

            <div class="m-2">
              <button id="add" class="btn btn-outline-dark btn-rounded " type="button"><i class="bi bi-plus-circle"></i> Add row</button>
            </div>
            <div class="table_add_container" style="overflow:auto">
              <div class='message'>time invalid</div>
              <table class="table table-bordered" id="crud_table">
                <tr>
                  <th>Section</th>
                  <th>Room Number</th>
                  <th>Subject Name</th>
                  <th>Subject Code</th>
                  <th>Day</th>
                  <th>Start time</th>
                  <th>End time</th>
                  <th>Remove</th>
                </tr>
                <tr>
                  <td><input type='text' class="section" required></td>
                  <td><input type='text' class="room_number" required></td>
                  <td><input type='text' class="subject_name" required></td>
                  <td><input type='text' class="subject_code" required></td>
                  <td> <select class='day' required>
                      <option selected='selected' disabled='true' value=''>--Please Select --</option>
                      <option value='0'>Sunday</option>
                      <option value='1'>Monday</option>
                      <option value='2'>Tuesday</option>
                      <option value='3'>Wednesday</option>
                      <option value='4'>Thursday</option>
                      <option value='5'>Friday</option>
                      <option value='6'>Saturday</option>
                    </select>
                  </td>
                  <td><input type='time' class="start_time" required></td>
                  <td><input type='time' class="end_time" required></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END schedule Modal -->

  <!-- Bulk Modal -->
  <div class="modal fade" id="upload_csv_finance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Bulk Insert Schedule</h5>
          <button type="button" class="btn-close" id="close_csv_upload" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <a id="template" href="<?php echo BASE_URL; ?>global_process/download.php?path=<?php echo EMP_SCHED_LIST; ?>">
            <button class="btn btn-outline-primary btn-rounded alignToTitle btn-sm mb-2"><i class="bi bi-download"></i>&ensp;Download Template</button>
          </a>
          <form autocomplete="off" id="bulk_upload_frm" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" id="bulk_insert" class="dropify" styles="height:500px" data-default-file="" name="bulk_insert" accept="text/*" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submit_bulk">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!---- alert modal rows-->
  <div class="modal fade" id="row_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="alert alert-danger m-0 pb-0 pt-2 py-1" style="border-left: solid 5px red; border-radius:0 5px 5px 0;" id="staticBackdropLabel" role="alert">
            <h6><strong><i class="bi bi-exclamation-octagon" style="font-size:18px;"></i>&ensp;Invalid CSV file. Please input new CSV file</strong></h6>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="bulk_modal_body" style="overflow:auto;">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#upload_csv_finance">Upload Another</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  include_once DOMAIN_PATH . '/global/include_bottom.php'; //scripts
  include_once FOOTER_PATH; //footer 
  ?>
</body>

<script>
  var bulk_insert = $('#bulk_insert').dropify({});
  bulk_insert = bulk_insert.data('bulk_insert');
  $("#bulk_insert").change(function() {
    var file = this.files[0];
    var fileType = file.type;
    var match = ['text/csv'];
    if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
      Toast.fire({
        background: '#bd362f',
        icon: 'error',
        title: 'Not a Csv file!',
        text: 'Only Csv file allowed',
        timer: 1500
      })
      $('.dropify-clear').click();
      return false;
    }
  });

  $("#bulk_upload_frm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "<?php echo BASE_URL; ?>global_process/upload_bulk.php",
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#submit_bulk").attr("disabled", true);
        $('#submit_bulk').html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $(".close_csv_upload").attr("disabled", true);
      },
      complete: function() {
        $('#submit_bulk').html('Submit');
        $('#submit_bulk').removeAttr('disabled');
        $(".close_csv_upload").removeAttr('disabled');
      },
      success: function(response) {
        if (response.error == true) {
          var html_code = "<table class='table table-striped'>";
          html_code += "<thead>";
          html_code += "<tr class='border-bottom'><th class='border-0'>#</th>";
          html_code += "<th class='border-0'>Employee ID</th>";
          html_code += " <th class='border-0'>Day</th>";
          html_code += "<th class='border-0'>Start Time</th>";
          html_code += "<th class='border-0'>End Time</th>";
          html_code += " <th class='border-0'>Section</th>";
          html_code += "<th class='border-0'>Room</th>";
          html_code += "<th class='border-0'>Subject Name</th>";
          html_code += "<th class='border-0'>Subject Code</th>";
          html_code += "<th class='border-0'>Remarks</th></tr></thead>";
          html_code += "<tbody>" + response.row.join('') + "</tbody></table>";
          bulk_modal_body
          $('#upload_csv_finance').modal('hide');
          $('#row_modal').modal('show');
          $('#bulk_modal_body').html(html_code);
          $('.dropify-clear').click();
        }
        if (response.message == "success") {
          $('.dropify-clear').click();
          Toast.fire({
            title: '<span style="color:white">Record has been Added!</span>',
            background: '#51a351',
            icon: 'success',
            timer: 3000
          });
          $('#upload_csv_finance').modal('hide');
        }
        if (response.message == "empty") {
          $('.dropify-clear').click();
          swal.fire({
            title: 'This Csv is Empty!',
            icon: 'error',
            timer: 3000
          });
        }
      },
    });
  });

  (function() {
    // object for passing employeed id ;
    var employee_ids = {};

    var count = 1;
    $('#add').click(function() {
      count = count + 1;
      var html_code = "<tr id='" + count + "'>";
      html_code += "<td><input type='text' class='section' required></td>";
      html_code += "<td><input type='text' class='room_number' required></td>";
      html_code += "<td><input type='text' class='subject_name' required></td>";
      html_code += "<td><input type='text' class='subject_code'required ></td>";
      html_code += "<td> <select class='day' required><option selected='selected' disabled='true' value=''>--Please Select --</option>";
      html_code += "<option value='0'>Sunday</option>";
      html_code += "<option value='1'>Monday</option>";
      html_code += "<option value='2'>Tuesday</option>";
      html_code += "<option value='3'>Wednesday</option>";
      html_code += "<option value='4'>Thursday</option>";
      html_code += "<option value='5'>Friday</option>";
      html_code += "<option value='6'>Saturday</option></select></td>";
      html_code += "<td><input type='time' class='start_time' required></td>";
      html_code += "<td><input type='time' class='end_time' required></td>";
      html_code += "<td><button type='button' name='remove' data-row='" + count + "' class='btn btn-outline-danger btn-sm remove'>Remove</button></td>";
      html_code += "</tr>";
      $('#crud_table').append(html_code);
    });

    $(document).on('click', '.remove', function() {
      var delete_row = $(this).data("row");
      $('#' + delete_row).remove();
    });

    var total_record = 0;

    function record_details(values, data, calcParams) {
      if (values && values.length) {
        return values.length + ' of ' + total_record;
      }
    }

    $("#schedule_frm").on('submit', function(e) {

      e.preventDefault();
      var content = [];
      var row = [];

      var table = document.getElementById('crud_table');
      var rows = table.rows;
      var datas = [];
      for (var i = 0; i < rows.length; i++) {
        var rowTr = rows[i];
        rows[i].setAttribute('id', i);
        if (i == 0) continue;

        var temp = {};
        temp['section'] = "";
        temp['room_number'] = "";
        temp['subject_name'] = "";
        temp['subject_code'] = "";
        temp['day'] = "";
        temp['start_time'] = "";
        temp['end_time'] = "";

        var section = rowTr.getElementsByClassName('section')[0].value;
        if (section) { // exisiting element
          temp['section'] = section;
        }
        var room_number = rowTr.getElementsByClassName('room_number')[0].value;
        if (room_number) {
          temp['room_number'] = room_number;
        }
        var subject_name = rowTr.getElementsByClassName('subject_name')[0].value;
        if (subject_name) { // exisiting element
          temp['subject_name'] = subject_name;
        }
        var subject_code = rowTr.getElementsByClassName('subject_code')[0].value;
        if (subject_code) {
          temp['subject_code'] = subject_code;
        }
        var day = rowTr.getElementsByClassName('day')[0].value;
        if (day) { // exisiting element
          temp['day'] = day;
        }
        var start_time = rowTr.getElementsByClassName('start_time')[0].value;
        if (start_time) {
          temp['start_time'] = start_time;
        }
        var end_time = rowTr.getElementsByClassName('end_time')[0].value;
        if (end_time) {
          temp['end_time'] = end_time;
        }
        temp['row_id'] = i;
        //additional data
        datas.push(temp);
        // console.log(rowTr);
      }

      var employee_id = $('.employee_name').val();
      // console.log(datas)
      const schedule = JSON.stringify(datas);

      $.ajax({
        url: "<?php echo BASE_URL; ?>global_process/add_schedule.php",
        method: "POST",
        data: {
          employee_id: employee_id,
          schedule: schedule
        },
        dataType: "json",
        success: function(response) {
          $('tr').css("border", "none");

          if (response.message == "low") {
            $(response.row_count).css("border", "solid red");
            $('.message').css("display", "block");
            $('.message').html("Start time must be greater than End  time");
          }
          if (response.message == "exist") {

            $(response.row_count).css("border", "solid red");
            $('.message').css("display", "block");
            $('.message').html("Time is not available");
          }
          if (response.message == "complete") {
            $('#schedule_frm')[0].reset();
            for (var i = 2; i <= count; i++) {
              $('#' + i + '').remove();
              $(".employee_name")[0].selectize.clear();
            }

            load_schedule(employee_id);
            Toast.fire({
              icon: 'success',
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              background: '#51a351',
              title: 'Schedule Added'
            })
            $('.message').css("display", "none");
          }

        }
      });
    });

    //selectize
    var employee_select = $(".employee_name").selectize({
      valueField: "employee_id",
      labelField: "name",
      searchField: "name",
      create: false,
      maxItems: 1,
      render: {
        option: function(item, escape) {
          return (
            "<div>" +
            "<span class='title'>" + escape(item.name) + "</span>" +
            '<p class="text-muted  m-0">' + escape(item.position) + "</p>" +
            "</div>"
          );
        },
        item: function(item, escape) {
          // (item.employee_id ? '<span class="name">' + escape(item.employee_id) + "</span>" : "") + ": " +
          return "<div>" + (item.name ? '<span class="name">' + escape(item.name) + "</span>" : "") + "</div>";
        },
      },
      load: function(query, callback) {
        if (!query.length) return callback();
        $.ajax({
          url: "<?php echo BASE_URL . 'global_process/user_selectize.php?data='; ?>" + encodeURIComponent(query),
          type: "GET",
          error: function() {
            callback();

          },
          success: function(res) {
            callback(res.data);
          },
        });
      },
    });

    var table = new Tabulator("#schedule-table", {
      ajaxSorting: false,
      ajaxFiltering: false,
      height: "auto",
      layout: "fitDataStretch",

      printAsHtml: true,
      headerFilterPlaceholder: "",
      layout: "fitColumns",
      placeholder: "No Data Found",
      movableColumns: true,
      selectable: false,
      ajaxURL: "<?php echo BASE_URL; ?>global_process/user_list_table.php",
      ajaxProgressiveLoad: "scroll",
      ajaxProgressiveLoadScrollMargin: 1,
      ajaxLoaderLoading: 'Fetching data from Database..',
      printConfig: {
        columnGroups: false,
        rowGroups: false,
      },
      columns: [{
          title: "Name",
          field: "name",
          align: "left",
          headerFilter: "input",
          headerFilterFunc: "like",
          headerFilterParams: {
            allowEmpty: true
          }
        },
        {
          title: "Employee Id",
          field: "employee_id",
          align: "left",
          headerFilter: "input",
          headerFilterFunc: "like",
          headerFilterParams: {
            allowEmpty: true
          }
        },
        {
          title: "Position",
          field: "position",
          align: "left",
          headerFilter: "input",
          headerFilterFunc: "like",
          headerFilterParams: {
            allowEmpty: true
          }
        },
        {
          title: "View Schedule",
          formatter: view_schedule,
          headerSort: false,
          headerFilter: false,
          download: false,
          print: false,
          hozAlign: "left",
          cellClick: function(e, cell) {
            cell.getRow().toggleSelect();
          }
        },
      ],
      ajaxResponse: function(url, params, response) {
        if (response.total_record) {
          total_record = response.total_record;
        }
        return response;
      },
      ajaxRequesting: function(url, params) {
        if (typeof this.modules.ajax.showLoader() != "undefined") {
          this.modules.ajax.showLoader();
        }
      },
    });

    function view_schedule(cell, formatterParams) {
      var cellEl = cell.getElement(); //get cell DOM element
      var linkBut = document.createElement("span");
      var employee_id = cell.getData().employee_id;
      employee_ids.id_num = cell.getData().employee_id;
      var name = cell.getData().name;
      linkBut.innerHTML = "<button type='button' class='btn btn-outline-primary btn-rounded btn-sm ml-1'  ><i class='bi bi-eye' title='update'></i> View Schedule</button>";
      addListener(linkBut, "click", function() {
        $('.schedule_name').html(name)
        load_schedule(employee_id);
      });

      return cellEl.appendChild(linkBut);
    }
    $(document).on({
      ajaxStart: function() {
        addClass(document.querySelector('body'), 'loading');
        isPaused = true;
      },
      ajaxStop: function() {
        removeClass(document.querySelector('body'), "loading");
        isPaused = false;
      }
    });

    function load_schedule(employee_id) {
      $('#schedule_datatable').DataTable().destroy();
      var dataTable = $('#schedule_datatable').DataTable({
        "processing": true,
        "searching": false,
        "serverSide": true,
        "paging": false,
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

    $('#schedule_datatable').on('click', '#remove_schedule ', function(event) {
      var schedule_id = $(this).data('id');
      var cell = $(this).closest('td')
      Swal.fire({
        title: 'Do you want to Delete this schedule?',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo BASE_URL; ?>global_process/remove_schedule.php",
            data: {
              schedule_id: schedule_id
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {
              //  load_schedule(employee_ids.id_num)
              Toast.fire({
                background: '#51a351',
                icon: 'success',

                title: 'Delete Success',
                timer: 3000
              })
              cell.html(' ');
            }
          });
        }
      })
    });
  })();
</script>

</html>