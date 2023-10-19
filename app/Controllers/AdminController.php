<?php
class AdminController {

    protected $appointmentSeed, $scheduleSeed, $patientSeed;
    public function __construct() {
        $this->appointmentSeed = new AppointmentModel;
        $this->scheduleSeed = new ScheduleModel;
        $this->patientSeed = new PatientModel;
    }

    public function getAppointments($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $filter = [];

        if (isset($scheduledate)) {
            $filter['schedule.scheduledate'] = $scheduledate;
        }

        if (isset($docid)) {
            $filter['doctor.docid'] = $docid;
        }

        $schedule = $this->appointmentSeed->getDetailedAppointments($db, [], $filter);

        if (is_object($schedule)) {
            $response['success'] = true;
            $response['message'] = "Appointments Found.";
            $response['data'] = $schedule;
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

    public function updateAppointment ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        foreach ($changes as $key => $value) {
            if ($key == "scheduledate") {
                $schedules = $this->scheduleSeed->getScheduleByDate($db, [
                    $value['currVal']
                ]);

                $objPrevAppoData = $this->appointmentSeed->getAppointmentDataById($db, [
                    $original
                ])->fetch_assoc();

                if ($schedules->num_rows > 0) {
                    $schedule = $schedules->fetch_assoc();
                    
                    $appoid = $objPrevAppoData['appoid'];
                    $schedid = $schedule['scheduleid'];

                    $appointment = $this->appointmentSeed->updateAppointment($db, [
                        $schedid, date('Y-m-d'), $appoid
                    ]);

                    if (is_bool($appointment)) {
                        $response['success'] = true;
                        $response['message'] = "Appointment saved successfully.";
                    } else {
                        $response['message'] = $appointment;
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error: You need to create a Session for the selected date. {$value['currVal']}";
                }
            }
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

    public function cancelAppointment($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $appointment = $this->appointmentSeed->cancelAppointmentById($db, [
            $id
        ]);

        if (is_bool($appointment)) {
            $response['success'] = true;
            $response['message'] = "Appointment has been cancelled.";
        } else {
            $response['message'] = $appointment;
        }

        return $response;
    }

    public function deleteSchedule($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        $schedule = $this->scheduleSeed->deleteScheduleById($db, [
            $id
        ]);

        if (is_string($schedule)) {
            $response['message'] = $schedule;
        } else {
            $response['success'] = true;
            $response['message'] = "Schedule has been deleted.";
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

    public function getPatientData($db, $args = []) {
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
            $row = $patient->fetch_assoc();

            $row["pid"] = "P-".$row['pid'];
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
}

?>