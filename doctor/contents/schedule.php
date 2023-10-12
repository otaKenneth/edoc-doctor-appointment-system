<?php

date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');

$list110 = $database->query("select  * from  schedule where docid=" . $user['docid']);

?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 40px;">
    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Sessions (
        <?php echo $list110->num_rows; ?>)
    </p>
    <div style="width: 500px; align-items: center;">
        <center>
            <table class="filter-container" style="margin: unset;" border="0">
                <tr>
                    <td width="5%" style="text-align: center;">Date:</td>
                    <td width="30%">
                        <form action="" method="post">
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items"
                                style="margin: 0;width: 95%;">
                    </td>
                    <td width="12%">
                        <input type="submit" name="filter" value=" Filter"
                            class=" btn-primary-soft btn button-icon btn-filter"
                            style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>
                </tr>
            </table>
        </center>
    </div>
    <div>
        <a href="#" class="non-style-link popup-btn" popupdata-id="popup1">
            <button class="login-btn btn-primary btn button-icon"
                style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
        </a>
    </div>
</div>
<?php

$sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid where doctor.docid=" . $user['docid'];
if ($_POST) {
    //print_r($_POST);
    $sqlpt1 = "";
    if (!empty($_POST["sheduledate"])) {
        $sheduledate = $_POST["sheduledate"];
        $sqlmain .= " and schedule.scheduledate='$sheduledate' ";
    }

}

?>

<center>
    <div class="abc scroll">
        <table width="93%" class="sub-table scrolldown" border="0">
            <thead>
                <tr>
                    <th class="table-headin">Session Title</th>
                    <th class="table-headin">Sheduled Date & Time</th>
                    <th class="table-headin">Max num that can be booked</th>
                    <th class="table-headin">Events</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $database->query($sqlmain);

                if ($result->num_rows === 0) { ?>
                    <tr>
                        <td colspan="4">
                            <br><br><br><br>
                            <center>
                                <img src="../img/notfound.svg" width="25%">
                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We
                                    couldnt find anything related to your keywords !</p>
                                <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn"
                                        style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp;
                                        Show all Sessions &nbsp;</font></button>
                                </a>
                            </center>
                            <br><br><br><br>
                        </td>
                    </tr>
                    <?php
                } else {
                    for ($x = 0; $x < $result->num_rows; $x++) {
                        $row = $result->fetch_assoc();
                        $scheduleid = $row["scheduleid"];
                        $title = $row["title"];
                        $docname = $row["docname"];
                        $scheduledate = $row["scheduledate"];
                        $scheduletime = $row["scheduletime"];
                        $nop = $row["nop"];
                        ?>
                        <tr>
                            <td> &nbsp;<?=substr($title, 0, 30)?></td>

                            <td style="text-align:center;">
                                <?=substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5)?>
                            </td>
                            <td style="text-align:center;">
                                <?=$nop?>
                            </td>

                            <td>
                                <div style="display:flex;justify-content: center;">
                                    <a href="#" 
                                      popupdata-id="schedule-view-dialog"
                                      data='<?=json_encode([
                                        'action' => 'view',
                                        'id' => $scheduleid
                                      ])?>'
                                      class="non-style-link table-btn popup-btn">
                                        <button
                                            class="btn-primary-soft btn button-icon btn-view"
                                            style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                            <font class="tn-in-text">View</font>
                                        </button></a>
                                    <a href="#"
                                      popupdata-id="cancel-session-dialog"
                                      data='<?=json_encode([
                                        'action'=>'drop',
                                        'id' => $scheduleid,
                                        'name' => $title
                                      ])?>'
                                      class="non-style-link table-btn popup-btn">
                                        <button class="btn-primary-soft btn button-icon btn-delete"
                                            style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px; margin-left: 15px;">
                                            <font class="tn-in-text">Cancel Session</font>
                                        </button></a>
                                </div>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</center>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/doctor/components/schedule-popup.php");
?>
<script>
    function processDialogData(dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action === 'view') {
            $.ajax({
                url: "apis/index.php/getScheduleData",
                method: "GET",
                data: JSON.parse(dialogData),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var data = response.data;
                        utils.processElementLogic($(`#${dialogId}`), data);
                        utils.showDialog($(`#${dialogId}`))
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Status code: ' + xhr.status);
                    console.error('Error message: ' + xhr.statusText);
                    console.error('Response: ' + xhr.responseText);
                }
            })
        } else if (dData.action == 'drop') {
            utils.processElementLogic($(`#${dialogId}`), {
                'nameget': dData.name
            });

            $(`#${dialogId}`).attr("data-id", dData.id);

            $(`#${dialogId}`).removeClass('popup-closed');
            $(`#${dialogId}`).addClass('popup-open');
        }

    }
</script>