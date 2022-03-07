<?php
// $connection = mysqli_connect('localhost', 'root', '', 'Esl-ology');
$connection = mysqli_connect('esl-ology.com:3306', 'eslology_zaza', 'rufus4', 'eslology_site');
if (!$connection) {
    die("Database connection failed");
}
