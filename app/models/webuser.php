<?php

class WebuserModel extends Model {
    public function create ($database, $args = []) {
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

    public function getWebuserByEmail($db, $args = []) {
        try {
            $query = "SELECT * FROM webuser WHERE email = ?";
            
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

    public function deleteWebuserByEmail($db, $args = []) {
        try {
            $query = "DELETE FROM webuser WHERE email = ?";
            
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