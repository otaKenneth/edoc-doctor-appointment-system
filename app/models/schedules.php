<?php
class ScheduleModel extends Model {
    public function getSchedules($db, $args = [], $filter = []) {
        try {
            $query = "SELECT 
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
                foreach ($args['filter'] as $colName => $searchVal) {
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
}

?>