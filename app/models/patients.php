<?php

class PatientModel {
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
}