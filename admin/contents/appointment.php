<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AdminController.php");

    $c_admin = new AdminController;

    $params = [];
    $result = $c_admin->getAppointments($database, $params);

    if ($_POST) {
        if (isset($_POST['sheduledate']) && !empty($_POST['sheduledate'])) {
            $params['scheduledate'] = $_POST['scheduledate'];
        }

        if (isset($_POST['docid']) && !empty($_POST['docid'])) {
            $params['docid'] = $_POST['docid'];
        }

        $result = $c_admin->getAppointments($database, $params);
    }

    if ($result['success']) {
        $appointments = $result['data'];
    }
    
    $list110 = $database->query("select  * from  appointment;");
?>
<tr>
    <td colspan="4" style="padding-top:10px;width: 100%;">
        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Appointments (<?php echo $list110->num_rows; ?>)</p>
    </td>
    
</tr>
<center>
    <table class="filter-container" border="0" >
        <tr>
            <td width="10%"></td> 
            <td width="5%" style="text-align: center;">Date:</td>
            <td width="30%">
                <form action="" method="post">
                <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
            </td>
            <td width="5%" style="text-align: center;">Doctor:</td>
            <td width="30%">
                <select name="docid" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                <option value="" disabled selected hidden>Choose Doctor Name from the list</option><br/>
                    
                <?php 
                    
                    $list11 = $database->query("select  * from  doctor order by docname asc;");

                    for ($y=0;$y<$list11->num_rows;$y++){
                        $row00=$list11->fetch_assoc();
                        $sn=$row00["docname"];
                        $id00=$row00["docid"];
                        echo "<option value=".$id00.">$sn</option><br/>";
                    };


                    ?>

                </select>
            </td>
            <td width="12%">
                <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                </form>
            </td>
        </tr>
    </table>
</center>
<center>
    <div class="abc scroll">
        <table width="93%" class="sub-table scrolldown" border="0">
            <thead>
                <tr>
                    <th class="table-headin">
                        Patient Name
                    </th>
                    <th class="table-headin">
                        
                        Appointment Number
                        
                    </th>
                    
                    
                    <th class="table-headin">
                        Doctor
                    </th>
                    <th class="table-headin">
                        
                    
                        Session Title
                        
                        </th>
                    
                    <th class="table-headin" style="font-size:10px">
                        
                        Session Date & Time
                        
                    </th>
                    
                    <th class="table-headin">
                        
                        Appointment Date
                        
                    </th>
                    
                    <th class="table-headin">
                        
                        Events
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($appointments->num_rows==0){ ?>
                        <tr>
                            <td colspan="7">
                                <br><br><br><br>
                                <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                    </a>
                                </center>
                                <br><br><br><br>
                            </td>
                        </tr>
                        
                    <?php } else {
                        $result = $appointments->fetch_all(MYSQLI_ASSOC);
                        foreach ($result as $row){
                            $appoid=$row["appoid"];
                            $scheduleid=$row["scheduleid"];
                            $title=$row["title"];
                            $docname=$row["docname"];
                            $scheduledate=$row["scheduledate"];
                            $scheduletime=$row["scheduletime"];
                            $pname=$row["pname"];
                            $apponum=$row["apponum"];
                            $appodate=$row["appodate"];
                        ?>

                        <tr>
                            <td style="font-weight:600;"> &nbsp;<?=substr($pname,0,25)?></td>
                            <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                <?=$apponum?>
                            </td>
                            <td> <?=substr($docname,0,25)?> </td>
                            <td> <?=substr($title,0,15)?></td>
                            <td style="text-align:center;font-size:12px;">
                                <?=substr($scheduledate,0,10)?> <br><?=substr($scheduletime,0,5)?>
                            </td>
                            
                            <td style="text-align:center;">
                                <?=$appodate?>
                            </td>

                            <td>
                            <div style="display:flex;justify-content: center;">
                            
                            <a href="#" 
                              datapopup-id="popup1"
                              data='<?=json_encode([
                                'action' => 'view',
                                'id' => $appoid
                              ])?>'
                              class="non-style-link table-btn popup-btn"
                            >
                                <button  class="btn-primary-soft btn button-icon btn-view">
                                    <font class="tn-in-text">View</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="#" 
                              datapopup-id="popup2"
                              data='<?=json_encode([
                                'action' => 'view',
                                'id' => $appoid
                              ])?>'
                              class="non-style-link table-btn popup-btn"
                            >
                                <button class="btn-primary-soft btn button-icon btn-edit">
                                    <font class="tn-in-text">Edit</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="#" 
                              datapopup-id="popup3"
                              data='<?=json_encode([
                                'action' => 'drop',
                                'id' => $appoid,
                                'name' => $pname,
                                'session' => $title,
                                'apponum' => $apponum
                              ])?>'
                              class="non-style-link table-btn popup-btn"
                            >
                                <button  class="btn-primary-soft btn button-icon btn-delete">
                                    <font class="tn-in-text">Cancel</font>
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;</div>
                            </td>
                        </tr>
                        
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
</center>