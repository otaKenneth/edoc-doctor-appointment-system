<div id="popup1" class="overlay popup-closed">
    <div class="popup">
        <center>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content" style="max-height: 400px; overflow-y: auto;">
                <div style="display: flex;justify-content: center;">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td class="label-td" colspan="2"></td>
                        </tr>

                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add
                                    New Session.</p><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <form id="add-session" method="POST" class="add-new-form">
                                    <label for="title" class="form-label">Session Title : </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="title" class="input-text" placeholder="Name of this Session"
                                    required><br>
                            </td>
                        </tr>
                        <tr>

                            <td class="label-td" colspan="2">
                                <label for="docid" class="form-label">Select Doctor: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <select name="docid" id="" class="box">
                                    <option value="" disabled selected hidden>Choose Doctor Name from the list</option>
                                    <?php
                                    $list11 = $database->query("select * from doctor order by docname asc;");

                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                        $row00 = $list11->fetch_assoc();
                                        $sn = $row00["docname"];
                                        $id00 = $row00["docid"]; ?>
                                            <option value="<?=$id00?>"><?=$sn?></option>
                                    <?php } ?>
                                </select><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nop" class="form-label">Number of Patients/Appointment Numbers : </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="number" name="nop" class="input-text" min="0"
                                    placeholder="The final appointment number for this session depends on this number"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="date" class="form-label">Session Date: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="date" name="date" class="input-text" min="'.date('Y-m-d').'" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="time" class="form-label">Schedule Time: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="time" name="time" class="input-text" placeholder="Time" required></form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
        <div class="popup-footer">
            <input type="reset" value="Reset"
                class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <input type="submit" form="add-session" value="Place this Session" class="login-btn btn-primary btn"
                name="shedulesubmit">
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Add Session
        $('form#add-session').on("submit", function (el) {
            el.preventDefault();
            var form_data = utils.serializeArrayToJSON($(this).serializeArray());

            $.ajax({
                url: "apis/index.php/addSession",
                method: "POST",
                data: form_data,
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var dialog = $(this).closest('.overlay')
                        $(dialog).removeClass('popup-open');
                        $(dialog).addClass('popup-closed');
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Error message: ' + xhr.statusText);
                    let response = JSON.parse(xhr.responseText);
                    showErrorToast([response.message]);
                }
            });
        })

        // Delete Appoointment
        $('.non-style-link.yes').click(function (ev) {
        })
    })
</script>