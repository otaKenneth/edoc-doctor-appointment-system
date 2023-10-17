<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/connection.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/DoctorController.php");

    $c_doctors = new DoctorController;
    $request = explode("?", $_SERVER['REQUEST_URI'])[0];
    $clean_uri = str_replace("/book-a-consultation/admin/apis/index.php/", "", $request);

    if ($_GET) {
        $input = $_GET;
    } else {
        $jsonPayload = file_get_contents('php://input');
        $input = json_decode($jsonPayload, true); // true to decode as an associative array
    }

    header('Content-Type: application/json');
    $result = $c_doctors->{$clean_uri}($database, $input);

    if (!$result['success']) {
        http_response_code(400);
    }
    echo json_encode($result);
?>