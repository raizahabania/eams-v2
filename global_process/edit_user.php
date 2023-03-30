
<style>
    .form-message{
        display: none;

    }
</style>
<div class="form-message alert alert-danger" role="alert"></div>
<div class="form-group">
<label>Employee Name</label>
<select name="employee_id" id="employee_id"></select> 
</div>

<div class="form-group">
<label>Date</label>
<input type="date" class="form-control" id="date_log" name="date_log">
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
        <label>Time In</label>
        <input type="time" class="form-control" name="time_in" id="in" >
        </div>
    </div>
    <div class="col">
        <div class="form-group">
        <label>Time Out</label>
        <input type="time" class="form-control" name="time_out" id="out">
    </div>
</div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
        <label>Break Out</label>
        <input type="time" class="form-control" name="break_out" id="bout">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
        <label>Break In</label>
        <input type="time" class="form-control" name="break_in" id="bin">
    </div>
</div>
</div>

