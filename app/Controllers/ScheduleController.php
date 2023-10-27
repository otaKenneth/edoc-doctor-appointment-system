<?php
class ScheduleController {

    protected $scheduleSeed, $patientSeed, $appointmentSeed;
    public function __construct() {
        $this->scheduleSeed = new ScheduleModel;
        $this->appointmentSeed = new AppointmentModel;
        $this->patientSeed = new PatientModel;
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

    public function getScheduleDataForBooking($db, $args = []) {
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
                $response['data'] = $sched_data;
            } else {
                $response['success'] = false;
                $response['message'] = "No Schedule Matched.";
            }
        } else {
            $response['message'] = $appo;
        }

        return $response;
    }

    public function getAvailableSessions($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $filter = []; $a = [
            'args' => []
        ];

        if (isset($scheduledate)) {
            $filter['schedule.scheduledate'] = $scheduledate;
        }

        if (isset($search)) {
            $filter[0] = [
                'q' => "(doctor.docname LIKE ? OR doctor.docemail LIKE ? OR schedule.title LIKE ? OR schedule.scheduledate LIKE ?)",
                'value' => "%{$search}%",
                'count' => 4
            ];
        }

        $sessions = $this->scheduleSeed->getAllSessions($db, $a, $filter);
        if (is_object($sessions)) {
            $response['success'] = true;
            $response['message'] = "Schedule Found.";
            $response['data'] = $sessions;
        } else {
            $response['success'] = false;
            $response['message'] = $sessions;
        }
        return $response;
    }
    
}
?>