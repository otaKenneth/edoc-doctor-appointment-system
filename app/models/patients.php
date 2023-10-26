<?php

class PatientModel extends Model{

    public function getAllPatients($db) {
        try {
            $query = "SELECT * FROM patient";

            $result = $this->run($db, $query, []);
            if ($result) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create ($database, $args = []) {
        try {
            $newPatientQuery = "INSERT INTO patient (pemail,pname,ppassword, paddress, pdob,ptel,chief_complaint_c,paps) VALUES (?,?,?,?,?,?,?,?);";
            $stmt = $database->prepare($newPatientQuery);
            // Define the data types for each parameter
            $types = "ssssssss"; // Adjust these data types based on your actual data types

            $stmt->bind_param($types, ...$args);
            $stmt->execute();
            return $database->insert_id;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getPatientByEmail($database, $args = []) {
        try {
            $query = "SELECT * FROM patient WHERE pemail = ?";

            $result = $this->run($database, $query, $args);
            if ($result) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getPatientByEmailPass ($db, $args = []) {
        try {
            $query = "SELECT * FROM patient WHERE pemail = ? AND ppassword = ?";
        
            $stmt = $db->prepare($query);
            // Define the data types for each parameter
            $types = "ss"; // Adjust these data types based on your actual data types

            $stmt->bind_param($types, ...$args);
            if ($stmt->execute()) {
                return $stmt->get_result();
            } else {
                return $stmt->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getPatientById($db, $args = []) {
        try {
            $query = "SELECT * FROM patient WHERE pid = ?";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return $result->get_result();
            } else {
                return $result->error;
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getPatientsByDoctorId ($db, $args = [], $filter = []) {
        try {
            $query = "SELECT * FROM appointment 
                INNER JOIN patient on patient.pid=appointment.pid 
                INNER JOIN schedule on schedule.scheduleid=appointment.scheduleid 
                where schedule.docid = ?";
            
            $result = $this->run($db, $query, $args);
            if ($result) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getPatientByScheduleId($db, $args = []) {
        try {
            $query = "SELECT * FROM appointment 
                INNER JOIN patient 
                    on patient.pid=appointment.pid 
                INNER JOIN schedule 
                    on schedule.scheduleid=appointment.scheduleid 
                WHERE schedule.scheduleid=? AND appointment.cancelled = 0";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}