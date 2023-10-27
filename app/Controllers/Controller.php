<?php

include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AdminController.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/AppointmentController.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/DoctorController.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/PatientController.php");
include($_SERVER['DOCUMENT_ROOT'] . "/book-a-consultation/app/Controllers/ScheduleController.php");

$c_admin = new AdminController;
$c_appointment = new AppointmentController;
$c_doctors = new DoctorController;
$c_patient = new PatientController;
$c_schedule = new ScheduleController;

?>