<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/screens.css">
    <link rel="icon" href="https://eluvohealth.com/wp-content/uploads/2023/07/favicon-150x150.png" sizes="32x32">
    <title>Login</title>

    
    
</head>
<body>
    <?php

    //learn from w3schools.com
    //Unset all the server side variables

    //import database
    include("connection.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AuthController.php");

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    // Set the new timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;


    if($_POST){

        $auth = new AuthController;

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $loginResult = $auth->processLogin($database, [
            $email, $password
        ]);

        if ($loginResult['success']) {
            switch ($loginResult['utype']) {
                case 'p':
                    //   Patient dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';

                    header('location: patient/index.php');
                    break;
                case 'a':
                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    
                    header('location: admin/index.php');
                    break;
                case 'd':
                    //   doctor dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');
                    break;
            }
        } else {
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">'.$loginResult['message'].'</label>';
        }
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }

    ?>





    <center>
    <div class="container">
        <table class="form-container" border="0">
            <tr>
                <td>
                    <p class="header-text">Welcome Back!</p>
                </td>
            </tr>
        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Login with your details to continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td">
                    <label for="useremail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <label for="userpassword" class="form-label">Password: </label>
                </td>
            </tr>

            <tr>
                <td class="label-td">
                    <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                </td>
            </tr>


            <tr>
                <td><br>
                <?php echo $error ?>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td>
            </tr>
                        
                        
    
                        
                    </form>
        </table>

    </div>
</center>
</body>
</html>