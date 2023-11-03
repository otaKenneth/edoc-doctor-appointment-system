<?php
$insertkey="";
$q='';
$searchtype="All";

    $getPatientArgs = [
        'userid' => $user['pid']
    ];
    
    if($_POST){
        if(!empty($_POST["sheduledate"])){
            $scheduledate = $_POST["sheduledate"];
            $getPatientArgs['scheduledate'] = [
                'condition' => '=',
                'value' => $scheduledate
            ];
        };

        if (!empty($_POST['search'])) {
            $keyword = $_POST['search'];
            $getPatientArgs['search'] = $keyword;

            $insertkey=$keyword;
            $searchtype="Search Result : ";
            $q='"';
        }
    }

    $result = $c_schedule->getAvailableSessions($database, $getPatientArgs);
    
    $schedules = [];
    if ($result['success']) {
        $schedules = $result['data']->fetch_all(MYSQLI_ASSOC);
    }

?>
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
    <tr>
        <td colspan="4" style="width: 100%;">
            <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype." Sessions"."(".count($schedules).")"; ?> </p>
            <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q.$insertkey.$q ; ?> </p>
        </td>    
    </tr>
    <tr>
        <td colspan="4">
            <center>
            <div class="abc scroll">
                <table width="100%" class="sub-table scrolldown" border="0" style="padding: 10px 50px;border:none">
                    <tbody>
                        <?php
                        if(count($schedules)==0){ ?>
                            <tr>
                                <td colspan="4">
                                <br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                    </a>
                                    </center>
                                <br><br>
                                </td>
                            </tr>  
                        <?php } else {
                            foreach(array_chunk($schedules,3) as $tr) { ?>
                            <tr>
                                <?php foreach ($tr as $row) {
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"]; ?>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items search-items">
                                            <div style="width:100%">
                                                <div class="h1-search">
                                                    <?=substr($title,0,21)?>
                                                </div><br>
                                                <div class="h3-search">
                                                    <?=substr($docname,0,30)?>
                                                </div>
                                                <div class="h4-search">
                                                    <?=$scheduledate?><br>Starts: <b>@<?=substr($scheduletime,0,5)?></b> (24h)
                                                </div>
                                                <br>
                                                <a href="booking.php?id=<?=$scheduleid?>">
                                                    <button class="login-btn btn-primary-soft btn" 
                                                        style="padding-top:11px;padding-bottom:11px;width:100%">
                                                        <font class="tn-in-text">Book Now</font>
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