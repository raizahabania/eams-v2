<form action="" id="att-log-frm">
  <div class="text-center text-black mb-5">
    <div id="nowTime" class="text-secondary font-monospace" style="font-size: 32pt; font-weight: 800;"></div>
    <div id="nowDate" class="text-secondary" style="font-size: 24pt; font-weight: 500;"></div>
  </div>

  <input type="hidden" id="attendance_time" name="attendance_time">
  <input type="hidden" id="attendance_date" name="attendance_date">
  <div class=" form-group col-xs-12 col-sm-12 col-lg-12">
    <h5>Enter your Employee Number</h5>
    <input type="text" id="id_number" name="id_num" class="form-control col-sm-12" required>
  </div>

  <div class="btn-group d-flex mt-4" role="group">
    <button type="submit" class="btn btn-primary rounded bg-navy" id="time-in-btn" value="time-in">TIME IN</button>
    <button type="submit" class="btn btn-primary rounded bg-navy" id="time-out-btn" style="margin-left: 10px;" value="time-out">TIME OUT</button>
  </div>
</form>