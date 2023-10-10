<?php
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/DoctorController.php");
$c_doctors = new DoctorController;

$response = $c_doctors->getPatientList($database, [
    'docid' => $user['docid']
]);

$result = $response['success'] ? $response['data']:[];
?>

<center>
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
                        $(`#${dialogId} [data-value]`).each( (k, el) => {
                            var $el = $(el);
                            var $el_value = data[$el.attr('data-value')];
                            if ($el.prop('tagName').toLowerCase() === "input") {
                                $el.val($el_value);
                            } else {
                                $el.text($el_value);
                            }
                        })

                        getPatientPevConsultations(data.pid);
                        
                        $(`#${dialogId}`).removeClass('popup-closed');
                        $(`#${dialogId}`).addClass('popup-open');
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
            $(`#${dialogId} [data-value]`).each( (k, el) => {
                console.log(dData[$(el).attr('data-value')]);
                $(el).text(dData[$(el).attr('data-value')]);
            })

            $(`#${dialogId}`).attr("data-id", dData['id']);

            $(`#${dialogId}`).removeClass('popup-closed');
            $(`#${dialogId}`).addClass('popup-open');
        }

    }

    function getPatientPevConsultations (pid) {
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
                    var el = $('#patient-consultation-popup .drop-content .has-logic[logic-loop]');
                    var parent = $(el).parent();
                    utils.setValues(el, parent, data);
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