<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    exit('Connection Failed: '.$conn->connect_error);
}
