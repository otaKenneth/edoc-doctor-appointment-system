<?php
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/DoctorController.php");
$c_doctors = new DoctorController;

$result = $c_doctors->getDoctorAppointments($database, [
    'userid' => $user['docid']
]);

if (!empty($_POST["sheduledate"])) {

    $result = $c_doctors->getDoctorAppointments($database, [
        'scheduledate' => $_POST["sheduledate"],
        'userid' => $user['docid']
    ]);
}

if ($result['success']) {
    $schedules = $result['data'];
}

?>
<center>
    <div>
        <div style="width: max-content">
            <form action="" method="post">
                <div class="filter-container" style="display: flex; align-items: center; padding-left: 15px;">
                    <span style="text-wrap: nowrap;">Date:&nbsp;</span>
                    <div style="width: 350px;">
                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items"
                            style="margin: 0;width: 95%;">
                    </div>
                    <input type="submit" name="filter" value=" Filter"
                        class=" btn-primary-soft btn button-icon btn-filter"
                        style="padding: 15px; padding-left: 34px; margin :0;">
                </div>
            </form>
        </div>
    </div>
    <div class="abc scroll">
        <table width="93%" class="sub-table scrolldown" border="0">
            <thead>
                <tr>
                    <th class="table-headin">Patient name</th>
                    <th class="table-headin">Appointment number</th>
                    <th class="table-headin">Session Title</th>
                    <th class="table-headin">Session Date & Time</th>
                    <th class="table-headin">Appointment Date</th>
                    <th class="table-headin">Events</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($schedules->num_rows == 0) { ?>
                    <tr>
                        <td colspan="7">
                            <br><br><br><br>
                            <center>
                            <img src="../img/notfound.svg" width="25%">
                            <br>
                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                            <a class="non-style-link" href="appointment.php">
                                <button
                                    class="login-btn btn-primary-soft btn"  
                                    style="display: flex;justify-content: center;align-items: center;margin-left:20px;">
                                    <font>&nbsp; Show all Appointments &nbsp;</font>
                                </button>
                            </a>
                            </center>
                            <br><br><br><br>
                        </td>
                    </tr>
                <?php

                } else {
                    for ($x = 0; $x < $schedules->num_rows; $x++) {
                        $row = $schedules->fetch_assoc();
                        $docid = $row["docid"];
                        $appoid = $row["appoid"];
                        $scheduleid = $row["scheduleid"];
                        $title = $row["title"];
                        $docname = $row["docname"];
                        $scheduledate = $row["scheduledate"];
                        $scheduletime = $row["scheduletime"];
                        $pname = $row["pname"];
                        $apponum = $row["apponum"];
                        $appodate = $row["appodate"];
                ?>
                    <tr >
                        <td style="font-weight:600;"> &nbsp;<?=substr($pname, 0, 25)?></td >
                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                            <?=$apponum?>
                        </td>
                        <td><?=substr($title, 0, 15)?></td>
                        <td style="text-align:center;;">
                            <?=substr($scheduledate, 0, 10) . ' @' . substr($scheduletime, 0, 5)?>
                        </td>
                        
                        <td style="text-align:center;">
                            <?=$appodate?>
                        </td>

                        <td>
                            <div style="display:flex;justify-content: space-between;">
                            
                                <a href="#" class="non-style-link table-btn popup-btn" 
                                  popupdata-id="popup4"
                                  data='<?=json_encode([
                                    'id' => $appoid,
                                    'docid' => $docid,
                                    'action' => 'view'
                                  ])?>'>
                                    <button  
                                      class="btn-primary-soft btn button-icon btn-view"  
                                      style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">View</font>
                                    </button>
                                </a>
                                <!-- <a href="#" class="non-style-link table-btn popup-btn"
                                  popupdata-id="popup3"
                                  data='<?=json_encode([
                                    'id' => $appoid,
                                    'nameget' => $pname,
                                    'session' => $title,
                                    'apponum' => $apponum,
                                    'action' => 'drop'
                                  ])?>'>
                                    <button 
                                      class="btn-primary-soft btn button-icon btn-delete"  
                                      style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">Cancel</font>
                                    </button>
                                </a> -->
                            </div>
                        </td>
                    </tr>
                <?php
                    
                    } // end foreach
                } // end else

                ?>

            </tbody>

        </table>
    </div>
</center>
<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/doctor/components/appointment-popup.php");
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    if ($action == 'add-session') {
    } elseif ($action == 'session-added') {
        $titleget = $_GET["title"];
    }
}

?>
<script>
    function processDialogData (dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action === 'view') {
            $.ajax({
                url: "apis/index.php/getAppointmentData",
                method: "GET",
                data: JSON.parse(dialogData),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var data = response.data;
                        $(`#${dialogId} [data-value]`).each( (k, el) => {
                            $(el).text(data[$(el).attr('data-value')]);
                        })
                        
                        $(`#${dialogId}`).removeClass('popup-closed');
                        $(`#${dialogId}`).addClass('popup-open');
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Error message: ' + xhr.statusText);
                    let response = JSON.parse(xhr.responseText);
                    showErrorToast([response.message]);
                }
            })
        } else if (dData.action == 'drop') {
            $(`#${dialogId} [data-value]`).each( (k, el) => {
                console.log(dData[$(el).attr('data-value')]);
                $(el).text(dData[$(el).attr('data-value')]);
            })

            $(`#${dialogId}`).attr("data-id", dData['id']);

            $(`#${dialogId}`).removeClass('popup-closed');
            $(`#${dialogId}`).addClass('popup-open');
        }

    }
</script>