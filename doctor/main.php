<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AuthController.php");

    $auth = new AuthController;
    $result = $auth->getCurrentDoctorUser($database);
    if ($result['success']) {
        $user = $result['data'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://eluvohealth.com/wp-content/uploads/2023/07/favicon-150x150.png" sizes="32x32">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Doctors</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($user['docname'],0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($user['useremail'],0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out"
                                            class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <div id="dash-body-header" style="display: flex; justify-content: space-between; margin-top: 15px; padding-right: 30px;">
                <div><p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">     Dashboard</p></div>
                <div class="search-bar" style="display: flex; align-items: center; width: 50%;">
                    <form action="" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
    
                            <datalist id="doctors">
                        <?php
                        $list11 = $database->query("select  docname,docemail from  doctor;");
    
                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            $d = $row00["docname"];
                            $c = $row00["docemail"];
                        ?>
                            <option value='$d'><br/>
                            <option value='$c'><br/>
                        <?php }; ?>
                        </datalist>
                        <input type="Submit" value="Search" class="login-btn btn-primary btn"
                            style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </div>
                <div style="display: flex; align-items: center;">
                    <div>
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                                date_default_timezone_set('Asia/Kolkata');
    
                                $date = date('Y-m-d');
                                echo $date;
                            ?>
                        </p>
                    </div>
                    <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </div>
            </div>
            <div id="page-content">
                <?php include_once($routes[$clean_uri]); ?>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</body>

</html>