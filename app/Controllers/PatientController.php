<?php   
class PatientController {

    protected $patientSeed, $doctorSeed, $scheduleSeed, $appointmentSeed;
    public function __construct() {
        $this->patientSeed = new PatientModel();
        $this->doctorSeed = new DoctorModel();
        $this->scheduleSeed = new ScheduleModel();
        $this->appointmentSeed = new AppointmentModel();
    }

    public function getPatientDefault($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $table = [];
        $list11 = $this->doctorSeed->getAllDoctors($db);
        $list12 = $this->scheduleSeed->getScheduleByPatientId($db, [
            'args' => [$userid]
        ]);
        if (is_object($list11)) {
            if ($list11->num_rows > 0) {
                $response['data'] = [
                    'doctors' => $list11->num_rows
                ];
    
                foreach ($list11->fetch_all(MYSQLI_ASSOC) as $row) {
                    $name = isset($row['pname']) ? $row['pname']:$row['docname'];
                    $email = isset($row['pemail']) ? $row['pemail']:$row['docemail'];
    
                    $table[] = ['value' => $name, 'type' => 'doctor'];
                    $table[] = ['value' => $email, 'type' => 'doctor'];
                }
                $response['success'] = true;
            } else {
                $response['success'] = true;
                $response['message'] = "No data.";
            }
        } else {
            // string: error message
            $response['success'] = false;
            $response['message'][] = $list11;
        }

        if (is_object($list12)) {
            if ($list12->num_rows > 0) {
                foreach ($list12->fetch_all(MYSQLI_ASSOC) as $row) {
                    $name = $row['title'];
    
                    $table[] = ['value' => $name, 'type' => 'sched'];
                }
                $response['success'] = true;
            } else {
                $response['success'] = true;
                $response['message'] = "No data.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = $list12;
        }

        $response['data']['search_options'] = $table;
        return $response;
    }

    public function getPatientAppointments($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $filter = []; $a = [
            'args' => [$userid]
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

        if (isset($select)) {
            $a['select'] = [
                'appointment.appoid','appointment.apponum','appointment.appodate',
                'schedule.scheduleid',
                'schedule.title',
                'doctor.docname',
                'patient.pname',
                'schedule.scheduledate','schedule.scheduletime'
            ];
        }

        $schedule = $this->scheduleSeed->getScheduleByPatientId($db, $a, $filter);

        if (is_object($schedule)) {
            $response['success'] = true;
            $response['message'] = "Schedule Found.";
            $response['data'] = $schedule;
        } else {
            $response['success'] = false;
            $response['message'] = $schedule;
        }

        return $response;
    }

    public function booknow($db, $args = []) {
        extract($args);
        $response = [
            'success'=> false,
            'message'=> 'Error: Something went wrong. Please contact your administrator.'
        ];

        $appointment = $this->appointmentSeed->create($db, [
            $pid, $scheduleid, $date
        ]);

        $apponum +=1;
        if (!is_string($appointment)) {
            $response['success'] = true;
            $response['message'] = "Your appointment number is {$apponum}";
        } else {
            $response['message'] = $appointment;
        }
        
        return $response;
    }
}
?>