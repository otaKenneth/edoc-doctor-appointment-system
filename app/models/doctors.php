<?php

class DoctorModel extends Model {

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
            if ($result->execute()) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}