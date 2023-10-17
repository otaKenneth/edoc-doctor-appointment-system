<?php
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/DoctorController.php");
$c_doctors = new DoctorController;

$args = [
    'docid' => $user['docid']
];

$currentFilterSelected = 'my';

if (isset($_POST["filter"])) {
    $currentFilterSelected = $_POST["showonly"];
    $args = array_merge($args, [
        'showonly' => $_POST["showonly"]
    ]);
}

$response = $c_doctors->getPatientList($database, $args);

$result = $response['success'] ? $response['data']:[];
?>

<center>
    <div>
        <div style="width: max-content">
            <form action="" method="post">
                <div class="filter-container" style="display: flex; align-items: center; padding-left: 15px;">
                    <span style="text-wrap: nowrap;">Show Details About : &nbsp;</span>
                    <div style="width: 350px;">
                        <select name="showonly" id="" class="box filter-container-items"
                            style="width:100% ;height: 50px;margin: 0;">
                            <option value="my" <?=$currentFilterSelected == "my"?"selected":""?> >My Patients Only</option><br />
                            <option value="all" <?=$currentFilterSelected == "all"?"selected":""?>>All Patients</option><br />
                        </select>
                    </div>
                    <input type="submit" name="filter" value=" Filter"
                        class=" btn-primary-soft btn button-icon btn-filter"
                        style="padding: 15px; padding-left: 34px; margin :0;">
                </div>
            </form>
        </div>
    </div>
    <div class="abc scroll">
        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
            <thead>
                <tr>
                    <th class="table-headin">Name</th>
                    <th class="table-headin">Telephone</th>
                    <th class="table-headin">Email</th>
                    <th class="table-headin">Date of Birth</th>
                    <th class="table-headin">Events</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($result)==0){ ?>
                        <tr>
                            <td colspan="4">
                                <br><br><br><br>
                                <center>
                                    <img src="../img/notfound.svg" width="25%"><br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                        We couldnt find anything related to your keywords !
                                    </p>
                                </center>
                            </td>
                        </tr>
                        
                    <?php }
                    else {
                        foreach ($result as $key => $row) {
                            $pid=$row["pid"];
                            $name=$row["pname"];
                            $email=$row["pemail"];
                            $dob=$row["pdob"];
                            $tel=$row["ptel"];
                        ?>
                        <tr>
                            <td> &nbsp;<?=substr($name,0,35)?></td>
                            <td>
                                <?=substr($tel,0,10)?>
                            </td>
                            <td>
                                <?=substr($email,0,20)?>
                            </td>
                            <td>
                                <?=substr($dob,0,10)?>
                            </td>
                            <td>
                                <div style="display:flex;justify-content: center;">
                                    <a href="#" 
                                      popupdata-id="popup1"
                                      data='<?=json_encode([
                                        'id' => $pid,
                                        'action' => 'view'
                                      ])?>'
                                      class="non-style-link table-btn popup-btn">
                                        <button 
                                        class="btn-primary-soft btn button-icon btn-view"
                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                            <font class="tn-in-text">View</font>
                                        </button>
                                    </a>
                                    <a href="#" 
                                      popupdata-id="popup2"
                                      data='<?=json_encode([
                                        'id' => $pid,
                                        'action' => 'view-2'
                                      ])?>'
                                      class="non-style-link table-btn popup-btn"
                                      style="margin-left: 15px;">
                                        <button class="btn-secondary-soft btn">
                                            <font class="tn-in-text">Consultation History</font>
                                        </button>
                                    </a>
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
include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/doctor/components/patients-popup.php");
?>
<script>
    function processDialogData (dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action === 'view') {
            $.ajax({
                url: "apis/index.php/getDoctorPatient",
                method: "GET",
                data: JSON.parse(dialogData),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var data = response.data;
                        utils.processElementLogic($(`#${dialogId}`), data)
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
        } else if (dData.action === 'view-2') {
            getPatientPevConsultations(dData.id, dialogId);

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

    function getPatientPevConsultations (pid, dialogId) {
        $.ajax({
            url: "apis/index.php/getPatientPrevConsultations",
            method: "GET",
            data: {
                'pid': pid
            },
            contentType: "application/json",
            success: (response) => {
                if (response.success) {
                    var data = response.data;
                    var $el = $('#patient-consultation-history-popup');
                    utils.processElementLogic($el, data);
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
    }
</script>