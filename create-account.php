<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/screens.css">
    <link rel="icon" href="https://eluvohealth.com/wp-content/uploads/2023/07/favicon-150x150.png" sizes="32x32">
        
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AuthController.php");

if($_POST){

    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline';");

    $auth = new AuthController;
    $signupResult = $auth->processSignup($database, [
        'fname' => $_SESSION['personal']['fname'],
        'lname' => $_SESSION['personal']['lname'],
        'address' => $_SESSION['personal']['address'],
        'dob' => $_SESSION['personal']['dob'],
        'email' => $_POST['newemail'],
        'tele' => $_POST['tele'],
        'newpassword' => $_POST['newpassword'],
        'cpassword' => $_POST['cpassword'],
        'chfcomplaint' => htmlspecialchars($_POST['chfcomplaint'], ENT_QUOTES, 'UTF-8'),
        'paps'=> $_POST['paps'],
    ]);

    if ($signupResult['success']) {
        $_SESSION["user"]=$args[0];
        $_SESSION["usertype"]="p";
        $_SESSION["username"]=$args[1];

        header('Location: patient/index.php');
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
    } else {
        $error='<label for="promter" class="form-label error-label">'.$signupResult['message'].'</label>';
    }

}else{
    //header('location: signup.php');
    $error='<label for="promter" class="form-label"></label>';
}

?>


    <center>
    <div class="container">
        <table class="form-container" border="0">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">Now Create Your Account.</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email:<span class="required">*</span> </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
                </td>
                
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Mobile Number:<span class="required">*</span> </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="tele" class="input-text"  placeholder="ex: 09171234567" pattern="^09\d{9}$" >
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Create New Password:<span class="required">*</span> </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password:<span class="required">*</span> </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Chief Complaint:<span class="required">*</span> </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <textarea class="input-text" name="chfcomplaint" rows="5" cols="" placeholder="Aa..." required></textarea>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="paps" class="form-label">Interested in our programs and packages? Add them here: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="paps" class="input-text" placeholder="Aa...">
                </td>
            </tr>

            <tr>
                
                <td colspan="2">
                    <?php echo $error ?>

                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>

                    </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>