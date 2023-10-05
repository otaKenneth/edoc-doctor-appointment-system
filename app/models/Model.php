<?php

class Model {
    public function run ($db, $query, $args) {
        $types = $this->processArgs($args);
        $stmt = $db->prepare($query);

        $stmt->bind_param($types, ...$args);
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

?>