<?php

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/patients.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/webuser.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/admins.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/doctors.php");
class AuthController {

    public function __construct() {
        $this->patientSeed = new PatientModel;
        $this->webuserSeed = new WebuserModel;
        $this->adminSeed = new AdminModel;
        $this->doctorSeed = new DoctorModel;
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
}