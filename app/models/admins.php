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