<?php

class DoctorController {
    public function __construct() {
        $this->patientSeed = new PatientModel;
        $this->doctorSeed = new DoctorModel;
        $this->consultationSeed = new ConsultationsModel;
        $this->scheduleSeed = new ScheduleModel;
        $this->appointmentSeed = new AppointmentModel;
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

    public function saveConsultation($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $consultation = $this->consultationSeed->createConsultation($db, [
            $pid, $diagnosis, $diagnostic_request, $prescription, $recommendation
        ]);

        if (is_numeric($consultation)) {
            $response['success'] = true;
            $response['message'] = "Consultation saved successfully.";
        } else {
            $response['message'] = $consultation;
        }

        return $response;
    }

    public function getDoctorAppointments ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $filter = [];

        if (isset($scheduledate)) {
            $filter = [
                'schedule.scheduledate'=> $scheduledate
            ];
        }

        $schedule = $this->scheduleSeed->getSchedules($db, [
            $userid
        ], $filter);

        if (is_object($schedule)) {
            $response['success'] = true;
            $response['message'] = "Schedule Found.";
            $response['data'] = $schedule;
        } else {
            $response['message'] = $schedule;
        }

        return $response;
    }

    public function addSession($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $schedule = $this->scheduleSeed->create($db, [
            $docid, $title, $date, $time, $nop
        ]);

        if (is_numeric($schedule)) {
            $response['success'] = true;
            $response['message'] = "Schedule saved successfully.";
        } else {
            $response['message'] = $schedule;
        }

        echo json_encode($response);
    }

    public function getAppointmentData ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $appo = $this->appointmentSeed->getAppointmentDataById($db, [
            $id
        ]);

        if (is_object($appo)) {
            $response['success'] = true;
            $response['message'] = "Appointment successfully retrieved.";

            if ($appo->num_rows > 0) {
                $response['data'] = $appo->fetch_assoc();
            } else {
                $response['success'] = false;
                $response['message'] = "No Appointment Matched.";
            }
        } else {
            $response['message'] = $appo;
        }

        echo json_encode($response);
    }

    public function getSpecialities($db, $args = []) {
        $response = [
            'success' => false,
            'message' => ""
        ];

        echo json_encode($response);
    }
}
