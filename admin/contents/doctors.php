<div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 40px;">
    <p class="heading-main12" style="margin-left: 10px;font-size:18px;color:rgb(49, 49, 49)">
        All Doctors (<?php echo $list11->num_rows; ?>)
    </p>
    <div>
        <a href="#" class="non-style-link popup-btn" popupdata-id="popup1">
            <button class="login-btn btn-primary btn button-icon"
                style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add New</font></button>
        </a>
    </div>
</div>
<?php
if ($_POST) {
    $keyword = $_POST["search"];

    $sqlmain = "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
} else {
    $sqlmain = "select * from doctor order by docid desc";

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
                                Doctor Name
                            </th>
                            <th class="table-headin">
                                Email
                            </th>
                            <th class="table-headin">
                                Specialties
                            </th>
                            <th class="table-headin">
                                Events
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $result = $database->query($sqlmain);

                        if ($result->num_rows == 0) { ?>
                            <tr>
                                <td colspan="4">
                                    <br><br>
                                    <center>
                                        <img src="../img/notfound.svg" width="25%">
                                        
                                        <br>
                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                        <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Doctors &nbsp;</font></button>
                                        </a>
                                    </center>
                                    <br><br>
                                </td>
                            </tr>
                        <?php } else {
                        for ($x = 0; $x < $result->num_rows; $x++) {
                            $row = $result->fetch_assoc();
                            $docid = $row["docid"];
                            $name = $row["docname"];
                            $email = $row["docemail"];
                            $spe = $row["specialties"];
                            $spcil_res = $database->query("select sname from specialties where id='$spe'");
                            $spcil_array = $spcil_res->fetch_assoc();
                            $spcil_name = $spcil_array["sname"]; ?>
                            <tr>
                                <td><?=substr($name, 0, 30)?></td>
                                <td><?=substr($email, 0, 20)?></td>
                                <td><?=substr($spcil_name, 0, 20)?></td>
                                <td>
                                    <div style="display:flex;justify-content: center;">
                                        <!-- <a href="#" class="non-style-link table-btn popup-btn"
                                          data='<?=json_encode([
                                            'action' => 'edit',
                                            'id' => $docid
                                          ])?>'
                                          style="margin-right: 10px"
                                        >
                                            <button class="btn-primary-soft btn button-icon btn-edit">
                                                <font class="tn-in-text">Edit</font>
                                            </button>
                                        </a> -->
                                        <a href="#" class="non-style-link table-btn popup-btn"
                                          popupdata-id="popup2"
                                          data='<?=json_encode([
                                            'action' => 'view',
                                            'id' => $docid
                                          ])?>'
                                          style="margin-right: 10px"
                                        >
                                            <button class="btn-primary-soft btn button-icon btn-view">
                                                <font class="tn-in-text">View</font>
                                            </button>
                                        </a>
                                        <a href="#" class="non-style-link table-btn popup-btn"
                                          popupdata-id="popup3"
                                          data='<?=json_encode([
                                            'action' => 'drop',
                                            'id' => $docid,
                                            'name' => $name
                                          ])?>'
                                          style="margin-right: 10px"
                                        >
                                            <button  class="btn-primary-soft btn button-icon btn-delete">
                                                <font class="tn-in-text">Remove</font>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </center>
    </td>
</tr>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/admin/components/doctors-popup.php"); ?>
<script>
    var objDoctorsData = null;
    function processDialogData (dialogData, dialogId) {
        var dData = JSON.parse(dialogData);

        if (dData.action === 'view') {
            $.ajax({
                url: "apis/index.php/getDoctorData",
                method: "GET",
                data: JSON.parse(dialogData),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        objDoctorsData = response.data;
                        utils.processElementLogic($(`#${dialogId}`), objDoctorsData);
                        utils.showDialog($(`#${dialogId}`))
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

            utils.showDialog($(`#${dialogId}`));
        }
    }
</script>