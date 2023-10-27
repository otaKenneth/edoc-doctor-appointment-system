<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/connection.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/Controller.php");
    
    $request = explode("?", $_SERVER['REQUEST_URI'])[0];
    $rough_uri = str_replace("/book-a-consultation/patient/apis/index.php/", "", $request);
    $arr_uri = explode("/", $rough_uri);
    $class_name = $arr_uri[0];
    $fxn_name = $arr_uri[count($arr_uri) - 1];

    if ($_GET) {
        $input = $_GET;
    } else {
        $jsonPayload = file_get_contents('php://input');
        $input = json_decode($jsonPayload, true); // true to decode as an associative array
    }

    header('Content-Type: application/json');
    try {
        $class = $c_patient;
        if ($class_name == 'Doctors') {
            $class = $c_doctors;
        } elseif ($class_name == 'Appointments') {
            $class = $c_appointment;
        }
        $result = $class->{$fxn_name}($database, $input);
    } catch (\Throwable $th) {
        $result = [
            'success' => false,
            'message' => $th->getMessage(),
        ];
    }

    if (!$result['success']) {
        http_response_code(400);
    }
    echo json_encode($result);
?>