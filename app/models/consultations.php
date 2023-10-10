<?php

class ConsultationsModel extends Model {

    public function createConsultation($db, $args = []) {
        try {
            $query = "INSERT INTO consultations (patient_id, diagnosis, diagnosis_request, prescription, recommendation) VALUES (?,?,?,?,?)";

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

    public function getConsultationsOfPatient($db, $args = []) {
        try {
            $query = "SELECT * FROM `consultations` WHERE patient_id = ?";

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