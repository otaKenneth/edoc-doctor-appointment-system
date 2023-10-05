<html>
<div id="popup1" class="overlay">
    <div class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">ViewDetails</p>
                <a class="close" href="patient.php">&times;</a>
            </div>
            <div style="display: flex;justify-content: center;">
            <?php
                if ($result['success']) {
                    $row = $result['data'];
                    
                    $name=$row["pname"];
                    $email=$row["pemail"];
                    $dob=$row["pdob"];
                    $tele=$row["ptel"];
                    $address=$row["paddress"];
                    ?>
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>

                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Patient ID: </label>
                        </td>
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            P-<?=$id?><br><br>
                        </td>
                        <td class="label-td" colspan="2">
                            <?=$name?><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <?=$email?><br><br>
                        </td>
                        <td class="label-td" colspan="2">
                            <?=$tele?><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Address: </label>
                        </td>
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Date of Birth: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <?=$address?><br><br>
                        </td>
                        <td class="label-td" colspan="2">
                            <?=$dob?><br><br>
                        </td>
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="patient.php"><input type="button" value="OK"
                                    class="login-btn btn-primary-soft btn"></a>
                        </td>
                    </tr>

                </table>
            <?php } else { ?>
                <div><?=$result['message']?></div>
            <?php } ?>
            </div>
        </center>
    </div>
</div>

</html>