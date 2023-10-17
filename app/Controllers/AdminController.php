<?php
class AdminController {

    protected $appointmentSeed;
    public function __construct() {
        $this->appointmentSeed = new AppointmentModel;
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

}

?>