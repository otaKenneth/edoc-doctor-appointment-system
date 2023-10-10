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
                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Session.</p><br>
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
                        <input type="text" name="title" class="input-text" placeholder="Name of this Session" required><br>
                    </td>
                </tr>
                <tr>
                    
                    <td class="label-td" colspan="2">
                        <label for="docid" class="form-label">Select Doctor: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <select name="docid" id="" class="box" >
                            <option value="" disabled selected hidden>Choose Doctor Name from the list</option><br/>

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
                        <input type="number" name="nop" class="input-text" min="0"  placeholder="The final appointment number for this session depends on this number" required><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="date" class="form-label">Session Date: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="date" name="date" class="input-text" min="<?=date('Y-m-d')?>" required><br>
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
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                        <input type="submit" value="Place this Session" class="login-btn btn-primary btn" name="shedulesubmit">
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
                <?=substr($titleget, 0, 40)?> was scheduled.<br><br>
            </div>
            <div style="display: flex;justify-content: center;">
                <a id="success-popup" href="#" class="non-style-link">
                    <button 
                      class="btn-primary btn" 
                      style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                      <font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font>
                    </button>
                </a>
            </div>
        </center>
    </div>
</div>

<div id="popup3" class="overlay popup-closed popup-drop">
    <div class="popup">
        <center>
            <h2>Are you sure?</h2>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content">
                You want to delete this record<br><br>
                Patient Name: &nbsp;<b data-value="nameget"></b><br>
                Appointment number &nbsp; : <b data-value="apponum"></b><br><br>
            </div>
            <div style="display: flex;justify-content: center;">
                <a href="#" class="non-style-link yes"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                <a href="#" class="non-style-link no popup-closer"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
            </div>
        </center>
    </div>
</div>

<div id="popup4" class="overlay popup-closed popup-view">
    <div class="popup">
        <center>
            <h2></h2>
            <a href="#" class="close popup-closer">&times;</a>
            <div class="content">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Appointment Details</p>
            </div>
            <div style="display: flex;justify-content: space-between;">
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
                        <td class="label-td" colspan="2" data-value="chief_complaint_c"></td>
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
        </center>
        <div style="padding-top: 15px;">
            <a href="#" class="popup-closer"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
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
                    console.error('Status code: ' + xhr.status);
                    console.error('Error message: ' + xhr.statusText);
                    console.error('Response: ' + xhr.responseText);
                }
            });
        })

        // Delete Appoointment
        $('.non-style-link.yes').click(function (ev) {
        })
    })
</script>