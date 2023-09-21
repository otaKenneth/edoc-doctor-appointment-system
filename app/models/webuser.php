<?php

class WebuserModel {
    public function create ($database, $args) {
        try {
            $query = "INSERT INTO webuser VALUES (?, ?)";
            $stmt = $database->prepare($query);
            
            // Define the data types for each parameter
            $types = "ss"; // Adjust these data types based on your actual data types
    
            $stmt->bind_param($types, ...$args);
            $stmt->execute();
            return $database->insert_id;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getWebuserByEmail($db, $args) {
        try {
            $query = "SELECT * FROM webuser WHERE email = ?";
            $stmt = $db->prepare($query);
            // Define the data types for each parameter
            $types = "s"; // Adjust these data types based on your actual data types

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