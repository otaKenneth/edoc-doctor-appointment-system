<html>
<div id="popup1" class="overlay">
    <div class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">ViewDetails</p>
                <a class="close" href="patient.php">&times;</a>
            </div>
            <div style="display: flex;justify-content: center; max-height: 500px; overflow-y: auto;">
            <?php
                if ($result['success']) {
                    $row = $result['data'];
                    
                    $name=$row["pname"];
                    $email=$row["pemail"];
                    $dob=$row["pdob"];
                    // Convert $dob to a DateTime object
                    $dobDate = new DateTime($dob);

                    // Get the current date
                    $currentDate = new DateTime();

                    // Calculate the age difference
                    $ageInterval = $currentDate->diff($dobDate);

                    // Extract the age from the interval
                    $age = $ageInterval->y;
                    $tele=$row["ptel"];
                    $address=$row["paddress"];
                ?>
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                        <td class="label-td">
                            <label for="name" class="form-label">Patient ID: </label>
                        </td>
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td">
                            P-<?=$id?>
                        </td>
                        <td class="label-td value-td" colspan="2">
                            <?=$name?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td">
                            <?=$email?>
                        </td>
                        <td class="label-td value-td" colspan="2">
                            <?=$tele?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="spec" class="form-label">Address: </label>
                        </td>
                        <td class="label-td">
                            <label for="name" class="form-label">Date of Birth: </label>
                        </td>
                        <td class="label-td">
                            <label for="name" class="form-label">Age: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td">
                            <?=$address?>
                        </td>
                        <td class="label-td value-td">
                            <?=$dob?>
                        </td>
                        <td class="label-td value-td">
                            <?=$age?>
                        </td>
                    </tr>
                    <tr>
                        <form id="patient-diagnosis-form" name="patient-diagnosis-form" method="POST"><td class="label-td" colspan="3">
                            <label for="name" class="form-label">Diagnosis: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td" colspan="3">
                            <textarea class="input-text" name="diagnosis" rows="5" cols="" placeholder="Aa..." required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="3">
                            <label for="name" class="form-label">Diagnostic Request: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td" colspan="3">
                            <textarea class="input-text" name="diagnostic_request" rows="5" cols="" placeholder="Aa..." required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="3">
                            <label for="name" class="form-label">Prescription: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td" colspan="3">
                            <textarea class="input-text" name="prescription" rows="5" cols="" placeholder="Aa..." required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="3">
                            <label for="name" class="form-label">Recommendation: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td value-td" colspan="3">
                            <textarea class="input-text" name="recommendation" rows="5" cols="" placeholder="Aa..." required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input name="pid" value="<?=$row['pid']?>" hidden/>
                            <a href="patient.php">
                                <input 
                                  type="submit" 
                                  value="OK" 
                                  form="patient-diagnosis-form"
                                  name="patient-diagnosis-form-submit"
                                  class="login-btn btn-primary-soft btn"
                                >
                            </a>
                        </td>
                        </form>
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