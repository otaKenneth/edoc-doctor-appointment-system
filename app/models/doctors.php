<?php

class DoctorModel extends Model {

    public function create ($db, $args = []) {
        try {
            $query = "INSERT INTO doctor (docemail,docname,docpassword,doctel,specialties) VALUES (?,?,?,?,?)";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return $result->insert_id;
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function updateDoctor ($db, $cols = [], $args = []) {
        try {
            $updtCols = $this->processUpdateCols($cols);
            $query = "UPDATE doctor SET $updtCols WHERE docid = ?";
            
            $result = $this->run($db, $query, $args);
            if ($result) {
                return $result;
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAllDoctors($db, $args = []) {
        try {
            $query = "SELECT * FROM doctor";

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

    public function getDoctorByEmail($db, $args = []) {
        try {
            $query = "SELECT * FROM doctor where docemail = ?";

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

    public function getDoctorByEmailPass ($db, $args = []) {
        try {
            $query = "SELECT * FROM `doctor` WHERE docemail = ? AND docpassword = ?";
        
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

    public function getDoctorById($db, $args = []) {
        try {
            $query = "SELECT d.*, s.sname FROM `doctor` as d
                LEFT JOIN specialties as s
                    ON s.id = d.specialties
                WHERE docid = ?";
        
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

    public function deleteDoctorById($db, $args = []) {
        try {
            $query = "DELETE FROM doctor WHERE docid = ?";

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