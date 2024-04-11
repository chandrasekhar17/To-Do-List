<?php

session_start();
if (isset($_SESSION['user'])) {
    header('location: home/index/index.php');
} else {
    header('location: login');
    exit;
}
