<?php

class AppointmentModel extends Model {

    public function create ($db, $args = []) {
        try {
            $lastAppo = $this->getLastAppointment($db)->fetch_assoc();
            $args[] = $lastAppo['apponum'] + 1;

            $query = "INSERT INTO appointment (pid, scheduleid, appodate, apponum) VALUES (?,?,?,?)";

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

    public function updateAppointment ($db, $args = []) {
        try {
            $query = "UPDATE appointment
                SET scheduleid = ?, appodate = ?
                WHERE appoid = ?";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return true;
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getLastAppointment ($db, $args = []) {
        try {
            $query = "SELECT * FROM appointment ORDER BY appoid DESC limit 1";

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
            if ($result) {
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
                WHERE schedule.docid=? AND appointment.cancelled = 0";
            
            $result = $this->run($db, $query, $args);
            if ($result) {
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
                ON schedule.docid=doctor.docid ";

            $query .= "WHERE ";
            $arrFilter = ["appointment.cancelled = 0"];

            if (count($filter) > 0) {
                foreach ($filter as $colName => $searchVal) {
                    $arrFilter[] = "{$colName} = ?";
                    $args[] = $searchVal;
                }
            }
            
            $query .= implode(" AND ", $arrFilter);
            $query .= " ORDER BY schedule.scheduledate DESC";

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

    public function cancelAppointmentById($db, $args = []) {
        try {
            $query = "UPDATE appointment SET cancelled = 1 WHERE appoid = ?";

            $result = $this->run($db, $query, $args);
            if ($result) {
                return true;
            } else {
                return $result->error;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}