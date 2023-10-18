<div id="popup1" class="overlay popup-closed">
    <div class="popup">
        <center>
            <a class="close popup-closer" href="schedule.php">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
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
                                <form action="add-session.php" method="POST" class="add-new-form">
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
                                    <br />
                                    <?php
                                    $list11 = $database->query("select * from doctor;");

                                    for ($y=0;$y<$list11->num_rows;$y++){
                                        $row00=$list11->fetch_assoc();
                                        $sn=$row00["docname"];
                                        $id00=$row00["docid"]; ?>
                                        <option value=".$id00.">$sn</option><br />
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
                                <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset"
                                    class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <input type="submit" value="Place this Session" class="login-btn btn-primary btn"
                                    name="shedulesubmit">
                            </td>

                        </tr>

                        </form>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
        <br><br>
    </div>
</div>

<div id="popup2" class="overlay popup-closed popup-view">
    <div class="popup">
        <center>
            <h2></h2>
            <a href="#" class="close popup-closer">&times;</a>
            <div class="content" style="max-height: 400px; overflow-y: auto;">
                <form id="form-appointment-details">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Appointment Details</p>
                <div>
                    <table width="100%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td class="label-td" width="50%">
                                <label for="name" class="form-label"><b>Number: </b></label>
                            </td>
                            <td class="label-td" data-value="apponum"></td>
                        </tr>
                        <tr>
                            <td class="label-td" width="50%">
                                <label for="Email" class="form-label"><b>Title: </b></label>
                            </td>
                            <td class="label-td" data-value="title"></td>
                        </tr>
                        <tr>
                            <td class="label-td editable" width="50%">
                                <label for="appodate" class="form-label"><b>Date: </b></label>
                            </td>
                            <td class="label-td" data-value="appodate"></td>
                            <td class="label-td hidden">
                                <input type="date" class="field-editable input-text" data-value="scheduledate" data-datatype="date" name="scheduledate" value="" min='<?=date('Y-m-d')?>'>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="display: flex; justify-content: space-between">
                    <table width="49%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td class="label-td" colspan="2">
                                <b>Patient Details</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label"><b>Name: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="pname"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label"><b>Email: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="pemail"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label"><b>Telephone: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="ptel"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label"><b>Chief Complaint: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <div style="height: 100px; border: solid #e9ecef 0.5px; border-radius: 5px;" 
                                  data-value="chief_complaint_c"></div>
                            </td>
                        </tr>
                    </table>
                    <table width="49%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td class="label-td" colspan="2">
                                <b>Doctor Details</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label"><b>Name: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="docname"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label"><b>Email: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="docemail"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label"><b>Telephone: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="doctel"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label"><b>Specialties: </b></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="sname"></td>
                        </tr>
                    </table>
                </div>
                </form>
            </div>
        </center>
        <div class="popup-footer">
            <a href="#" class="popup-closer"><input type="submit" form="form-appointment-details" value="OK" class="login-btn btn-primary-soft btn" ></a>
        </div>
    </div>
</div>
<script>
    $('#form-appointment-details').on('submit', (ev) => {
        form.id = "form-appointment-details";
        ev.preventDefault();

        $.ajax({
            url: "apis/index.php/updateAppointment",
            method: "GET",
            data: {
                changes: form.changes
            },
            contentType: "application/json",
            success: (response) => {
                if (response.success) {
                    // var data = response.data;
                    // utils.processElementLogic($(`#${dialogId}`), data)
                    // utils.showDialog($(`#${dialogId}`))
                }
            },
            error: (xhr, textStatus, th) => {
                // Handle error response
                console.error('Error message: ' + xhr.statusText);
                let response = JSON.parse(xhr.responseText);
                showErrorToast([response.message], "error");
            }
        })
    })
</script>