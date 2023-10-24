<?php
class UploadsModel extends Model {

    public function insert($db, $args = []) {
        try {
            $query = "INSERT INTO uploads (`filename`,`location`,`type`,patient_id) VALUES (?,?,?,?)";
            
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

    public function getUploadByPatientId ($db, $args = []) {
        try {
            $query = "SELECT * FROM uploads WHERE patient_id = ?";

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

    public function delete($db, $args = []) {
        try {
            $query = "DELETE FROM uploads WHERE id = ?";

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
}
?>