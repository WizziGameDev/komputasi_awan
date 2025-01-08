<?php
session_start();
if (isset($_SESSION['username'])) {
    header("location: view/viewDashboard.php");
    exit();
} else {
    header("location: view/viewLogin.php");
    exit();
}