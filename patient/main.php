<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AuthController.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/Controller.php");
    
    $auth = new AuthController;

    $result = $auth->getCurrentUser($database);
    if ($result['success']) {
        $user = $result['data'];
    }

    $patient_cache = $c_patient->getPatientDefault($database, [
        'uri' => $clean_uri,
        'userid' => $user['pid']
    ]);

    $patient_cache_data = [
        'search_options' => [],
        'specialties' => []
    ];
    if ($patient_cache['success']) {
        $patient_cache_data = $patient_cache['data'];
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
    <link rel="stylesheet" href="../css/toaster.css">
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table,.anime{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>

    <script src="../js/jquery-3.7.1.js"></script>
</head>
<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($user['pname'],0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($user['pemail'],0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home" link-name="Home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor" link-name="Doctors">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></div></a>
                    </td>
                </tr>
                
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session" link-name="Scheduled Sessions">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment" link-name="My Bookings">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings" link-name="Settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="max-height: 100%; overflow-y: auto;">
            <div id="dash-body-header" style="display: flex; justify-content: space-between; margin-top: 15px; padding-right: 30px;">
                <div><p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;"><?=$active_uri[$clean_uri]['bc']?></p></div>
                <div class="search-bar" style="display: flex; align-items: center; width: 50%;">
                    <form action="" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Doctor name / Email / Date (YYYY-MM-DD)" list="mainsearchbox">
                            <datalist id="mainsearchbox">
                            <?php
                            foreach ($patient_cache_data['search_options'] as $row00) {
                                $d = $row00["value"];
                            ?>
                                <option value='<?=$d?>'>
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
    </div>
</body>
<script src="../js/toaster.js"></script>
<script src="../js/utilities.js"></script>
<script>
    var myid = <?=$user['pid']?>;
    var active_uri = "<?=$active_uri[$clean_uri]['bc']?>";
    console.log(active_uri)
</script>
<script src="../js/main.js"></script>
</html>