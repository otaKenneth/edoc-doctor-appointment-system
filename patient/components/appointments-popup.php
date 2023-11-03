<div id="dialog-cancel" class="overlay popup-closed">
    <div class="popup">
        <center>
            <h2>Are you sure?</h2>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content">
                You want to Cancel this Appointment?<br><br>
                Session Name: &nbsp;<b data-value="title"></b><br>
                Doctor name&nbsp; : <b data-value="doc"></b><br><br>
            </div>
            <div style="display: flex;justify-content: center;">
                <a href="#" 
                    class="non-style-link" onclick="cancelAppointment(this)">
                    <button class="btn-primary btn" 
                        style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                        <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                    </button>
                </a>&nbsp;&nbsp;&nbsp;
                <a href="#" class="non-style-link popup-closer">
                    <button class="btn-primary btn" 
                        style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                        <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                    </button>
                </a>
            </div>
        </center>
    </div>
</div>

<script>
    function cancelAppointment(el) {
        var parent = $(el).closest('.overlay')[0];
        var data_id = $(parent).attr('data-id')
        var dialogId = $(parent).attr('id');

        $.ajax({
            url: "apis/index.php/Appointments/cancelAppointment",
            method: "POST",
            data: JSON.stringify({
                id: data_id
            }),
            contentType: "application/json",
            success: (response) => {
                if (response.success) {
                    utils.closeDialog($(`#${dialogId}`))
                    showSuccessToast(response.message)
                    utils.pageReload(4500)
                }
            },
            error: (xhr, textStatus, th) => {
                // Handle error response
                console.error('Error message: ' + xhr.statusText);
                let response = JSON.parse(xhr.responseText);
                showErrorToast([response.message]);
            }
        })
    }
</script>