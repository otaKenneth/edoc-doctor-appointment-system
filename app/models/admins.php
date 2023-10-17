<?php

class AdminModel extends Model{

    public function getAdminByEmail($db, $args = []) {
        try {
            $query = "SELECT * FROM `admin` where aemail = ?";

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

    public function getAdminByEmailPass ($db, $args = []) {
        try {
            $query = "SELECT * FROM `admin` WHERE aemail = ? AND apassword = ?";
        
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