<?php
include("connection.php");

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");

// Get the requested URL path
$request_uri = $_SERVER['REQUEST_URI'];
$base_url = '/book-a-consultation/';
$clean_uri = str_replace($base_url, '', $request_uri);

include_once("app/config/routes.php");

$include_dir = "";
if (strpos($request_uri, "doctor/") > -1) {
    $include_dir = "doctor/";

    // Define a mapping of URLs to PHP files
    $routes = array_merge($routes, [
        'doctor/index.php' => 'dashboard.php',
        'doctor/appointment.php' => 'contents/appointment.php',
        'doctor/schedule.php' => 'contents/schedule.php',
        'doctor/patient.php' => 'contents/patient.php',
        // Add more routes as needed
    ]);
} elseif (strpos($request_uri, "admin/") > -1) {
    $include_dir = "admin/";

    // Define a mapping of URLs to PHP files
    $routes = array_merge($routes, [
        'admin/index.php' => 'dashboard.php',
        'admin/appointment.php' => 'contents/appointment.php',
        'admin/schedule.php' => 'contents/schedule.php',
        'admin/doctors.php' => 'contents/doctors.php',
        'admin/patient.php' => 'contents/patient.php',
        // Add more routes as needed
    ]);
} elseif (strpos($request_uri, 'patient') > -1) {
    $include_dir = "patient/";

    $routes = array_merge($routes, [
        'patient/index.php' => 'dashboard.php',
        'patient/doctors.php' => 'contents/doctors.php',
        'patient/schedule.php' => 'contents/schedule.php',
        'patient/appointment.php' => 'contents/appointment.php',
        'patient/settings.php' => 'contents/settings.php',
    ]);
}

// Check if the requested URL is in the mapping
if ($clean_uri == "") {
    include("index.html");
} elseif (isset($routes[$clean_uri])) {
    include($include_dir . 'main.php');
} else {
    // Handle 404 Not Found
    echo "Page not found!";
}
?>
