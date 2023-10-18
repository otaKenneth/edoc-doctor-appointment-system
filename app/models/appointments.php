<?php

class AppointmentModel extends Model {
    public function getAppointmentDataById ($db, $args = []) {
        try {
            $query = "SELECT
                appoid,
                apponum, 
                p.pid,
                p.pemail,
                p.pname,
                p.chief_complaint_c,
                p.ptel,
                d.*,
                spec.sname,
                s.title,
                DATE_FORMAT(scheduledate, '%m/%d/%Y') as appodate,
                DATE_FORMAT(scheduledate, '%Y-%m-%d') as scheduledate
            FROM `appointment` AS appo
            LEFT JOIN patient AS p
                ON appo.pid = p.pid
            LEFT JOIN `schedule` AS s
                ON appo.`scheduleid` = s.`scheduleid`
            LEFT JOIN doctor AS d
                ON s.docid = d.docid
            LEFT JOIN `specialties` AS spec
                ON d.`specialties` = spec.id
            WHERE appoid = ?";

            $result = $this->run($db, $query, $args);
            if ($result->execute()) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAppointments ($db, $args = [], $filter = []) {
        try {
            $query = "SELECT * FROM appointment 
                INNER JOIN patient 
                    ON patient.pid=appointment.pid 
                INNER JOIN schedule 
                    ON schedule.scheduleid=appointment.scheduleid 
                WHERE schedule.docid=?";
            
            $result = $this->run($db, $query, $args);
            if ($result->execute()) {
                return $result->get_result();
            } else {
                return $result->error;
            }
            // $userid
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getDetailedAppointments ($db, $args = [], $filter = []) {
        try {
            $query = "SELECT 
                appointment.appoid,
                schedule.scheduleid,
                schedule.title,
                doctor.docname,
                patient.pname,
                schedule.scheduledate,
                schedule.scheduletime,
                appointment.apponum,
                appointment.appodate 
            FROM schedule 
            INNER JOIN appointment 
                ON schedule.scheduleid=appointment.scheduleid 
            INNER JOIN patient 
                ON patient.pid=appointment.pid 
            INNER JOIN doctor 
                ON schedule.docid=doctor.docid";

            if (count($filter) > 0) {
                $query .= "WHERE ";
                $arrFilter = [];
                foreach ($filter as $colName => $searchVal) {
                    $arrFilter = "{$colName} = $searchVal";
                }
                $query .= implode(" AND ", $arrFilter);
            }
            
            $query .= " ORDER BY schedule.scheduledate DESC";

            $result = $this->run($db, $query, $args);
            if ($result->execute()) {
                return $result->get_result();
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}