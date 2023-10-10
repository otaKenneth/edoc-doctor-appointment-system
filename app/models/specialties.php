<?php

class Specialties extends Model {
    public function get ($db, $args = []) {
        try {
            $query = "SELECT sname FROM specialties WHERE id=?";

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