<?php

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/patients.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/doctors.php");

class DoctorController {
    public function __construct() {
        $this->patientSeed = new PatientModel;
        $this->doctorSeed = new DoctorModel;
    }

    function getDoctor($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $doctor = $this->doctorSeed->getDoctorByEmail($db, [
            $email
        ]);

        if (is_object($doctor)) {
            $response['success'] = true;
            $response['message'] = "Doctor Found.";
            $response['data'] = $doctor->fetch_assoc();
        } else {
            $response['message'] = $doctor;
        }

        return $response;
    }

    public function getDoctorPatient ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $patient = $this->patientSeed->getPatientById($db, [
            $id
        ]);

        if (is_object($patient)) {
            $response['success'] = true;
            $response['message'] = "Patient Found.";
            $response['data'] = $patient->fetch_assoc();
        } else {
            $response['message'] = $patient;
        }

        return $response;
    }
}
