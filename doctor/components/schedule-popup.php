<div id="popup1" class="overlay popup-closed">
    <div class="popup">
        <center>
            <a class="close popup-closer" href="#">&times;</a>
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
                                <form id="add-session" action="add-session.php" method="POST" class="add-new-form">
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
                                    $list11 = $database->query("select  * from  doctor;");

                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                        $row00 = $list11->fetch_assoc();
                                        $sn = $row00["docname"];
                                        $id00 = $row00["docid"];
                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                    }
                                    ?>
                                </select>
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
                                <input type="date" name="date" class="input-text" min="<?= date('Y-m-d') ?>"
                                    required><br>
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
    </div>
</div>

<div id="popup2" class="overlay popup-closed popup-success">
    <div class="popup">
        <center>
            <h2>Session Placed.</h2>
            <a class="close popup-closer">&times;</a>
            <div class="content">
                <?= substr($titleget, 0, 40) ?> was scheduled.<br><br>
            </div>
            <div style="display: flex;justify-content: center;">
                <a id="success-popup" href="#" class="non-style-link">
                    <button class="btn-primary btn"
                        style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                        <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                    </button>
                </a>
            </div>
        </center>
    </div>
</div>

<div id="schedule-view-dialog" class="overlay popup-closed">
    <div class="popup" style="width: 70%;">
        <center>
            <h2></h2>
            <a class="close popup-closer">&times;</a>
            <div class="content">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Schedule Details</p>
            </div>
            <div class="abc has-logic scroll" style="display: flex;justify-content: center;" logic-key="schedule_data">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Session Title: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" data-value="title"></td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Doctor of this session: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" data-value="docname"></td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="nic" class="form-label">Scheduled Date: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" data-value="scheduledate"></td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Scheduled Time: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" data-value="scheduletime"></td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label"><b>Patients that Already registerd for this
                                    session:</b><span data-value="pregscount"></span></label>
                            <br><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <center>
                                <div id="patients" class="abc scroll">
                                    <table width="100%" class="sub-table scrolldown" border="0">
                                        <thead>
                                            <tr>
                                                <th class="table-headin">
                                                    Patient ID
                                                </th>
                                                <th class="table-headin">
                                                    Patient name
                                                </th>
                                                <th class="table-headin">Appointment number</th>
                                                <th class="table-headin">Patient Telephone</th>
                                        </thead>
                                        <tbody>
                                            <tr class="has-logic" logic-if="this.data.pregs_data==0">
                                                <td colspan="7">
                                                    <br><br>
                                                    <center>
                                                        <img src="../img/notfound.svg" width="25%">

                                                        <br>
                                                        <p class="heading-main12"
                                                            style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                            We couldnt find anything related to your keywords !</p>
                                                        <a class="non-style-link" href="appointment.php"><button
                                                            class="login-btn btn-primary-soft btn"
                                                            style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp;
                                                            Show all Appointments &nbsp;</font></button>
                                                        </a>
                                                    </center>
                                                    <br><br>
                                                </td>
                                            </tr>
                                            <tr class="has-logic hidden" logic-if="this.data.length>0" logic-loop="pregs_data" style="text-align:center;">
                                                <td data-value="pid"></td>
                                                <td style="font-weight:600;padding:25px" data-value="pname"></td>
                                                <td
                                                    style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);" 
                                                    data-value="apponum">
                                                </td>
                                                <td data-value="ptel"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
        <br><br>
    </div>
</div>

<div id="cancel-session-dialog" class="overlay popup-closed">
    <div class="popup">
        <center>
            <h2>Are you sure?</h2>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content">
                You want to delete this record<br><b data-value="nameget"></b>.
            </div>
            <div style="display: flex;justify-content: center;">
                <a href="#" class="non-style-link" onclick="dropYes(this)">
                    <button class="btn-primary btn" 
                      style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                      <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                    </button>
                </a>
                <a href="#" class="non-style-link">
                    <button  
                      class="btn-primary btn popup-closer"  
                      style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                      <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                    </button>
                </a>
            </div>
        </center>
    </div>
</div>

<script>
    function dropYes (el) {
        var parent = $(el).closest('.overlay')[0];
        var data_id = $(parent).attr('data-id')
        var dialogId = $(parent).attr('id');

        $.ajax({
            url: "apis/index.php/deleteSchedule",
            method: "POST",
            data: JSON.stringify({
                id: data_id
            }),
            contentType: "application/json",
            success: (response) => {
                if (response.success) {
                    utils.closeDialog($(`#${dialogId}`))
                    location.reload();
                }
            },
            error: (xhr, textStatus, th) => {
                // Handle error response
                console.error('Status code: ' + xhr.status);
                console.error('Error message: ' + xhr.statusText);
                console.error('Response: ' + xhr.responseText);
            }
        })
    }
</script>