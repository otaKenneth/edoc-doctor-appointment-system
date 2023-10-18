<?php
class AdminController {

    protected $appointmentSeed, $scheduleSeed;
    public function __construct() {
        $this->appointmentSeed = new AppointmentModel;
        $this->scheduleSeed = new ScheduleModel;
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
            'message' => ""
        ];

        foreach ($changes as $key => $value) {
            if ($key == "scheduledate") {
                $schedules = $this->scheduleSeed->getScheduleByDate($db, [
                    $value['currVal']
                ]);

                if ($schedules->num_rows == 0) {
                    $response['success'] = false;
                    $response['message'] = "You need to create a Session for the selected date. {$value['currVal']}";
                }
            }
        }

        return $response;
    }

}

?>