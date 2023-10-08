<?php
include("connection.php");

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/models/Model.php");

// Get the requested URL path
$request_uri = $_SERVER['REQUEST_URI'];
$base_url = '/book-a-consultation/';
$clean_uri = str_replace($base_url, '', $request_uri);

$include_dir = "";
if (strpos($request_uri, "doctor/") > -1) {
    $include_dir = "doctor/";
    
    // Define a mapping of URLs to PHP files
    $routes = [
        'doctor/index.php' => 'dashboard.php',
        'doctor/appointment.php' => 'doctor/contents/appointment.php',
        'doctor/schedule.php' => 'doctor/contents/schedule.php',
        'doctor/sessions.php' => 'sessions.php',
        // Add more routes as needed
    ];
}

// Check if the requested URL is in the mapping
if (isset($routes[$clean_uri])) {
    include($include_dir . 'main.php');
} else {
    // Handle 404 Not Found
    echo "Page not found!";
}
?>
