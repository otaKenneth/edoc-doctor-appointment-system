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
                spec.sname
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
}