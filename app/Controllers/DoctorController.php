<?php

class DoctorController {

    protected $patientSeed, $doctorSeed, $consultationSeed, $scheduleSeed, $appointmentSeed, $uploadsSeed;

    public function __construct() {
        $this->patientSeed = new PatientModel;
        $this->doctorSeed = new DoctorModel;
        $this->consultationSeed = new ConsultationsModel;
        $this->scheduleSeed = new ScheduleModel;
        $this->appointmentSeed = new AppointmentModel;
        $this->uploadsSeed = new UploadsModel;
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

        $patient = $this->patientSeed->getPatientBySchedAndPid($db, [
            $schedule, $id
        ]);

        if (is_object($patient)) {
            $response['success'] = true;
            $response['message'] = "Patient Found.";
            $row = $patient->fetch_assoc();

            $row['uploads'] = [];
            $uploads = $this->uploadsSeed->getUploadByPatientId($db, [
                $row['pid']
            ]);
            if ($uploads) {
                $row['uploads'] = $uploads->fetch_all(MYSQLI_ASSOC);
            }

            $dob=$row["pdob"];
            // Convert $dob to a DateTime object
            $dobDate = new DateTime($dob);

            // Get the current date
            $currentDate = new DateTime();

            // Calculate the age difference
            $ageInterval = $currentDate->diff($dobDate);

            // Extract the age from the interval
            $row['age'] = $ageInterval->y;
            $response['data'] = $row;
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
            $pid, $notes, $diagnosis, $diagnostic_request, $prescription, $recommendation
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

        $schedule = $this->scheduleSeed->getSchedulesByDoctorId($db, [
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

        return $response;
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

        return $response;
    }

    public function getSpecialities($db, $args = []) {
        $response = [
            'success' => false,
            'message' => ""
        ];

        return $response;
    }

    public function getPatientList($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        if (isset($showonly) && $showonly == 'all') {
            $patients = $this->patientSeed->getAllPatients($db);
        } else {
            $patients = $this->patientSeed->getPatientsByDoctorId($db,[
                $docid
            ]);
        }

        if (is_object($patients)) {
            $response['success'] = true;
            $response['message'] = "Patients successfully retrieved.";

            if ($patients->num_rows > 0) {
                $response['data'] = $patients->fetch_all(MYSQLI_ASSOC);
            } else {
                $response['success'] = false;
                $response['message'] = "No Patients Matched.";
            }
        } else {
            $response['message'] = $patients;
        }

        return $response;
    }

    public function getPatientPrevConsultations ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $consultations = $this->consultationSeed->getConsultationsOfPatient($db, [
            $pid
        ]);

        if (is_object($consultations)) {
            $response['success'] = true;
            $response['message'] = "Consultations successfully retrieved.";

            if ($consultations->num_rows > 0) {
                $response['data'] = $consultations->fetch_all(MYSQLI_ASSOC);
            } else {
                $response['success'] = false;
                $response['message'] = "No Consultations Matched.";
            }
        } else {
            $response['message'] = $appo;
        }

        return $response;
    }

    public function getScheduleData($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $schedules = $this->scheduleSeed->getScheduleById($db, [
            $id
        ]);

        if (is_object($schedules)) {
            $response['success'] = true;
            $response['message'] = "Schedule successfully retrieved.";

            if ($schedules->num_rows > 0) {
                $sched_data = $schedules->fetch_assoc();

                $pregs = $this->patientSeed->getPatientByScheduleId($db, [
                    $sched_data['scheduleid']
                ]);

                $sched_data['pregscount'] = $pregs->num_rows;

                if (is_object($pregs)) {
                    $response['data'] = [
                        'schedule_data' => $sched_data,
                        'pregs_data' => $pregs->fetch_all(MYSQLI_ASSOC)
                    ];
                } else {
                    $response['success'] = false;
                    $response['message'] = "No Booked Patient Yet.";
                }
            } else {
                $response['success'] = false;
                $response['message'] = "No Schedule Matched.";
            }
        } else {
            $response['message'] = $appo;
        }

        return $response;
    }

    public function deleteSchedule($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $schedule = $this->scheduleSeed->deleteScheduleById($db, [
            $id
        ]);

        if (is_string($schedule)) {
            $response['message'] = $schedule;
        } else {
            $response['success'] = true;
        }

        return $response;
    }

    public function getDoctorData ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        $doctor = $this->doctorSeed->getDoctorById($db, [
            $id
        ]);

        if (is_object($doctor)) {
            $response['success'] = true;
            $response['message'] = "Doctor successfully retrieved.";

            if ($doctor->num_rows > 0) {
                $response['data'] = $doctor->fetch_assoc();
            } else {
                $response['success'] = false;
                $response['message'] = "No Doctor Matched.";
            }
        } else {
            $response['message'] = $doctor;
        }

        return $response;
    }
}
