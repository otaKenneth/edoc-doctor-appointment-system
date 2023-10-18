<?php
date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');

$list110 = $database->query("select  * from  schedule;");

?>
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0; margin-top: 20px;">
    <tr>
        <td colspan="3" style="padding-top:0px;width: 100%;">
            <center>
                <table class="filter-container" border="0">
                    <tr>
                        <td width="5%" style="text-align: center;">
                            Date:
                        </td>
                        <td width="15%">
                            <form action="" method="post">

                                <input type="date" name="sheduledate" id="date"
                                    class="input-text filter-container-items" style="margin: 0;width: 95%;">

                        </td>
                        <td width="5%" style="text-align: center;">
                            Doctor:
                        </td>
                        <td width="45%">
                            <select name="docid" id="" class="box filter-container-items"
                                style="width:90% ;height: 37px;margin: 0;">
                                <option value="" disabled selected hidden>Choose Doctor Name from the list</option>
                                <br />

                                <?php

                                $list11 = $database->query("select  * from  doctor order by docname asc;");

                                for ($y = 0; $y < $list11->num_rows; $y++) {
                                    $row00 = $list11->fetch_assoc();
                                    $sn = $row00["docname"];
                                    $id00 = $row00["docid"];
                                    echo "<option value=" . $id00 . ">$sn</option><br/>";
                                }
                                ;


                                ?>

                            </select>
                        </td>
                        <td width="12%">
                            <input type="submit" name="filter" value=" Filter"
                                class=" btn-primary-soft btn button-icon btn-filter"
                                style="padding: 15px; margin :0;width:100%">
                            </form>
                        </td>
                        <td>
                            <div>
                                <a href="#" class="non-style-link popup-btn"
                                  popupdata-id="popup1"
                                >
                                    <button
                                        class="login-btn btn-primary btn button-icon"
                                        style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font>
                                    </button>
                                </a>
                            </div>
                        </td>

                    </tr>
                </table>
            </center>
        </td>
    </tr>

    <tr>
        <td>
            <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                All Sessions (<?php echo $list110->num_rows; ?>)
            </p>
        </td>
    </tr>

    <?php
    if ($_POST) {
        //print_r($_POST);
        $sqlpt1 = "";
        if (!empty($_POST["sheduledate"])) {
            $sheduledate = $_POST["sheduledate"];
            $sqlpt1 = " schedule.scheduledate='$sheduledate' ";
        }


        $sqlpt2 = "";
        if (!empty($_POST["docid"])) {
            $docid = $_POST["docid"];
            $sqlpt2 = " doctor.docid=$docid ";
        }
        //echo $sqlpt2;
        //echo $sqlpt1;
        $sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid ";
        $sqllist = array($sqlpt1, $sqlpt2);
        $sqlkeywords = array(" where ", " and ");
        $key2 = 0;
        foreach ($sqllist as $key) {

            if (!empty($key)) {
                $sqlmain .= $sqlkeywords[$key2] . $key;
                $key2++;
            }
            ;
        }
        ;
        //echo $sqlmain;
    


        //
    } else {
        $sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";

    }



    ?>

    <tr>
        <td colspan="4">
            <center>
                <div class="abc scroll">
                    <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                            <tr>
                                <th class="table-headin">


                                    Session Title

                                </th>

                                <th class="table-headin">
                                    Doctor
                                </th>
                                <th class="table-headin">

                                    Sheduled Date & Time

                                </th>
                                <th class="table-headin">

                                    Max num that can be booked

                                </th>

                                <th class="table-headin">

                                    Events

                            </tr>
                        </thead>
                        <tbody>

                            <?php


                            $result = $database->query($sqlmain);

                            if ($result->num_rows == 0) {
                                echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';

                            } else {
                                for ($x = 0; $x < $result->num_rows; $x++) {
                                    $row = $result->fetch_assoc();
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $docname = $row["docname"];
                                    $scheduledate = $row["scheduledate"];
                                    $scheduletime = $row["scheduletime"];
                                    $nop = $row["nop"]; ?>
                                
                                    <tr>
                                        <td> &nbsp;<?=substr($title, 0, 30)?></td>
                                        <td><?=substr($docname, 0, 20)?></td>
                                        <td style="text-align:center;">
                                            <?=substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5)?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?=$nop?>
                                        </td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                <a href="?action=view&id=' . $scheduleid . '" class="non-style-link table-btn popup-btn">
                                                    <button  class="btn-primary-soft btn button-icon btn-view">
                                                        <font class="tn-in-text">View</font>
                                                    </button>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="?action=drop&id=' . $scheduleid . '&name=' . $title . '" class="non-style-link table-btn popup-btn">
                                                    <button  class="btn-primary-soft btn button-icon btn-delete">
                                                        <font class="tn-in-text">Remove</font>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </td>
    </tr>
</table>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/admin/components/schedule-popup.php"); ?>
<script>
    function processDialogData (dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action === 'view') {

        } else {

        }
    }
</script>