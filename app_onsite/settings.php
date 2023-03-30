<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="settingsModalToggleLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo BASE_URL; ?>app_onsite/process.php" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="settingsModalToggleLabel"><i class="bi bi-gear-fill"></i>&ensp;Default Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <span id="mess"></span>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label for="building" class="form-label">Place</label>
                            <input type="text" name="building" value="" id="building" class="form-control bg-light" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-6 mb-3">
                            <label for="timeIn" class="form-label">Time In</label>
                            <input type="time" name="timeIn" value="" class="form-control bg-light" id="timeIn" disabled>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="timeOut" class="form-label">Time Out</label>
                            <input type="time" name="timeOut" value="" class="form-control bg-light" id="timeOut" disabled>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>