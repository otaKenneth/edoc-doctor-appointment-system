<?php

    $database= new mysqli("localhost","u337390497_eluvoedoc","codEovulE23!","u337390497_edoc");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>