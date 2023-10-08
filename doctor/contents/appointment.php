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

<div style="display: flex; justify-content: end; margin: 15px 40px;">
    <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
    <a href="?action=add-session&id=none&error=0" class="non-style-link">
        <button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
    </a>
</div>
<center>
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
                            
                                <a href="?action=view&id=<?=$appoid?>" class="non-style-link">
                                    <button  
                                      class="btn-primary-soft btn button-icon btn-view"  
                                      style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">View</font>
                                    </button>
                                </a>
                                <a href="?action=drop&id=<?=$appoid?>&name=<?=$pname?>&session=<?$title?>&apponum=<?$apponum?>" 
                                class="non-style-link">
                                    <button 
                                    class="btn-primary-soft btn button-icon btn-delete"  
                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">Cancel</font>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php
                    
                    }
                }

                ?>

            </tbody>

        </table>
    </div>
</center>
<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/doctor/components/appointment-add-session.php");
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    if ($action == 'add-session') {
    } elseif ($action == 'session-added') {
        $titleget = $_GET["title"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Session Placed.</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        ' . substr($titleget, 0, 40) . ' was scheduled.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
    } elseif ($action == 'drop') {
        $nameget = $_GET["name"];
        $session = $_GET["session"];
        $apponum = $_GET["apponum"];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br><br>
                            Patient Name: &nbsp;<b>' . substr($nameget, 0, 40) . '</b><br>
                            Appointment number &nbsp; : <b>' . substr($apponum, 0, 40) . '</b><br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
    } elseif ($action == 'view') {
        $sqlmain = "select * from doctor where docid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["docname"];
        $email = $row["docemail"];
        $spe = $row["specialties"];

        $spcil_res = $database->query("select sname from specialties where id='$spe'");
        $spcil_array = $spcil_res->fetch_assoc();
        $spcil_name = $spcil_array["sname"];
        $nic = $row['docnic'];
        $tele = $row['doctel'];
        echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            eDoc Web App<br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">NIC: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $nic . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ' . $tele . '<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Specialties: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            ' . $spcil_name . '<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
    }
}

?>
</div>