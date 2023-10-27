<?php
date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

if ($_GET) {
    if(isset($_GET["id"])){
        $id = $_GET["id"];

        $sched = $c_schedule->getScheduleDataForBooking($database, [
            'id' => $id
        ]);
    }
}
?>
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
    <tr>
        <td colspan="4">
            <center>
                <div class="abc scroll">
                    <table width="100%" class="sub-table scrolldown" border="0" style="padding: 10px 40px;border:none">
                        <tbody>
                            <tr>
                                <?php
                                if ($sched['success']) { 
                                    $row = $sched['data'];
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $docemail=$row["docemail"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $apponum = $row["apponum"];
                                    ?>
                                <form id="complete-booking" method="post">
                                    <input type="hidden" name="pid" value="<?=$user['pid']?>" >
                                    <input type="hidden" name="scheduleid" value="<?=$scheduleid?>" >
                                    <input type="hidden" name="apponum" value="<?=$apponum?>" >
                                    <input type="hidden" name="date" value="<?=$today?>" >

                                <td style="width: 50%;" rowspan="2">
                                    <div  class="dashboard-items search-items"  >
                                    
                                        <div style="width:100%">
                                                <div class="h1-search" style="font-size:25px;">
                                                    Session Details
                                                </div>
                                                <div class="h2-search">
                                                    <div>How do you feel?</div>
                                                    <textarea name="feel" id="feel" cols="30" rows="5" class="input-text" placeholder="I feel stomach ache..."></textarea>
                                                </div>
                                                <div class="h3-search" style="font-size:18px;line-height:30px">
                                                    Doctor name:  &nbsp;&nbsp;<b><?=$docname?></b><br>
                                                    Doctor Email:  &nbsp;&nbsp;<b><?=$docemail?></b> 
                                                </div>
                                                <div class="h3-search" style="font-size:18px;">
                                                    
                                                </div><br>
                                                <div class="h3-search" style="font-size:18px;">
                                                    Session Title: <?=$title?><br>
                                                    Session Scheduled Date: <?=$scheduledate?><br>
                                                    Session Starts : <?=$scheduletime?><br>
                                                    Channeling fee : <b>PHP.2 000.00</b>
                                                </div>
                                                <br>
                                                
                                        </div>
                                                
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items search-items"  >
                                    
                                        <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                            <div class="h1-search" style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                                Your Appointment Number
                                            </div>
                                            <center>
                                                <div class="dashboard-icons" 
                                                    style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">
                                                    <?=$apponum?>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="Submit" class="login-btn btn-primary btn btn-book" style="margin-left:10px;padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;width:95%;text-align: center;" value="Book now" name="booknow"></button>
                                </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </td> 
    </tr>                
</table>
<script>
    $(document).ready(() => {
        $('form#complete-booking').on('submit', (ev) => {
            ev.preventDefault();
            var form_data = utils.serializeArrayToJSON($(ev.currentTarget).serializeArray());

            $.ajax({
                url: "apis/index.php/Patient/booknow",
                method: "POST",
                data: form_data,
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var dialog = $(this).closest('.overlay')
                        $(dialog).removeClass('popup-open');
                        $(dialog).addClass('popup-closed');
                        showSuccessToast(response.message)
                        utils.pageReload(4500)
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Error message: ' + xhr.statusText);
                    let response = JSON.parse(xhr.responseText);
                    console.log(typeof(response.message))
                    showErrorToast(response.message)
                }
            })
        })
    })
</script>