<?php
class AppointmentController {

    protected $appointmentSeed;
    public function __construct() {
        $this->appointmentSeed = new AppointmentModel;
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
}
?>