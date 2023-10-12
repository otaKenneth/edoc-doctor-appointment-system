<?php
class ScheduleModel extends Model {

    public function create($db, $args = []) {
        try {
            $query = "INSERT INTO
                schedule (docid,title,scheduledate,scheduletime,nop) 
                VALUES (?,?,?,?,?)
            ";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return $db->insert_id;
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getSchedules($db, $args = [], $filter = []) {
        try {
            $query = "SELECT 
                    schedule.docid,
                    appointment.appoid,
                    schedule.scheduleid,
                    schedule.title,doctor.docname,
                    patient.pname,
                    schedule.scheduledate,
                    schedule.scheduletime,
                    appointment.apponum,
                    appointment.appodate 
                FROM schedule 
                INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
                INNER JOIN patient ON patient.pid=appointment.pid 
                INNER JOIN doctor ON schedule.docid=doctor.docid
                WHERE doctor.docid=? ";

            if (count($filter) > 0) {
                foreach ($filter as $colName => $searchVal) {
                    $query .= " AND {$colName} = ?";
                    array_push($args, $searchVal);
                }
            }

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

    public function getScheduleById ($db, $args = []) {
        try {
            $query = "SELECT 
                        schedule.scheduleid,
                        schedule.title,
                        doctor.docname,
                        schedule.scheduledate,
                        schedule.scheduletime,
                        schedule.nop 
                    FROM schedule 
                    INNER JOIN doctor ON schedule.docid=doctor.docid  
                    WHERE schedule.scheduleid=?";
            
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

    public function deleteScheduleById($db, $args = []) {
        try {
            $query = "DELETE FROM schedule WHERE scheduleid=?";
            
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

?>