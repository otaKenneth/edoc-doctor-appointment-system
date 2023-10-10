<?php
include("connection.php");

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");

// Get the requested URL path
$request_uri = $_SERVER['REQUEST_URI'];
$base_url = '/book-a-consultation/';
$clean_uri = str_replace($base_url, '', $request_uri);

$routes = [
    '' => 'index.html',
];

$active_uri = [
    'doctor/index.php' => [
        'bc' => 'Dashboard',
        'link' => 'index.php'
    ],
    'doctor/appointment.php' => [
        'bc' => 'Appointments',
        'link' => 'appointment.php'
    ],
    'doctor/schedule.php' => [
        'bc' => 'Sessions',
        'link' => 'schedule.php'
    ],
    'doctor/patient.php' => [
        'bc' => 'Patients',
        'link' => 'patient.php'
    ],
];

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
