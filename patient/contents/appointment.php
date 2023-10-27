<?php
    $getPatientArgs = [
        'userid' => $user['pid'],
        'select' => true
    ];

    if($_POST){
        if(!empty($_POST["sheduledate"])){
            $scheduledate = $_POST["sheduledate"];
            $getPatientArgs['scheduledate'] = [
                'condition' => '=',
                'value' => $scheduledate
            ];
        };
    }

    $result = $c_patient->getPatientAppointments($database, $getPatientArgs);
    
    $appointments = [];
    if ($result['success']) {
        $appointments = $result['data']->fetch_all(MYSQLI_ASSOC);
    }
?>
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
    <tr>
        <td colspan="4" style="width: 100%;" >
            <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings (<?php echo count($appointments); ?>)</p>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding-top:0px;width: 100%;" >
            <center>
                <table class="filter-container" border="0" >
                    <tr>
                        <td width="10%"></td>
                        <td width="5%" style="text-align: center;">
                            Date:
                        </td>
                        <td width="30%">
                            <form action="" method="post">
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                        </td>
                        <td width="12%">
                            <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                            </form>
                        </td>

                    </tr>
                </table>
            </center>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <center>
            <div class="abc scroll">
                <table width="93%" class="sub-table scrolldown" border="0" style="border:none">
                    <tbody>
                    <?php
                    if(count($appointments)==0){ ?>
                        <tr>
                            <td colspan="7">
                                <br><br>
                                <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                    </a>
                                </center>
                                <br><br>
                            </td>
                        </tr>
                    <?php } else {
                        foreach(array_chunk($appointments, 3) as $tr) {?>
                            <tr>
                                <?php foreach ($tr as $key => $row) {
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $apponum=$row["apponum"];
                                    $appodate=$row["appodate"];
                                    $appoid=$row["appoid"]; ?>
                                    <td style="width: 25%;">
                                        <div  class="dashboard-items search-items">
                                            <div style="width:100%;">
                                                <div class="h3-search">
                                                    Booking Date: <?=substr($appodate,0,30)?><br>
                                                    Reference Number: OC-000-<?=$appoid?>
                                                </div>
                                                <div class="h1-search">
                                                    <?=substr($title,0,21)?><br>
                                                </div>
                                                <div class="h3-search">
                                                    Appointment Number:<div class="h1-search">0<?=$apponum?></div>
                                                </div>
                                                <div class="h3-search">
                                                    <?=substr($docname,0,30)?>
                                                </div>
                                                <div class="h4-search">
                                                    Scheduled Date: <?=$scheduledate?><br>Starts: <b>@<?=substr($scheduletime,0,5)?></b> (24h)
                                                </div>
                                                <br>
                                                <a href="#" popupdata-id="dialog-cancel"
                                                    class="table-btn popup-btn"
                                                    data='<?=json_encode([
                                                        'action' => 'drop',
                                                        'id' => $appoid,
                                                        'title' => $title,
                                                        'doc' => $docname
                                                    ])?>'
                                                >
                                                    <button class="login-btn btn-primary-soft btn " 
                                                        style="padding-top:11px;padding-bottom:11px;width:100%">
                                                        <font class="tn-in-text">Cancel Booking</font>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
            </center>
        </td> 
    </tr>
</table>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/patient/components/appointments-popup.php"); ?>
<script>
    function processDialogData(dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action == 'drop') {
            $(`#${dialogId}`).attr('data-id', dData.id);
            utils.processElementLogic($(`#${dialogId}`), dData);
            utils.showDialog($(`#${dialogId}`))
        }
    }
</script>