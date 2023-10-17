<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">

    <tr>
        <td colspan="4" style="padding-top:10px;">
            <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Patients (
                <?php echo $list11->num_rows; ?>)
            </p>
        </td>

    </tr>
    <?php
    if ($_POST) {
        $keyword = $_POST["search"];

        $sqlmain = "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
    } else {
        $sqlmain = "select * from patient order by pid desc";

    }



    ?>

    <tr>
        <td colspan="4">
            <center>
                <div class="abc scroll">
                    <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                        <thead>
                            <tr>
                                <th class="table-headin">


                                    Name

                                </th>
                                <th class="table-headin">


                                    NIC

                                </th>
                                <th class="table-headin">


                                    Telephone

                                </th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">

                                    Date of Birth

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
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';

                            } else {
                                for ($x = 0; $x < $result->num_rows; $x++) {
                                    $row = $result->fetch_assoc();
                                    $pid = $row["pid"];
                                    $name = $row["pname"];
                                    $email = $row["pemail"];
                                    $nic = $row["pnic"];
                                    $dob = $row["pdob"];
                                    $tel = $row["ptel"];

                                    echo '<tr>
                                        <td> &nbsp;' .
                                        substr($name, 0, 35)
                                        . '</td>
                                        <td>
                                        ' . substr($nic, 0, 12) . '
                                        </td>
                                        <td>
                                            ' . substr($tel, 0, 10) . '
                                        </td>
                                        <td>
                                        ' . substr($email, 0, 20) . '
                                         </td>
                                        <td>
                                        ' . substr($dob, 0, 10) . '
                                        </td>
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="?action=view&id=' . $pid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                       
                                        </div>
                                        </td>
                                    </tr>';

                                }
                            }

                            ?>

                        </tbody>

                    </table>
                </div>
            </center>
        </td>
    </tr>



</table>