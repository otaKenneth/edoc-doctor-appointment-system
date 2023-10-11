<?php

class Model {
    public function run ($db, $query, $args) {
        $types = $this->processArgs($args);
        $stmt = $db->prepare($query);

        if (count($args) > 0) {
            $stmt->bind_param($types, ...$args);
        }
        
        $stmt->execute();
        return $stmt;
    }

    private function processArgs ($args) {
        $types = "";
        foreach ($args as $value) {
            switch (gettype($value)) {
                case 'integer':
                    $types .= "i";
                    break;
                case 'string':
                    $types .= "s";
                    break;
                case 'double':
                    $types .= "d";
            }
        }
        return $types;
    }
}


include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/patients.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/webuser.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/admins.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/doctors.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/consultations.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/schedules.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/appointments.php");

?>