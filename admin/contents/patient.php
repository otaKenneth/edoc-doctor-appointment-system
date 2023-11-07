<?php
    if ($_POST) {
        $keyword = $_POST["search"];

        $sqlmain = "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
    } else {
        $sqlmain = "select * from patient order by pid desc";
    }

    $result = $database->query($sqlmain);
?>
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
    <tr>
        <td colspan="4" style="padding-top:10px;">
            <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                All Patients (<?php echo $result->num_rows; ?>)
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <center>
                <div class="abc scroll">
                    <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                        <thead>
                            <tr>
                                <th class="table-headin">Name</th>
                                <th class="table-headin">Telephone</th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">Date of Birth</th>
                                <th class="table-headin">Events</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($result->num_rows == 0) { ?>
                                <tr>
                                    <td colspan="4">
                                        <br><br>
                                        <center>
                                            <img src="../img/notfound.svg" width="25%">
                                            
                                            <br>
                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                We couldnt find anything related to your keywords !
                                            </p>
                                            <a class="non-style-link" href="patient.php">
                                                <button class="login-btn btn-primary-soft btn" 
                                                  style="display: flex;justify-content: center;align-items: center;margin-left:20px;"
                                                >
                                                    <font>&nbsp; Show all Patients &nbsp;</font>
                                                </button>
                                            </a>
                                        </center>
                                        <br><br>
                                    </td>
                                </tr>
                            <?php } else {
                                for ($x = 0; $x < $result->num_rows; $x++) {
                                    $row = $result->fetch_assoc();
                                    $pid = $row["pid"];
                                    $name = $row["pname"];
                                    $email = $row["pemail"];
                                    $nic = $row["pnic"];
                                    $dob = $row["pdob"];
                                    $tel = $row["ptel"]; ?>

                                    <tr>
                                        <td><?=substr($name, 0, 35)?></td>
                                        <td align="right"><?=substr($tel, 0, 10)?></td>
                                        <td align="right"><?=substr($email, 0, 20)?></td>
                                        <td align="center"><?=substr($dob, 0, 10)?></td>
                                        <td >
                                            <div style="display:flex;justify-content: center;">
                                                <a href="#" class="non-style-link table-btn popup-btn"
                                                  popupdata-id="popup1"
                                                  data='<?=json_encode([
                                                    'action' => 'view',
                                                    'id' => $pid
                                                  ])?>'
                                                >
                                                    <button class="btn-primary-soft btn button-icon btn-view">
                                                        <font class="tn-in-text">View</font>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                            <?php } } ?>
                        </tbody>

                    </table>
                </div>
            </center>
        </td>
    </tr>
</table>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/admin/components/patient-popup.php"); ?>
<script src="../js/patients.js"></script>
<script>
    function processDialogData (dialogData, dialogId) {
        var dData = JSON.parse(dialogData);
        $(`#${dialogId}`).attr('data-id', dData.id)

        if (dData.action === 'view') {
            $('#files-drag-n-drop .template-copy').remove();
            $.ajax({
                url: "apis/index.php/getPatientData",
                method: "GET",
                data: JSON.parse(dialogData),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var data = response.data;
                        utils.processElementLogic($(`#${dialogId}`), data);
                        utils.showDialog($(`#${dialogId}`))

                        var uploads = data.uploads;
                        showUploads(uploads)
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
    }
</script>