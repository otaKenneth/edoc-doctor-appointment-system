<?php
class AdminController {

    protected $appointmentSeed, $scheduleSeed, $patientSeed, $doctorSeed, $webuserSeed, $specialtiesSeed, $uploadsSeed;
    public function __construct() {
        $this->appointmentSeed = new AppointmentModel;
        $this->scheduleSeed = new ScheduleModel;
        $this->patientSeed = new PatientModel;
        $this->doctorSeed = new DoctorModel;
        $this->webuserSeed = new WebuserModel;
        $this->specialtiesSeed = new Specialties;
        $this->uploadsSeed = new UploadsModel;
    }

    public function getAdminsDefaults ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => ""
        ];

        $list11 = [];
        if ($uri == "admin/patient.php") {
            $list11 = $this->patientSeed->getAllPatients($db);
        } else {
            $list11 = $this->doctorSeed->getAllDoctors($db);
        }

        if (is_object($list11)) {
            if ($list11->num_rows > 0) {
                $response['data'] = [];
    
                $table = [];
                foreach ($list11->fetch_all(MYSQLI_ASSOC) as $row) {
                    $name = isset($row['pname']) ? $row['pname']:$row['docname'];
                    $email = isset($row['pemail']) ? $row['pemail']:$row['docemail'];
                    
                    $tRow = [
                        'name' => $name,
                        'email' => $email
                    ];
    
                    $table[] = $tRow;
                }
                $response['data']['search_options'] = $table;
                $response['success'] = true;
            } else {
                $response['success'] = true;
                $response['data']['search_options'] = $list11;
                $response['message'] = "No data.";
            }
        } elseif (is_array($list11) && count($list11) == 0) {
            $response['success'] = true;
            $response['data']['search_options'] = $list11;
            $response['message'] = "No data.";
        } else {
            // string: error message
            $response['success'] = false;
            $response['message'][] = $list11;
        }

        $specialties = $this->specialtiesSeed->getAll($db);
        if (is_object($specialties)) {
            $response['data']['specialties'] = $specialties->fetch_all(MYSQLI_ASSOC);
            $response['success'] = true;
        }

        if (!$response['success']) {
            $response['message'] = "Error: Cannot find values.";
        }

        return $response;
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
            
            if ($appo->num_rows > 0) {
                $row = $appo->fetch_assoc();
                $uploads = $this->uploadsSeed->getUploadByPatientId($db, [
                    $row['pid']
                ]);

                $row['uploads'] = [];
                if ($uploads) {
                    $row['uploads'] = $uploads->fetch_all(MYSQLI_ASSOC);
                }
                
                $response['message'] = "Appointment successfully retrieved.";
                $response['data'] = $row;
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
                $objPrevAppoData = $this->appointmentSeed->getAppointmentDataById($db, [
                    $original
                ])->fetch_assoc();

                $schedules = $this->scheduleSeed->getScheduleByDateAndDoctor($db, [
                    $value['currVal'], $objPrevAppoData['docid']
                ]);


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
            $pid = $row['pid'];

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

            $uploads = $this->uploadsSeed->getUploadByPatientId($db, [
                $pid
            ]);

            $row['uploads'] = [];
            if ($uploads->num_rows > 0) {
                $row['uploads'] = $uploads->fetch_all(MYSQLI_ASSOC);
            }

            $response['data'] = $row;
        } else {
            $response['message'] = $patient;
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

    public function addDoctor ($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        if (count($args) == 0) {
            return $response;
        }

        if ($password !== $cpassword) {
            $response['message'] = "Passwords didn't matched.";
            return $response;
        }
        // check if exist
        $check_result = $this->webuserSeed->getWebuserByEmail($db, [$email]);
        if ($check_result->num_rows > 0) {
            $response['message'] = "Error: This doctor already exist.";
        } else {
            // add new doctor
            $doctor = $this->doctorSeed->create($db, [
                $email, $name, $password, $tele, $spec
            ]);
            
            if (is_numeric($doctor)) {
                $response['message'] = [];
                $response['message'][] = "Doctor has been successfully added.";
                
                $webuser = $this->webuserSeed->create($db, [
                    $email, 'd'
                ]);
                
                if (is_numeric($webuser)) {
                    $response['success'] = true;
                    $response['message'][] = "User {$email} has been added.";
                } else {
                    $response['message'][] = $webuser;
                }
            } else {
                $response['message'] = $doctor;
            }
        }

        return $response;
    }

    public function updateDoctor($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        $errs= 0;
        foreach ($changes as $key => $value) {
            $newVal = $value['currVal'];
            
            $doctor = $this->doctorSeed->updateDoctor($db, [
                $key
            ],[
                $newVal, $original
            ]);

            if (is_string($response['message'])) {
                $response['message'] = [];
            }

            if (is_string($doctor)) {
                $response['message'][] = $doctor;
                $errs += 1;
            } else {
                $response['message'][] = "Doctor's {$key} has been updated.";
            }
        }

        if ($errs === 0) {
            $response['success'] = true;
        }

        return $response;
    }

    public function deleteDoctor($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        // check if exist
        $check_result = $this->doctorSeed->getDoctorById($db, [$id]);
        $doctor_row = $check_result->fetch_assoc();
        if ($check_result->num_rows > 0) {
            // add new doctor
            $doctor = $this->doctorSeed->deleteDoctorById($db, [
                $id
            ]);

            if (is_string($doctor)) {
                $response['message'] = $doctor;
            } else {
                $response['message'] = [];
                $response['message'][] = "Doctor {$doctor_row['docname']} has been deleted.";
                $webuser = $this->webuserSeed->deleteWebuserByEmail($db, [
                    $doctor_row['docemail']
                ]);

                if (is_string($webuser)) { 
                    $response['message'] = $webuser;
                } else {
                    $response['success'] = true;
                    $response['message'][] = "User {$doctor_row['docemail']} has been deleted.";
                }
            }
        } else {
            $response['message'] = "Error: This doctor does not exist.";
        }

        return $response;
    }

    public function uploadPatientFiles ($db, $args = []) {
        if (is_array($args) && count($args) > 0) {
            extract($args);
        } else {
            $args = $_POST;
            extract($args);
        }
        
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        if (isset($deleted)) {
            $filesDeleted = $this->deletePatientUploads($db, [
                'to_delete' => json_decode($deleted),
            ]);

            if ($filesDeleted) {
                $response['success'] = true;
                $response['message'] = $filesDeleted['message'];
            }
        }

        if (is_array($_FILES) && count($_FILES) > 0) {
            $uploadedFiles = $_FILES['file'];
            // Loop through uploaded files and save them to the server
            foreach ($uploadedFiles['tmp_name'] as $key => $tmp_name) {
                $file_name = $uploadedFiles['name'][$key];
                $file_tmp = $tmp_name;
                $file_type = $uploadedFiles['type'][$key];

                // Define a target directory where you want to save the files
                $target_directory = '../../app/uploads/';

                $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $new_filename = md5($file_name) . ".{$extension}";
                // Create the target path (directory + filename)
                $target_path = $target_directory . $new_filename;
                $db_file_path = "app/uploads/" . $new_filename;

                // Move the file to the target path
                move_uploaded_file($file_tmp, $target_path);

                $type = stripos($file_type,'image') > -1 ? "image" : "pdf";
                // You can also insert the file information into a database if needed
                $upload = $this->uploadsSeed->insert($db, [
                    $file_name, $db_file_path, $type, $patient_id
                ]);

                if (is_numeric($upload)) {
                    $response['success'] = true;
                    $response['message'] = "Files Uploaded.";
                } else {
                    $response['message'] = $upload;
                }
            }
        } else {
            if (!$response['success']) {
                if (!is_array($response['message'])) {
                    $response['message'] = [];
                }
                $response['message'][] = "No File(s).";
            }
        }

        return $response;
    }

    public function deletePatientUploads($db, $args = []) {
        extract($args);
        $response = [
            'success' => false,
            'message' => "Error: Something went wrong. Contact your Administrator."
        ];

        foreach ($to_delete as $id) {
            $uploads = $this->uploadsSeed->delete($db, [
                $id,
            ]);

            if (is_string($uploads)) {
                $response['message'] = $uploads;
            } else {
                $response['success'] = true;

                if (!is_array($response['message'])) {
                    $response['message'] = [];
                }
                $response['message'][] = "File [{$id}] has been deleted.";
            }
        }

        return $response;
    }
}

?>