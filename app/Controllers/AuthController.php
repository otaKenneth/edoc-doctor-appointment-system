<?php
class AuthController {

    protected $patientSeed, $webuserSeed, $adminSeed, $doctorSeed;

    public function __construct() {
        $this->patientSeed = new PatientModel;
        $this->webuserSeed = new WebuserModel;
        $this->adminSeed = new AdminModel;
        $this->doctorSeed = new DoctorModel;

        session_start();
    }
    public function processLogin ($database, $args = []) {
        $result = $this->webuserSeed->getWebuserByEmail($database, [$args[0]]);
        $response = [
            'success' => false,
            'message' => ""
        ];

        if (is_object($result)) {
            $utype = $result->fetch_assoc()['usertype'];
            $checker = false;

            switch ($utype) {
                case 'p':
                    $checker = $this->patientSeed->getPatientByEmailPass($database, $args);
                    break;
                case 'a':
                    $checker = $this->adminSeed->getAdminByEmailPass($database, $args);
                    break;
                case 'd':
                    $checker = $this->doctorSeed->getDoctorByEmailPass($database, $args);
                    break;
            }

            if (is_object($checker)) {
                if ($checker->num_rows == 1) {
                    $response = [
                        'success' => true,
                        'utype' => $utype,
                        'message' => "Successful login.",
                    ];
                } else {
                    $response['message'] = "Wrong Credentials";
                }
            } else {
                $response['message'] = "We can't find any acount associated with this email.";
            }
        } else {
            $response['message'] = $result;
        }

        return $response;
    }

    public function processSignup ($database, $args = []) {
        extract($args);
        $name = $fname." ".$lname;
        $response = [
            'success' => false,
            'message' => ""
        ];
        
        if ($newpassword !== $cpassword) {
            $response['message'] = "Passwords didn't match.";
            return $response;
        }

        $user = $this->webuserSeed->getWebuserByEmail($database, [$email]);

        if (is_object($user)) {
            if ($user->num_rows == 1) {
                $response['message'] = "Already have an account for this Email address.";
            } else {
                $pId = $this->patientSeed->create($database, [
                    $email, $name, $newpassword, $address, $dob, $tele, $chfcomplaint, $paps
                ]);
        
                if (is_numeric($pId)) {
                    $wId = $this->webuserSeed->create($database, [
                        $args[0], 'p'
                    ]);
                    if (is_numeric($wId)) {
                        $response = [
                            'success' => true,
                            'message' => "Successful signup."
                        ];
                    }
                } else {
                    $response['message'] = $pId;
                }
            }
        }

        return $response;
    }

    public function getCurrentUser($db) {        
        $useremail = "";
        $response = [
            'success' => false,
            'message' => ""
        ];
        $result = "Unauthorized.";

        if(isset($_SESSION["user"])){
            if ($_SESSION['user'] !== "") {
                $useremail=$_SESSION["user"];
                
                switch ($_SESSION['usertype']) {
                    case 'a':
                        $result = $this->adminSeed->getAdminByEmail($db, [
                            $useremail
                        ]);
                        break;
                    case 'd':
                        $result = $this->doctorSeed->getDoctorByEmail($db, [
                            $useremail
                        ]);
                        break;
                    case 'p':
                        $result = $this->patientSeed->getPatientByEmail($db, [
                            $useremail
                        ]);
                        break;
                }
            }
        }else{
            $response['message'] = "Unauthorized.";
        }
        
        if (is_object($result)) {
            $response['success'] = true;
            $response['message'] = "Result Found.";
            $response['data'] = $result->fetch_assoc();
            $response['data']['useremail'] = $useremail;
        } else {
            $response['message'] = $result;
        }

        return $response;
    }
}